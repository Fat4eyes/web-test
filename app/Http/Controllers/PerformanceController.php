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

    public function getStudentAttendancesByStudentAndDisciplinePlan($studentId)
    {
        try {
//            $studentAttendance = $this->_performanceManager
//                ->getStudentAttendancesByStudent($studentId);
//            $result = $studentAttendance;

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
            $studentsInfo = $this->_performanceManager->getStudentPerformanceInfo($groupId, $disciplineId);

//            if($studentsInfo == 0)
//                $this->createStudentPerformances($request);
            $result = $studentsInfo;

            return $this->successJSONResponse($result);
        } catch (Exception $exception) {
            return $this->faultJSONResponse($exception->getMessage());
        }
    }

    public function createStudentPerformances(Request $request)
    {
//        try{
//            $planData = $request->json('disciplinePlan');
//            $studyPlanId = $request->json('studyPlanId');
//            $disciplineId = $request->json('disciplineId');
//
//            $disciplinePlan = new DisciplinePlan();
//            $disciplinePlan->fillFromJson($planData);
//            $semester = $disciplinePlan->getSemester();
//            $this->_studyPlanManager->updateDisciplinePlan($disciplinePlan, $studyPlanId, $disciplineId, $semester);
//            return $this->successJSONResponse();
//        } catch (Exception $exception){
//            return $this->faultJSONResponse($exception->getMessage());
//        }

        try {
            $groupId = $request->json('groupId');
            $disciplinePlanId = $request->json('disciplinePlan');
            $students = $request->json('students');
            $studentAttendances = $request->json('studentAttendances');
            $studentProgresses = $request->json('studentProgresses');
            $disciplinePlan = new DisciplinePlan();
            $disciplinePlan = $this->_performanceManager->getDisciplinePlan($disciplinePlanId);
            $y = $disciplinePlan;
            foreach ($students as $student) {

                $studentId = array_shift($student);
//                $studentObject = $this->_performanceManager->getUser
                $studentAttendance = new \StudentAttendance();
                $studentProgress = new \StudentProgress();


                foreach($studentAttendances as $attendance){
                    $studentAttendance->fillFromJson($attendance);
                    $this->_performanceManager->createStudentAttendance($studentAttendance, $studentId, $disciplinePlanId);
                }
                foreach($studentProgresses as $progress){
                    $studentProgress->fillFromJson($progress);
                    $this->_performanceManager->createStudentProgress($studentProgress, $studentId, $disciplinePlanId);
                }

//                $studentAttendance->fillFromJson($studentAttendances);
//                $studentProgress->fillFromJson($studentProgresses);



//                $studentAttendances = $this->_performanceManager
//                    ->setStudentAttendancesByStudent($student->getId(), $disciplinePlanId);
//                $studentProgresses = $this->_performanceManager
//                    ->getStudentProgressesByStudent($student->getId(), $disciplinePlanId);
//
//                $studentPerformance = new StudentPerformanceInfoViewModel($student);
//                $studentPerformance->setStudentAttendances($studentAttendances);
//                $studentPerformance->setStudentProgresses($studentProgresses);

//                $this->_performanceManager->createStudentsPerformance($studentAttendance, $studentProgress, $studentId, $disciplinePlan);

                //array_push($studentPerformanceInfos, $studentPerformance);
            }


            $result = $groupId;

            return $this->successJSONResponse($result);
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