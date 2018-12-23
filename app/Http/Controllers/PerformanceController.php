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
            $studentPerformances = $request->json('studentPerformances');
            $this->_performanceManager->createStudentPerformances($studentPerformances, $disciplinePlanId);

            return $this->successJSONResponse();
        } catch (Exception $exception) {
            return $this->faultJSONResponse($exception->getMessage());
        }
    }

    public function updateStudentPerformances(Request $request)
    {
        try {
            $disciplinePlanId = $request->json('disciplinePlan');
            $studentPerformances = $request->json('studentPerformances');
            $this->_performanceManager->updateStudentPerformances($studentPerformances, $disciplinePlanId);

            return $this->successJSONResponse();
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