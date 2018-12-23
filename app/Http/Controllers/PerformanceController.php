<?php
/**
 * Created by PhpStorm.
 * User: Zhora
 * Date: 14.12.2018
 * Time: 0:32
 */

namespace App\Http\Controllers;

use App\ViewModels\StudentPerformanceInfoViewModel;
use DisciplinePlan;
use Exception;
use Illuminate\Http\Request;
use Managers\GroupManager;
use Managers\PerformanceManager;

class PerformanceController extends Controller
{
    private $_performanceManager;
    private $_groupManager;

    public function __construct(PerformanceManager $performanceManager)
    {
        $this->_performanceManager = $performanceManager;
    }

    public function getStudentAttendancesByStudentAndDisciplinePlanId(Request $request)
    {
        try {
            $studentId = $request->query('student');
            $disciplineId = $request->query('discipline');

            $studentAttendance = $this->_performanceManager
                ->getStudentAttendancesByStudent($studentId, $disciplineId);
            $result = $studentAttendance;

            return $this->successJSONResponse($result);
        } catch (Exception $exception) {
            return $this->faultJSONResponse($exception->getMessage());
        }
    }

    public function getStudentPerformancesByStudentAndDisciplinePlan(Request $request)
    {
        try {
            $groupId = $request->query('group');
            $disciplineId = $request->query('discipline');
            $studentsInfo = $this->_performanceManager->getStudentsPerformanceInfo($groupId, $disciplineId);

            $result = $studentsInfo;
            return $this->successJSONResponse($result);
        } catch (Exception $exception) {
            return $this->faultJSONResponse($exception->getMessage());
        }
    }

    public function createStudentPerformances(Request $request)
    {
        try {
            $disciplinePlanId = $request->json('disciplinePlan');
            $studentAttendances = $request->json('studentAttendances');
            $studentProgresses = $request->json('studentProgresses');
            $this->_performanceManager->createStudentAttendances($studentAttendances, $disciplinePlanId);
            $this->_performanceManager->createStudentProgresses($studentProgresses, $disciplinePlanId);

            //array_push($studentPerformanceInfos, $studentPerformance);
//            $result = $groupId;

            return $this->successJSONResponse();
        } catch (Exception $exception) {
            return $this->faultJSONResponse($exception->getMessage());
        }
    }

    public function updateStudentPerformances(Request $request)
    {
        try {
            $planData = $request->json('disciplinePlan');
            $studyPlanId = $request->json('studyPlanId');
            $disciplineId = $request->json('disciplineId');

            $disciplinePlan = new DisciplinePlan();
            $disciplinePlan->fillFromJson($planData);
            $semester = $disciplinePlan->getSemester();
            $this->_studyPlanManager->updateDisciplinePlan($disciplinePlan, $studyPlanId, $disciplineId, $semester);
            return $this->successJSONResponse();
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