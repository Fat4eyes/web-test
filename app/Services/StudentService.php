<?php

namespace Services;

use Group;
use Exception;
use Repositories\UnitOfWork;
use Doctrine\ORM\EntityManager;

class StudentService
{
    private $_entityManager;
    private $_unitOfWork;

    public function __construct(EntityManager $entityManager, UnitOfWork $unitOfWork)
    {
        $this->_entityManager = $entityManager;
        $this->_unitOfWork = $unitOfWork;
    }

    public function transferStudentsToGroup($studentIds, $groupId)
    {
        foreach ($studentIds as $studentId)
        {
            $student = $this->_unitOfWork->users()
                ->find($studentId);

            if ($student == null) {
                throw new Exception("Студент не найден. Идентификатор студента: $studentId.");
            }

            $group = $this->_unitOfWork->groups()
                ->find($groupId);

            if ($group == null) {
                throw new Exception("Группа не найдена. Идентификатор группы: $groupId.");
            }

            $studentGroup = $this->_unitOfWork->studentGroups()
                ->getByStudentId($studentId);

            $oldGroup = $studentGroup->getGroup();

            $studentGroup->setGroup($group);
            $this->_entityManager->flush($studentGroup);

            // Если в группе больше не осталось студентов, удаляем ее.
            if (count($this->_unitOfWork->users()->getGroupStudents($oldGroup->getId())) === 0) {
                $this->removeGroup($oldGroup);
            }
        }
    }

    public function transferAllToNextCourse() {
        $students = $this->_unitOfWork->users()
            ->getStudentsWhichCanTransferToNextCourse();
        foreach ($students as $student) {
            try {
                $this->transferStudentToNextCourse($student);
            } catch (Exception $exception) { }
        }
    }

    public function transferToNextCourse($studentIds)
    {
        $group = null;
        $newGroup = null;

        foreach ($studentIds as $studentId)
        {
            $student = $this->_unitOfWork->users()
                ->find($studentId);

            if ($student == null) {
                throw new Exception("Студент не найден. Идентификатор студента: $studentId.");
            }

            $studentGroup = $this->_unitOfWork->studentGroups()
                ->getByStudentId($studentId);

            if ($studentGroup == null) {
                throw new Exception("Группа не найдена. Идентификатор студента: $studentId.");
            }

            $group = $studentGroup->getGroup();

            // TODO: Create constant.
            if ($group->getCourse() >= 4) {
                throw new Exception(
                    "Не удалось перевести студента на следующий курс. " .
                    "Курс студента: ". $group->getCourse() . ". " .
                    "Идентификатор студента: $studentId.");
            }

            // Если группа, в которую будет осуществляется перевод, еще не существует.
            if ($this->getNextGroup($group) == null) {
                // Создаем ее.
                $newGroup = $this->createNextGroup($group);
                // Сохраняем.
                $this->_entityManager->persist($newGroup);
                $this->_entityManager->flush();
            } else {
                // Если группа уже есть, то используем ее.
                $newGroup = $this->getNextGroup($group);
            }

            $studentGroup->setGroup($newGroup);
            $this->_entityManager->flush($studentGroup);
        }

        // Если в группе больше не осталось студентов, удаляем ее.
        if (count($this->_unitOfWork->users()->getGroupStudents($group->getId())) === 0) {
            $this->removeGroup($group);
        }

        return $newGroup;
    }

    private function transferStudentToNextCourse($student)
    {
        $studentId = $student->getId();

        $studentGroup = $this->_unitOfWork->studentGroups()
            ->getByStudentId($studentId);

        if ($studentGroup == null) {
            throw new Exception("Группа не найдена. Идентификатор студента: $studentId.");
        }

        $group = $studentGroup->getGroup();

        if ($group->getCourse() >= 4) {
            return;
        }

        // Если группа, в которую будет осуществляется перевод, еще не существует.
        if ($this->getNextGroup($group) == null) {
            // Создаем ее.
            $newGroup = $this->createNextGroup($group);
            // Сохраняем.
            $this->_entityManager->persist($newGroup);
            $this->_entityManager->flush();
        } else {
            // Если группа уже есть, то используем ее.
            $newGroup = $this->getNextGroup($group);
        }

        $studentGroup->setGroup($newGroup);
        $this->_entityManager->flush($studentGroup);

        // Если в группе больше не осталось студентов, удаляем ее.
        if (count($this->_unitOfWork->users()->getGroupStudents($group->getId())) === 0) {
            $this->removeGroup($group);
        }
    }

    private function createNextGroup(Group $model) {
        $group = new Group();
        $group->setCourse($model->getCourse() + 1);
        $group->setIsFulltime($model->getIsFulltime());
        $group->setPrefix($model->getPrefix());
        $group->setName($model->getName());
        $group->setNumber($model->getNumber());
        $group->setStudyplan($model->getStudyplan());
        $group->setYear($model->getYear());
        $group->setName($this->generateName($group));
        return $group;
    }

    private function generateName(Group $group) {
        $number = $group->getCourse() . $group->getNumber();
        return  $group->getPrefix() . "-" . $number . $this->getMode($group);
    }

    private function getMode(Group $group) {
        return $group->getIsFulltime() ? "о" : "з";
    }

    private function getNextGroup(Group $group) {
        $year = $group->getYear();
        $number = $group->getNumber();
        $course = $group->getCourse() + 1;
        $prefix = $group->getPrefix();
        return $this->_unitOfWork->groups()
            ->findBy($year, $course, $prefix, $number);
    }

    private function removeGroup(Group $group) {
        $this->_entityManager->remove($group);
        $this->_entityManager->flush();
    }
}