<?php
/**
 * Created by PhpStorm.
 * User: Zhora
 * Date: 13.12.2018
 * Time: 19:07
 */

namespace App\ViewModels;


use BaseEntity;
use JsonSerializable;

class StudentPerformanceInfoViewModel extends BaseEntity implements JsonSerializable
{
    protected $student;
    protected $studentAttendances;
    protected $studentProgresses;


    public function __construct()
    {
    }

    function jsonSerialize()
    {
        return array(
            'student' => $this->student,
            'studentAttendances' => $this->studentAttendances,
            'studentProgresses' => $this->studentProgresses
        );
    }

    /**
     * @return mixed
     */
    public function getStudent()
    {
        return $this->student;
    }

    /**
     * @param mixed $student
     */
    public function setStudent($student)
    {
        $this->student = $student;
    }

    /**
     * @return mixed
     */
    public function getStudentAttendances()
    {
        return $this->studentAttendances;
    }

    /**
     * @param mixed $studentAttendances
     */
    public function setStudentAttendances($studentAttendances)
    {
        $this->studentAttendances = $studentAttendances;
    }

    /**
     * @return mixed
     */
    public function getStudentProgresses()
    {
        return $this->studentProgresses;
    }

    /**
     * @param mixed $studentProgresses
     */
    public function setStudentProgresses($studentProgresses)
    {
        $this->studentProgresses = $studentProgresses;
    }
}