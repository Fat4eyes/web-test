<?php
/**
 * Created by PhpStorm.
 * User: Zhora
 * Date: 14.12.2018
 * Time: 0:12
 */

namespace Managers;


use Repositories\UnitOfWork;


class PerformanceManager
{
    private $_unitOfWork;

    public function __construct(UnitOfWork $unitOfWork)
    {
        $this->_unitOfWork = $unitOfWork;
    }

    public function getDisciplineGroupByGroupId($groupId){
            return $this->_unitOfWork->disciplineGroups()->getDisciplineGroupByGroupId($groupId);
    }

    public function getStudentAttendancesByStudent($studentId){
        return $this->_unitOfWork->studentAttendances()->getStudentAttendancesByStudent($studentId);

//        return $this->_unitOfWork->studentAttendances()->find($studentId)->getStudentAttendancesByStudent($studentId);
    }

    public function getStudentProgressesByStudent($studentId){
        return $this->_unitOfWork->studentAttendances()->find($studentId)->getStudentProgressesByStudent($studentId);
    }

//    public function getAttendancesStudent(Group $group, $studyPlanId){
//        $studyplan = $this->_unitOfWork->studyPlans()->find($studyPlanId);
//        $group->setStudyplan($studyplan);
//
//        $this->_unitOfWork->groups()->create($group);
//        $this->_unitOfWork->commit();
//    }

}