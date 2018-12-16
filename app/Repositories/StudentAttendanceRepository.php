<?php
/**
 * Created by PhpStorm.
 * User: Zhora
 * Date: 14.12.2018
 * Time: 2:36
 */

namespace Repositories;

use Doctrine\ORM\EntityManager;
use StudentAttendance;

class StudentAttendanceRepository extends BaseRepository
{
    public function __construct(EntityManager $em)
    {
        parent::__construct($em, StudentAttendance::class);
    }


    public function getStudentAttendancesByStudent($studentId){
        return $this->repo->findBy(['student' => $studentId]);
    }
}