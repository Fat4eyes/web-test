<?php

namespace Managers;

use DateTime;
use Exception;
use Group;
use Repositories\UnitOfWork;
use StudentGroup;
use TestEngine\GlobalTestSettings;
use User;
use UserRole;

class GroupManager
{
    private $_unitOfWork;

    public function __construct(UnitOfWork $unitOfWork)
    {
        $this->_unitOfWork = $unitOfWork;
    }

    public function getAll(){
        return $this->_unitOfWork->groups()->all();
    }

    public function getProfileGroupsByNamePaginated($pageNum, $pageSize, $name, $profileId){
        return $this->_unitOfWork->groups()
            ->getByNameAndProfilePaginated($pageSize, $pageNum, $profileId, $name);
    }

    public function getGroup($id){
        return $this->_unitOfWork->groups()->find($id);
    }

    public function getGroupStudyPlan($id){
        return $this->_unitOfWork->groups()->find($id)->getStudyplan();
    }

    public function addGroup(Group $group, $studyPlanId){
        $studyplan = $this->_unitOfWork->studyPlans()->find($studyPlanId);
        $group->setStudyplan($studyplan);

        $this->_unitOfWork->groups()->create($group);
        $this->_unitOfWork->commit();
    }

    public function updateGroup(Group $group, $studyPlanId){
        $studyplan = $this->_unitOfWork->studyPlans()->find($studyPlanId);
        $group->setStudyplan($studyplan);

        $this->_unitOfWork->groups()->update($group);
        $this->_unitOfWork->commit();
    }



    public function deleteGroup($groupId){
        $group = $this->_unitOfWork->groups()->find($groupId);
        if ($group != null){
            $studentsInGroupCount = $this->_unitOfWork->users()->getGroupStudentsCount($groupId);

            if ($studentsInGroupCount > 0){
                throw new Exception('Невозможно удалить группу, в которой есть студенты.');
            }

            $this->_unitOfWork->groups()->delete($group);
            $this->_unitOfWork->commit();
        }
    }

    // Работа со студентами группы
    public function getGroupStudents($groupId){
        return $this->_unitOfWork->users()->getGroupStudents($groupId);
    }

    public function setStudentGroup($groupId, $studentId){
        $existingUserGroupId = $this->_unitOfWork->studentGroups()->getUserGroup($studentId);
        if(isset($existingUserGroupId)) {
            $this->_unitOfWork->groups()->
            setStudentsGroup($studentId, $groupId);
        }
        else {
           $studentGroup = new \StudentGroup();
            $group = $this->_unitOfWork->groups()->find($groupId);
            $student = $this->_unitOfWork->users()->find($studentId);
            if(!isset($group) || !isset($student)){
                throw new \Exception('Ошибка: Невозможно назначить группу студенту.');
            }

            $studentGroup->setGroup($group);
            $studentGroup->setStudent($student);
            $this->_unitOfWork->studentGroups()->create($studentGroup);

        }

        $this->_unitOfWork->commit();
    }


    public function addStudent(User $student, $groupId){
        $student->setPassword(bcrypt($student->getPassword()));

        $this->_unitOfWork->users()->create($student);
        $this->_unitOfWork->commit();

        $studentId = $student->getId();
        $role = $this->_unitOfWork->roles()->getBySlug(UserRole::Student);
        if (!isset($role)){
            throw new Exception('Невозможно найти роль пользователя '.UserRole::Student);
        }
        $this->_unitOfWork->users()->setUserRole($studentId, $role->getId());

        $group = $this->_unitOfWork->groups()->find($groupId);
        if (!isset($group)){
            throw new Exception('Указанная группа не найдена!');
        }
        $userGroupLink = new StudentGroup();
        $userGroupLink->setGroup($group);
        $userGroupLink->setStudent($student);
        $this->_unitOfWork->studentGroups()->create($userGroupLink);

        $this->_unitOfWork->commit();
    }

    public function updateStudent(User $student, $groupId){
        /** @var User $oldUser */
        $oldUser = $this->_unitOfWork->users()->find($student->getId());
        if (!isset($oldUser)){
            throw new Exception('Невозможно обновить данные студента! Учётная запись не найдена!');
        }
        $oldUser->setActive($student->getActive());
        $oldUser->setEmail($student->getEmail());
        $oldUser->setFirstname($student->getFirstname());
        $oldUser->setPatronymic($student->getPatronymic());
        $oldUser->setLastname($student->getLastname());

        $this->_unitOfWork->users()->update($oldUser);
        $studentId = $student->getId();

        $this->_unitOfWork->groups()
            ->setStudentsGroup($studentId, $groupId);
        $this->_unitOfWork->commit();
    }

    public function deleteStudent($studentId){
        $student = $this->_unitOfWork->users()->find($studentId);

        if ($student != null){
            $this->_unitOfWork->users()->delete($student);
            $this->_unitOfWork->commit();
        }
    }

    /**
     * Принять заявки на регистрацию сразу всей группы.
     * @param $groupId - Идентификатор группы.
     * @throws Exception
     */
    public function acceptAll($groupId){
        $groupStudents = $this->_unitOfWork
            ->users()
            ->getGroupStudents($groupId);

        if (!isset($groupStudents) || empty($groupStudents)){
            throw new Exception("Не найдены студенты указанной группы!");
        }

        /** @var User $student */
        foreach ($groupStudents as $student){
            $student->setActive(true);
            $this->_unitOfWork->users()->update($student);
        }

        $this->_unitOfWork->commit();
    }

    /**
     * Проверка факта наличия в группе студентов с неподтверждёнными учётными записями.
     */
    public function isContainUnactiveStudents($groupId){
        $unactiveStudents = $this->_unitOfWork->users()->getGroupUnactiveStudentsIds($groupId);

        return count($unactiveStudents) > 0;
    }
}