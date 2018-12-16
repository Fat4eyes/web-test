<?php



/**
 * StudentAttendance
 */
class StudentProgress extends BaseEntity
{

    /**
     * @var integer
     */
    protected $id;

    /**
     * @var \DisciplineGroup
     */
    protected $disciplineGroup;

    /**
     * @var \StudentGroup
     */
    protected $student;

    /**
     * @var integer
     */
    protected $occupationType;

    protected $workNumber;

    protected $workMark;

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
     * @return DisciplineGroup
     */
    public function getDisciplineGroup()
    {
        return $this->disciplineGroup;
    }

    /**
     * @param DisciplineGroup $disciplineGroup
     */
    public function setDisciplineGroup($disciplineGroup)
    {
        $this->disciplineGroup = $disciplineGroup;
    }

    /**
     * @return StudentGroup
     */
    public function getStudent()
    {
        return $this->student;
    }

    /**
     * @param StudentGroup $student
     */
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

