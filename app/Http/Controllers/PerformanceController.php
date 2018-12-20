<?php
/**
 * Created by PhpStorm.
 * User: Zhora
 * Date: 14.12.2018
 * Time: 0:32
 */

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Managers\GroupManager;
use Managers\PerformanceManager;

class PerformanceController extends Controller
{
    private $_performanceManager;

    public function __construct(PerformanceManager $performanceManager)
    {
        $this->_performanceManager = $performanceManager;
    }

    public function getStudentAttendancesByStudentAndDisciplinePlan($studentId)
    {
        try {
            $studentAttendance = $this->_performanceManager
                ->getStudentAttendancesByStudent($studentId);
            $result = $studentAttendance;

            return $this->successJSONResponse($result);
        } catch (Exception $exception) {
            return $this->faultJSONResponse($exception->getMessage());
        }
}

    public function getStudentAttendancesByStudentAndDisciplinePlanId(Request $request)
    {
        try {
            $studentId = $request->query('student');
            $disciplineId = $request->query('discipline');

            $studentAttendance = $this->_performanceManager
                ->getStudentAttendancesByStudent($studentId);
            $result = $studentAttendance;

            return $this->successJSONResponse($result);
        } catch (Exception $exception) {
            return $this->faultJSONResponse($exception->getMessage());
        }
    }

    public function getStudentProgressesByStudentAndDisciplinePlan($studentId)
    {
        try {
            $studentAttendance = $this->_performanceManager
                ->getStudentAttendancesByStudent($studentId);
            $result = $studentAttendance;

            return $this->successJSONResponse($result);
        } catch (Exception $exception) {
            return $this->faultJSONResponse($exception->getMessage());
        }
    }


    public function getPerformance(Request $request)
    {
        try {
            return $this->successJSONResponse($request);
        } catch (Exception $exception) {
            return $this->faultJSONResponse($exception->getMessage());
        }
    }

    public function getPerformanceByGroupName(Request $request)
    {
        try {
            // $studentData = $request->json('student');
            $groupId = $request->json('groupId');
            $groupId = 1;
            $students = $this->_groupManager->getGroupStudents($groupId);
            return $this->successJSONResponse($students);

        } catch (Exception $exception) {
            return $this->faultJSONResponse($exception->getMessage());
        }
    }


    public function getGroupStudents(Request $groupId)
    {
        try {
            $students = $this->_groupManager->getGroupStudents($groupId);
            return $this->successJSONResponse($students);
        } catch (Exception $exception) {
            return $this->faultJSONResponse($exception->getMessage());
        }
    }


}