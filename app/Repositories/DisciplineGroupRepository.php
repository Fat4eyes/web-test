<?php
/**
 * Created by PhpStorm.
 * User: Zhora
 * Date: 17.12.2018
 * Time: 19:52
 */

namespace Repositories;


use DisciplineGroup;
use Doctrine\ORM\EntityManager;

class DisciplineGroupRepository extends BaseRepository
{
    public function __construct(EntityManager $em)
    {
        parent::__construct($em, DisciplineGroup::class);
    }

    public function getDisciplineGroupByGroupId($group) {
        return $this->repo->findBy([
            "group" => $group
        ]);
    }

}