<?php



/**
 * StudentAttendance
 */
class StudentAttendance extends BaseEntity
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

    protected $disciplineGroup;

    protected $studentGroup;

    /**
     * @var integer
     */
    protected $id;

    /**
     * @var \User
     */
    protected $student;

    /**
     * @var \DisciplineGroup
     */
    protected $discipline_group;

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
     * @return DisciplineGroup
     */
    public function getDisciplineGroup()
    {
        return $this->discipline_group;
    }

    /**
     * @param DisciplineGroup $discipline_group
     */
    public function setDisciplineGroup($discipline_group)
    {
        $this->discipline_group = $discipline_group;
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

    /**
     * @return mixed
     */
    public function getStudentGroup()
    {
        return $this->studentGroup;
    }

    /**
     * @param mixed $studentGroup
     */
    public function setStudentGroup($studentGroup)
    {
        $this->studentGroup = $studentGroup;
    }


}

