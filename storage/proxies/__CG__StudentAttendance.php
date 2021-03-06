<?php

namespace DoctrineProxies\__CG__;

/**
 * DO NOT EDIT THIS FILE - IT WAS CREATED BY DOCTRINE'S PROXY GENERATOR
 */
class StudentAttendance extends \StudentAttendance implements \Doctrine\ORM\Proxy\Proxy
{
    /**
     * @var \Closure the callback responsible for loading properties in the proxy object. This callback is called with
     *      three parameters, being respectively the proxy object to be initialized, the method that triggered the
     *      initialization process and an array of ordered parameters that were passed to that method.
     *
     * @see \Doctrine\Common\Persistence\Proxy::__setInitializer
     */
    public $__initializer__;

    /**
     * @var \Closure the callback responsible of loading properties that need to be copied in the cloned object
     *
     * @see \Doctrine\Common\Persistence\Proxy::__setCloner
     */
    public $__cloner__;

    /**
     * @var boolean flag indicating if this object was already initialized
     *
     * @see \Doctrine\Common\Persistence\Proxy::__isInitialized
     */
    public $__isInitialized__ = false;

    /**
     * @var array properties to be lazy loaded, with keys being the property
     *            names and values being their default values
     *
     * @see \Doctrine\Common\Persistence\Proxy::__getLazyProperties
     */
    public static $lazyPropertiesDefaults = [];



    /**
     * @param \Closure $initializer
     * @param \Closure $cloner
     */
    public function __construct($initializer = null, $cloner = null)
    {

        $this->__initializer__ = $initializer;
        $this->__cloner__      = $cloner;
    }







    /**
     * 
     * @return array
     */
    public function __sleep()
    {
        if ($this->__isInitialized__) {
            return ['__isInitialized__', 'occupationType', 'occupationNumber', 'visitStatus', 'disciplinePlan', 'id', 'student', 'discipline_plan'];
        }

        return ['__isInitialized__', 'occupationType', 'occupationNumber', 'visitStatus', 'disciplinePlan', 'id', 'student', 'discipline_plan'];
    }

    /**
     * 
     */
    public function __wakeup()
    {
        if ( ! $this->__isInitialized__) {
            $this->__initializer__ = function (StudentAttendance $proxy) {
                $proxy->__setInitializer(null);
                $proxy->__setCloner(null);

                $existingProperties = get_object_vars($proxy);

                foreach ($proxy->__getLazyProperties() as $property => $defaultValue) {
                    if ( ! array_key_exists($property, $existingProperties)) {
                        $proxy->$property = $defaultValue;
                    }
                }
            };

        }
    }

    /**
     * 
     */
    public function __clone()
    {
        $this->__cloner__ && $this->__cloner__->__invoke($this, '__clone', []);
    }

    /**
     * Forces initialization of the proxy
     */
    public function __load()
    {
        $this->__initializer__ && $this->__initializer__->__invoke($this, '__load', []);
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __isInitialized()
    {
        return $this->__isInitialized__;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __setInitialized($initialized)
    {
        $this->__isInitialized__ = $initialized;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __setInitializer(\Closure $initializer = null)
    {
        $this->__initializer__ = $initializer;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __getInitializer()
    {
        return $this->__initializer__;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __setCloner(\Closure $cloner = null)
    {
        $this->__cloner__ = $cloner;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific cloning logic
     */
    public function __getCloner()
    {
        return $this->__cloner__;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     * @static
     */
    public function __getLazyProperties()
    {
        return self::$lazyPropertiesDefaults;
    }

    
    /**
     * {@inheritDoc}
     */
    public function jsonSerialize()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'jsonSerialize', []);

        return parent::jsonSerialize();
    }

    /**
     * {@inheritDoc}
     */
    public function getOccupationType()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getOccupationType', []);

        return parent::getOccupationType();
    }

    /**
     * {@inheritDoc}
     */
    public function setOccupationType($occupationType)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setOccupationType', [$occupationType]);

        return parent::setOccupationType($occupationType);
    }

    /**
     * {@inheritDoc}
     */
    public function getOccupationNumber()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getOccupationNumber', []);

        return parent::getOccupationNumber();
    }

    /**
     * {@inheritDoc}
     */
    public function setOccupationNumber($occupationNumber)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setOccupationNumber', [$occupationNumber]);

        return parent::setOccupationNumber($occupationNumber);
    }

    /**
     * {@inheritDoc}
     */
    public function getStudent()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getStudent', []);

        return parent::getStudent();
    }

    /**
     * {@inheritDoc}
     */
    public function setStudent($student)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setStudent', [$student]);

        return parent::setStudent($student);
    }

    /**
     * {@inheritDoc}
     */
    public function getDisciplinePlan()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getDisciplinePlan', []);

        return parent::getDisciplinePlan();
    }

    /**
     * {@inheritDoc}
     */
    public function setDisciplinePlan($discipline_plan)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setDisciplinePlan', [$discipline_plan]);

        return parent::setDisciplinePlan($discipline_plan);
    }

    /**
     * {@inheritDoc}
     */
    public function getId()
    {
        if ($this->__isInitialized__ === false) {
            return (int)  parent::getId();
        }


        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getId', []);

        return parent::getId();
    }

    /**
     * {@inheritDoc}
     */
    public function isVisitStatus()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'isVisitStatus', []);

        return parent::isVisitStatus();
    }

    /**
     * {@inheritDoc}
     */
    public function setVisitStatus($visitStatus)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setVisitStatus', [$visitStatus]);

        return parent::setVisitStatus($visitStatus);
    }

    /**
     * {@inheritDoc}
     */
    public function fillFromJson($json)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'fillFromJson', [$json]);

        return parent::fillFromJson($json);
    }

}
