<?php
/**
 * Created by PhpStorm.
 * User: Zhora
 * Date: 14.12.2018
 * Time: 2:22
 */


namespace Repositories;

use Doctrine\ORM\EntityManager;
use StudentProgress;

class StudentProgressRepository extends BaseRepository
{
    public function __construct(EntityManager $em)
    {
        parent::__construct($em, StudentProgress::class);
    }

//    function getByStudent($studentId){
//        $query = $this->repo->createQueryBuilder('d');
//
//        $query = $query->join(StudentProgress::class, 'pd', Join::WITH, 'pd.progress = d.id')
//            ->where('pd.student = :student')
//            ->setParameter('student', $studentId)
//            ->getQuery();
//
//        return $query->execute();
//    }
//
    public function getStudentProgressesByStudent($studentId){//grouprepository
        $query = $this->repo->createQueryBuilder('g')
            ->join(\StudentProgress::class, 'sp', Join::WITH,
                'g.studyplan = sp.id AND sp.student = '.$studentId)
            ->getQuery();

        return $query->execute();
    }

//    public function getAttendancesByStudent($studentId){
//        return $this->repo->findBy(['student' => $studentId]);
//    }
}