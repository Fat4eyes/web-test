<?php

namespace Managers;

use DisciplinePlan;
use MarkType;
use Repositories\UnitOfWork;
use Studyplan;

class StudyPlanManager
{
    private $_unitOfWork;

    public function __construct(UnitOfWork $unitOfWork)
    {
        $this->_unitOfWork = $unitOfWork;
    }

    // Работа с учебными планами
    public function getPlan($id){
        return $this->_unitOfWork->studyPlans()->find($id);
    }

    public function create(Studyplan $studyplan, $profileId){
        $profile = $this->_unitOfWork->profiles()->find($profileId);
        $studyplan->setProfile($profile);

        $this->_unitOfWork->studyPlans()->create($studyplan);
        $this->_unitOfWork->commit();
    }

    public function update(Studyplan $studyplan, $profileId){
        $profile = $this->_unitOfWork->profiles()->find($profileId);
        $studyplan->setProfile($profile);

        $this->_unitOfWork->studyPlans()->update($studyplan);
        $this->_unitOfWork->commit();
    }

    public function delete($id){
        $studyPlan = $this->_unitOfWork->studyPlans()->find($id);
        if ($studyPlan != null){
            $this->_unitOfWork->studyPlans()->delete($studyPlan);
            $this->_unitOfWork->commit();
        }
    }

    // Работа с планами дисциплин
    public function getPlanDisciplines($planId){
        return $this->_unitOfWork->disciplinePlans()
            ->where('DisciplinePlan.studyplan = '.$planId);
    }

    public function createDisciplinePlan(DisciplinePlan $disciplinePlan, $studyPlanId){
        $studyPlan = $this->_unitOfWork->studyPlans()->find($studyPlanId);
        $disciplinePlan->setStudyplan($studyPlan);

        $this->_unitOfWork->disciplinePlans()->create($disciplinePlan);
        $this->_unitOfWork->commit();
    }

    public function updateDisciplinePlan(DisciplinePlan $disciplinePlan, $studyPlanId){
        $studyPlan = $this->_unitOfWork->studyPlans()->find($studyPlanId);
        $disciplinePlan->setStudyplan($studyPlan);

        $this->_unitOfWork->disciplinePlans()->update($disciplinePlan);
        $this->_unitOfWork->commit();
    }

    public function deleteDisciplinePlan($id){
        $disciplinePlan = $this->_unitOfWork->disciplinePlans()->find($id);
        if ($disciplinePlan != null){
            $this->_unitOfWork->disciplinePlans()->delete($disciplinePlan);
            $this->_unitOfWork->commit();
        }
    }

    // Работа с типами оценок
    public function getDisciplinePlanMarkTypes($disciplinePlanId){
        return $this->_unitOfWork->markTypes()
            ->where('MarkType.disciplineplan = '.$disciplinePlanId);
    }

    public function createMarkType(MarkType $markType, $disciplinePlanId){
        $disciplinePlan = $this->_unitOfWork->disciplinePlans()->find($disciplinePlanId);
        $markType->setDisciplinePlan($disciplinePlan);

        $this->_unitOfWork->markTypes()->create($markType);
        $this->_unitOfWork->commit();
    }

    public function updateMarkType(MarkType $markType, $disciplinePlanId){
        $disciplinePlan = $this->_unitOfWork->disciplinePlans()->find($disciplinePlanId);
        $markType->setDisciplinePlan($disciplinePlan);

        $this->_unitOfWork->markTypes()->update($markType);
        $this->_unitOfWork->commit();
    }

    public function deleteMarkType($id){
        $markType = $this->_unitOfWork->markTypes()->find($id);
        if ($markType != null){
            $this->_unitOfWork->markTypes()->delete($markType);
            $this->_unitOfWork->commit();
        }
    }

}