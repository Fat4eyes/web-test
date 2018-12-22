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


    public function getStudentAttendancesByStudent($studentId, $disciplinPlanId){
        return $this->repo->findBy(array('student' => $studentId, 'disciplinePlan' => $disciplinPlanId),array('occupationType' => 'ASC', 'occupationNumber' => 'ASC'));
    }

    public function setStudentAttendances($disciplineId, array $profileIds){
        $qb = $this->em->getRepository(StudentAttendance::class)->createQueryBuilder('sa');
        $deleteQuery = $qb->delete()
            ->where('sa.discipline = :discipline')
            ->setParameter('discipline', $disciplineId)
            ->getQuery();

        $deleteQuery->execute();

        foreach ($profileIds as $profileId){
            DB::table('profile_discipline')
                ->insert(  array(
                    'profile_id' => $profileId,
                    'discipline_id' => $disciplineId
                ));
        }
    }

    function getActualDisciplinesForGroup($studentId, $disciplinPlanId){
        $qb = $this->repo->createQueryBuilder('d');
        $query = $qb->join(\DisciplinePlan::class, 'dp', Join::WITH, 'dp.discipline = d.id')
            ->join(Group::class, 'g', Join::WITH, 'g.studyplan = dp.studyplan')
            ->join(Theme::class, 'th', Join::WITH, 'th.discipline = d.id')
            ->join(TestTheme::class, 'tt', Join::WITH, 'tt.theme = th.id')
            ->join(Test::class, 't', Join::WITH, 'tt.test = t.id AND t.isActive = true')
            ->where('g.id = :groupId AND dp.semester <= :currentSemester')
            ->setParameter('$studentId', $studentId)
            ->setParameter('$disciplinPlanId', $disciplinPlanId)
            ->orderBy('dp.occupation', 'DESC')

            ->getQuery();

        return $query->execute();
    }

//    public function getDisciplineGroupByGroupId($group) {
//        return $this->repo->findBy([
//            "group" => $group
//        ]);
//    }
}