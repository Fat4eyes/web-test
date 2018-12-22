<?php
/**
 * Created by PhpStorm.
 * User: Zhora
 * Date: 13.12.2018
 * Time: 19:07
 */

namespace App\ViewModels;


use JsonSerializable;

class StudentPerformanceInfoViewModel implements JsonSerializable
{
    protected $student;
    protected $studentAttendances;
    protected $studentProgresses;


    public function __construct($student)
    {
        $this->student = $student;
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
//
//
//    private $_test;
//
//    private $_attemptsLeft;
//
//    private $_attemptsMade;
//
//    private $_lastMark;
//
//    /**
//     * @return mixed
//     */
//    public function getTest()
//    {
//        return $this->_test;
//    }
//
//    /**
//     * @param mixed $test
//     */
//    public function setTest($test)
//    {
//        $this->_test = $test;
//    }
//
//    /**
//     * @return mixed
//     */
//    public function getAttemptsLeft()
//    {
//        return $this->_attemptsLeft;
//    }
//
//    /**
//     * @param mixed $attemptsLeft
//     */
//    public function setAttemptsLeft($attemptsLeft)
//    {
//        $this->_attemptsLeft = $attemptsLeft;
//    }
//
//    /**
//     * @return mixed
//     */
//    public function getAttemptsMade()
//    {
//        return $this->_attemptsMade;
//    }
//
//    /**
//     * @param mixed $attemptsMade
//     */
//    public function setAttemptsMade($attemptsMade)
//    {
//        $this->_attemptsMade = $attemptsMade;
//    }
//
//    /**
//     * @return mixed
//     */
//    public function getLastMark()
//    {
//        return $this->_lastMark;
//    }
//
//    /**
//     * @param mixed $maxMark
//     */
//    public function setLastMark($maxMark)
//    {
//        $this->_lastMark = $maxMark;
//    }
//
//
//    function jsonSerialize()
//    {
//        return array(
//            'test' => $this->_test,
//            'attemptsMade' => $this->_attemptsMade,
//            'attemptsLeft' => $this->_attemptsLeft,
//            'lastMark' => $this->_lastMark,
//        );
//    }
//
//
//    ////////////////////////////////    USER viewmodel
//    private $id;
//
//    private $firstName;
//
//    private $middleName;
//
//    private $lastName;
//
//    private $email;
//
//    private $active;
//
//    private $role;
//
//    private $group;
//
//    /**
//     * @param User $user
//     */
//    public function fillFromUser(User $user)
//    {
//        $this->id = $user->getId();
//        $this->firstName = $user->getFirstname();
//        $this->middleName = $user->getPatronymic();
//        $this->lastName = $user->getLastname();
//        $this->active = $user->getActive();
//        $this->email = $user->getEmail();
//    }
//
//    public function setRole($role)
//    {
//        $this->role = $role;
//    }
//
//    public function getRole()
//    {
//        return $this->role;
//    }
//
//    public function setGroup($group)
//    {
//        $this->group = $group;
//    }
//
//    function jsonSerialize()
//    {
//        return [
//            'id' => $this->id,
//            'firstname' => $this->firstName,
//            'patronymic' => $this->middleName,
//            'lastname' => $this->lastName,
//            'active' => $this->active,
//            'email' => $this->email,
//            'role' => $this->role,
//            'group' => $this->group
//        ];
//    }


}