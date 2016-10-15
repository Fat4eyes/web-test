<?php

namespace Repositories;

use Doctrine\ORM\EntityManager;
use Theme;

class ThemeRepository extends BaseRepository
{
    public function __construct(EntityManager $em)
    {
        parent::__construct($em, Theme::class);
    }

    public function getByDiscipline($disciplineId){
        return $this->repo->findBy(['discipline' => $disciplineId]);
    }
}