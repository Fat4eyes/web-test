<?php


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

    public function jsonSerialize()
    {
        return array(
            'id' => $this->id,
            'student' => $this->student,
            'disciplinePlan' => $this->disciplinePlan,
            'occupationType' => $this->occupationType,
            'workNumber' => $this->workNumber,
            'workMark' => $this->workMark,
        );
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


}

