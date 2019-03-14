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
        foreach ($students as $student) {
            $studentAttendances = $this->_unitOfWork->studentAttendances()->
            getStudentAttendancesByStudent($student->getId(), $disciplineId);
            $studentProgresses = $this->_unitOfWork->studentProgresses()->
            getStudentProgressesByStudent($student->getId(), $disciplineId);

            $studentInfo = new StudentPerformanceInfoViewModel();
            $studentInfo->setStudent($student);
            $studentInfo->setStudentAttendances($studentAttendances);
            $studentInfo->setStudentProgresses($studentProgresses);

            array_push($studentsInfo, $studentInfo);
        }

        return $studentsInfo;
    }

    public function createStudentPerformances($studentPerformances, $disciplinePlanId)
    {
        $disciplinePlan = $this->_unitOfWork->disciplinePlans()
            ->find($disciplinePlanId);
        foreach ($studentPerformances as $currentPerformance) {
            $studentInfo = new StudentPerformanceInfoViewModel();
            $studentInfo->fillFromJson($currentPerformance);
            $student = new User();
            $student->fillFromJson($studentInfo->getStudent());
            $student = $this->_unitOfWork->Users()
                ->find($student->getId());

            foreach ($studentInfo->getStudentAttendances() as $attendance) {
                $studentAttendance = new StudentAttendance();
                $studentAttendance->fillFromJson($attendance);
                $studentAttendance->setStudent($student);
                $studentAttendance->setDisciplinePlan($disciplinePlan);
                $this->_unitOfWork->studentProgresses()->create($studentAttendance);
                $this->_unitOfWork->commit();
            }
            foreach ($studentInfo->getStudentProgresses() as $progress) {
                $studentProgress = new StudentProgress();
                $studentProgress->fillFromJson($progress);
                $studentProgress->setExtraFields(implode(',',$studentProgress->getExtraFields()));
                $studentProgress->setStudent($student);
                $studentProgress->setDisciplinePlan($disciplinePlan);
                $this->_unitOfWork->studentProgresses()->create($studentProgress);
                $this->_unitOfWork->commit();
            }
        }
    }

    public function updateStudentPerformances($studentPerformances, $disciplinePlanId)
    {

        $disciplinePlan = $this->_unitOfWork->disciplinePlans()
            ->find($disciplinePlanId);
        foreach ($studentPerformances as $currentPerformance) {
            $studentInfo = new StudentPerformanceInfoViewModel();
            $studentInfo->fillFromJson($currentPerformance);
            $student = new User();
            $student->fillFromJson($studentInfo->getStudent());
            $student = $this->_unitOfWork->Users()
                ->find($student->getId());

            foreach ($studentInfo->getStudentAttendances() as $attendance) {
                $studentAttendance = new StudentAttendance();
                $studentAttendance->fillFromJson($attendance);
                $studentAttendance->setStudent($student);
                $studentAttendance->setDisciplinePlan($disciplinePlan);
                $this->_unitOfWork->studentProgresses()->update($studentAttendance);
                $this->_unitOfWork->commit();
            }
            foreach ($studentInfo->getStudentProgresses() as $progress) {
                $studentProgress = new StudentProgress();
                $studentProgress->fillFromJson($progress);
                $studentProgress->setExtraFields(implode(',',$studentProgress->getExtraFields()));
                $studentProgress->setStudent($student);
                $studentProgress->setDisciplinePlan($disciplinePlan);
                $this->_unitOfWork->studentProgresses()->update($studentProgress);
                $this->_unitOfWork->commit();
            }
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

    /**
     * @param UnitOfWork $unitOfWork
     */
    public function setUnitOfWork($unitOfWork)
    {
        $this->_unitOfWork = $unitOfWork;
    }


}