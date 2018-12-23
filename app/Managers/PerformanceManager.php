<?php
/**
 * Created by PhpStorm.
 * User: Zhora
 * Date: 14.12.2018
 * Time: 0:12
 */

namespace Managers;


use App\ViewModels\StudentPerformanceInfoViewModel;
use Repositories\UnitOfWork;
use StudentAttendance;
use StudentProgress;
use User;


class PerformanceManager
{
    private $_unitOfWork;

    public function __construct(UnitOfWork $unitOfWork)
    {
        $this->_unitOfWork = $unitOfWork;
    }


    public function getStudentAttendancesByStudent($studentId, $disciplineId)
    {
        return $this->_unitOfWork->studentAttendances()->getStudentAttendancesByStudent($studentId, $disciplineId);

//        return $this->_unitOfWork->studentAttendances()->find($studentId)->getStudentAttendancesByStudent($studentId);
    }

    public function getStudentProgressesByStudent($studentId, $disciplineId)
    {
        return $this->_unitOfWork->studentProgresses()->getStudentProgressesByStudent($studentId, $disciplineId);
    }

    public function getGroupStudents($groupId)
    {
        return $this->_unitOfWork->users()->getGroupStudents($groupId);
    }

    public function getDisciplinePlan($disciplinePlanId)
    {
        return $this->_unitOfWork->disciplinePlans()->find($disciplinePlanId);
    }

    public function getStudentsPerformanceInfo($groupId, $disciplineId)
    {
        $students = $this->_unitOfWork->users()->getGroupStudents($groupId);
        $studentsInfo = [];
        $studentsPerformanceCount = 0;
        foreach ($students as $student) {
            $studentAttendances = $this->_unitOfWork->studentAttendances()->getStudentAttendancesByStudent($student->getId(), $disciplineId);
            $studentProgresses = $this->_unitOfWork->studentProgresses()->getStudentProgressesByStudent($student->getId(), $disciplineId);

            if(count($studentProgresses) != 0 && count($studentProgresses) != 0)
                  $studentsPerformanceCount++;
            $studentInfo = new StudentPerformanceInfoViewModel($student);
            $studentInfo->setStudentAttendances($studentAttendances);
            $studentInfo->setStudentProgresses($studentProgresses);

            array_push($studentsInfo, $studentInfo);
        }

        return $studentsInfo;
    }

    //проверка есть ли посещаемость студента в БД
    public function createStudentsPerformance(\StudentAttendance $studentAttendance, \StudentProgress $studentProgress, $studentId, $disciplinePlanId)
    {
        $student = $this->_unitOfWork->users()->find($studentId);
        $disciplinePlan = $this->_unitOfWork->disciplinePlans()->find($disciplinePlanId);

        $studentAttendance->setStudent($student);
        $studentAttendance->setDisciplinePlan($disciplinePlan);
        $studentProgress->setStudent($student);
        $studentProgress->setDisciplinePlan($disciplinePlan);

        $this->_unitOfWork->studentAttendances()->create($studentAttendance);
        $this->_unitOfWork->studentProgresses()->create($studentProgress);

        $this->_unitOfWork->commit();
    }


    public function createStudentAttendances($studentAttendances, $disciplinePlanId)
    {
        foreach ($studentAttendances as $currentAttendance) {
            $studentAttendance = new StudentAttendance();
            $studentAttendance->fillFromJson($currentAttendance);

            $student = new User();
            $student->fillFromJson($studentAttendance->getStudent());
            $disciplinePlan = $this->_unitOfWork->disciplinePlans()
                ->find($disciplinePlanId);
            $student = $this->_unitOfWork->Users()
                ->find($student->getId());

            $studentAttendance->setStudent($student);
            $studentAttendance->setDisciplinePlan($disciplinePlan);

            $this->_unitOfWork->studentAttendances()->create($studentAttendance);
            $this->_unitOfWork->commit();
        }
    }

    public function createStudentProgresses($studentProgresses, $disciplinePlanId)
    {
        foreach ($studentProgresses as $currentProgress) {
            $studentProgress = new StudentAttendance();
            $studentProgress->fillFromJson($currentProgress);

            $student = new User();
            $student->fillFromJson($studentProgress->getStudent());
            $disciplinePlan = $this->_unitOfWork->disciplinePlans()
                ->find($disciplinePlanId);
            $student = $this->_unitOfWork->Users()
                ->find($student->getId());

            $studentProgress->setStudent($student);
            $studentProgress->setDisciplinePlan($disciplinePlan);

            $this->_unitOfWork->studentProgresses()->create($studentProgress);
            $this->_unitOfWork->commit();
        }
    }

    public function createStudentAttendance(StudentAttendance $studentAttendance, $studentId, $disciplinePlanId)
    {
        $disciplinePlan = $this->_unitOfWork->disciplinePlans()->find($disciplinePlanId);
        $student = $this->_unitOfWork->Users()->find($studentId);

        $studentAttendance->setStudent($student);
        $studentAttendance->setDisciplinePlan($disciplinePlan);

        $this->_unitOfWork->studentAttendances()->create($studentAttendance);
        $this->_unitOfWork->commit();
    }

    public function createStudentProgress(StudentProgress $studentProgress, $studentId, $disciplinePlanId)
    {
        $disciplinePlan = $this->_unitOfWork->disciplinePlans()->find($disciplinePlanId);
        $student = $this->_unitOfWork->Users()->find($studentId);

        $studentProgress->setStudent($student);
        $studentProgress->setDisciplinePlan($disciplinePlan);

        $this->_unitOfWork->studentProgresses()->create($studentProgress);
        $this->_unitOfWork->commit();
    }

    public function updateStudentsAttendances(Array $studentPerformanceInfos)
    {


        foreach ($studentPerformanceInfos as $studentInfo) {
            $this->_unitOfWork->studentAttendances()->update($studentInfo->getStudentAttendances());
            $this->_unitOfWork->studentProgresses()->update($studentInfo->getStudentProgresses());
            $this->_unitOfWork->commit();
        }

//        $disciplinePlanId = $disciplinePlan->getid();
//        $existingSemesterDisciplinePlan = $this->_unitOfWork->disciplinePlans()
//            ->where("DisciplinePlan.studyplan = $studyPlanId
//            AND DisciplinePlan.discipline = $disciplineId
//            AND DisciplinePlan.semester = $semester
//            AND DisciplinePlan.id != $disciplinePlanId");
//
//        if (!empty($existingSemesterDisciplinePlan)){
//            throw new Exception("Указанный семестр данной дисциплины  уже содержится в учебном плане!");
//        }
//        $studyPlan = $this->_unitOfWork->studyPlans()->find($studyPlanId);
//        $discipline = $this->_unitOfWork->disciplines()->find($disciplineId);
//        $disciplinePlan->setStudyplan($studyPlan);
//        $disciplinePlan->setDiscipline($discipline);
//
//        $this->_unitOfWork->disciplinePlans()->update($disciplinePlan);
//        $this->_unitOfWork->commit();
    }

    /**
     * @param UnitOfWork $unitOfWork
     */
    public function setUnitOfWork($unitOfWork)
    {
        $this->_unitOfWork = $unitOfWork;
    }

//    public function getAttendancesStudent(Group $group, $studyPlanId){
//        $studyplan = $this->_unitOfWork->studyPlans()->find($studyPlanId);
//        $group->setStudyplan($studyplan);
//
//        $this->_unitOfWork->groups()->create($group);
//        $this->_unitOfWork->commit();
//    }

}