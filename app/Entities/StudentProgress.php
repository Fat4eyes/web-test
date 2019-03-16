<?php


use Doctrine\ORM\Event\PreUpdateEventArgs;
use Doctrine\ORM\Mapping as ORM;
/**
 * StudentAttendance
 */
class StudentProgress extends BaseEntity implements JsonSerializable
{

    /**
     * @var integer
     */
    protected $id;

    /**
     * @var \DisciplinePlan
     */
    protected $disciplinePlan;

    protected $student;

    /**
     * @var integer
     */
    protected $occupationType;

    protected $workNumber;

    protected $workMark;

    protected $updatedAt;

    protected $extraFields;

    public function jsonSerialize()
    {
        return array(
            'id' => $this->id,
            'student' => $this->student,
            'disciplinePlan' => $this->disciplinePlan,
            'occupationType' => $this->occupationType,
            'workNumber' => $this->workNumber,
            'workMark' => $this->workMark,
            'updatedAt' => $this->updatedAt,
            'extraFields' => explode(',',$this->extraFields)
        );
    }

    public function onPrePersist()
    {
    }

    /**
     * Triggered on update
     * @ORM\PreUpdate
     */
    public function onPreUpdate(PreUpdateEventArgs $event)
    {
        if ($event->hasChangedField('workMark')) {
            if (!$this->updatedAt) {
                $this->updatedAt = date("Y-m-d");
            }
        }
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return DisciplinePlan
     */
    public function getDisciplinePlan()
    {
        return $this->disciplinePlan;
    }

    /**
     * @param DisciplinePlan $disciplinePlan
     */
    public function setDisciplinePlan($disciplinePlan)
    {
        $this->disciplinePlan = $disciplinePlan;
    }

    public function getStudent()
    {
        return $this->student;
    }

    public function setStudent($student)
    {
        $this->student = $student;
    }

    /**
     * @return mixed
     */
    public function getWorkNumber()
    {
        return $this->workNumber;
    }

    /**
     * @param mixed $workNumber
     */
    public function setWorkNumber($workNumber)
    {
        $this->workNumber = $workNumber;
    }

    /**
     * @return mixed
     */
    public function getWorkMark()
    {
        return $this->workMark;
    }

    /**
     * @param mixed $workMark
     */
    public function setWorkMark($workMark)
    {
        $this->workMark = $workMark;
    }

    /**
     * @return int
     */
    public function getOccupationType()
    {
        return $this->occupationType;
    }

    /**
     * @param int $occupationType
     */
    public function setOccupationType($occupationType)
    {
        $this->occupationType = $occupationType;
    }

    /**
     * @return mixed
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @param mixed $updatedAt
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
    }

    /**
     * @return mixed
     */
    public function getExtraFields()
    {
        return $this->extraFields;
    }

    /**
     * @param mixed $extraFields
     */
    public function setExtraFields($extraFields)
    {
        $this->extraFields = $extraFields;
    }

}

