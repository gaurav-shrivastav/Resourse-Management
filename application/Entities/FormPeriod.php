<?php

namespace Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * FormPeriod
 *
 * @Table(name="form_period")
 * @Entity
 */
class FormPeriod
{
    /**
     * @var integer $id
     *
     * @Column(name="id", type="integer", nullable=false)
     * @Id
     * @GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var integer $empId
     *
     * @Column(name="emp_id", type="integer", nullable=false)
     */
    private $empId;

    /**
     * @var date $startDate
     *
     * @Column(name="start_date", type="date", nullable=false)
     */
    private $startDate;

    /**
     * @var date $endDate
     *
     * @Column(name="end_date", type="date", nullable=false)
     */
    private $endDate;

    /**
     * @var string $period
     *
     * @Column(name="period", type="string", nullable=true)
     */
    private $period;

    /**
     * @var string $financialYear
     *
     * @Column(name="financial_year", type="string", length=4, nullable=false)
     */
    private $financialYear;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set empId
     *
     * @param integer $empId
     */
    public function setEmpId($empId)
    {
        $this->empId = $empId;
    }

    /**
     * Get empId
     *
     * @return integer 
     */
    public function getEmpId()
    {
        return $this->empId;
    }

    /**
     * Set startDate
     *
     * @param date $startDate
     */
    public function setStartDate($startDate)
    {
        $this->startDate = $startDate;
    }

    /**
     * Get startDate
     *
     * @return date 
     */
    public function getStartDate()
    {
        return $this->startDate;
    }

    /**
     * Set endDate
     *
     * @param date $endDate
     */
    public function setEndDate($endDate)
    {
        $this->endDate = $endDate;
    }

    /**
     * Get endDate
     *
     * @return date 
     */
    public function getEndDate()
    {
        return $this->endDate;
    }

    /**
     * Set period
     *
     * @param string $period
     */
    public function setPeriod($period)
    {
        $this->period = $period;
    }

    /**
     * Get period
     *
     * @return string 
     */
    public function getPeriod()
    {
        return $this->period;
    }

    /**
     * Set financialYear
     *
     * @param string $financialYear
     */
    public function setFinancialYear($financialYear)
    {
        $this->financialYear = $financialYear;
    }

    /**
     * Get financialYear
     *
     * @return string 
     */
    public function getFinancialYear()
    {
        return $this->financialYear;
    }
}