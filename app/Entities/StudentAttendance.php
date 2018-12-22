<?php


use Doctrine\ORM\Mapping as ORM;
/**
 * StudentAttendance
 */
class StudentAttendance extends BaseEntity implements JsonSerializable
{
    /**
     * @var integer
     */
    protected $occupationType;

    /**
     * @var integer
     */
    protected $occupationNumber;

    /**
     * @var boolean
     */
    protected $visitStatus;

    /**
     * @var \DisciplinePlan
     */

    protected $disciplinePlan;

    /**
     * @var integer
     */
    protected $id;

    /**
     * @var \User
     */
    protected $student;

    public function jsonSerialize()
    {
        return array(
            'id' => $this->id,
            'student' => $this->student,
            'disciplinePlan' => $this->disciplinePlan,
            'occupationType' => $this->occupationType,
            'occupationNumber' => $this->occupationNumber,
            'visitStatus' => $this->visitStatus,
        );
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
     * @return int
     */
    public function getOccupationNumber()
    {
        return $this->occupationNumber;
    }

    /**
     * @param int $occupationNumber
     */
    public function setOccupationNumber($occupationNumber)
    {
        $this->occupationNumber = $occupationNumber;
    }


    /**
     * @return User
     */
    public function getStudent()
    {
        return $this->student;
    }

    /**
     * @param User $student
     */
    public function setStudent($student)
    {
        $this->student = $student;
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

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return bool
     */
    public function isVisitStatus()
    {
        return $this->visitStatus;
    }

    /**
     * @param bool $visitStatus
     */
    public function setVisitStatus($visitStatus)
    {
        $this->visitStatus = $visitStatus;
    }
}

