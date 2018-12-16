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
    private $_groupManager;

    public function __construct(PerformanceManager $performanceManager, GroupManager $groupManager)
    {
        $this->_performanceManager = $performanceManager;
        $this->_groupManager = $groupManager;
    }

    public function getStudentsPerformanceByDisciplineAndGroup(){

    }

    public function getPerformance(Request $request){
       // $this->getStudentsPerformanceByDisciplineAndGroup();
        try{
            return $this->successJSONResponse($request);
        } catch (Exception $exception){
            return $this->faultJSONResponse($exception->getMessage());
        }
    }

    public function getPerformanceByGroupName(Request $request){
        try{
           // $studentData = $request->json('student');
            $groupId = $request->json('groupId');
            $groupId = 1;
            $students = $this->_groupManager->getGroupStudents($groupId);
            return $this->successJSONResponse($students);

//            $pageSize = $request->query('pageSize');
//            $studyplanId = $request->query('studyplan');
//            $name = $request->query('name');
//            $attendances = $this->_performanceManager->getStudentAttendancesByStudent($studentId);
//            $students = $this->g
//
//            return $this->successJSONResponse($attendances);
        } catch (Exception $exception){
            return $this->faultJSONResponse($exception->getMessage());
        }
    }


    public function getGroupStudents(Request $groupId){
        try{
            $students = $this->_groupManager->getGroupStudents($groupId);
            return $this->successJSONResponse($students);
        } catch (Exception $exception){
            return $this->faultJSONResponse($exception->getMessage());
        }
    }


}