<?php

namespace Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * FormDetails
 *
 * @Table(name="form_details")
 * @Entity
 */
class FormDetails
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
     * @var string $deptName
     *
     * @Column(name="dept_name", type="string", length=45, nullable=false)
     */
    private $deptName;

    /**
     * @var date $dateCreated
     *
     * @Column(name="date_created", type="date", nullable=false)
     */
    private $dateCreated;

    /**
     * @var date $dateUpdated
     *
     * @Column(name="date_updated", type="date", nullable=true)
     */
    private $dateUpdated;

    /**
     * @var string $formStatus
     *
     * @Column(name="form_status", type="string", nullable=true)
     */
    private $formStatus;

    /**
     * @var FormPeriod
     *
     * @ManyToOne(targetEntity="FormPeriod")
     * @JoinColumns({
     *   @JoinColumn(name="form_id", referencedColumnName="id")
     * })
     */
    private $form;


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
     * Set deptName
     *
     * @param string $deptName
     */
    public function setDeptName($deptName)
    {
        $this->deptName = $deptName;
    }

    /**
     * Get deptName
     *
     * @return string 
     */
    public function getDeptName()
    {
        return $this->deptName;
    }

    /**
     * Set dateCreated
     *
     * @param date $dateCreated
     */
    public function setDateCreated($dateCreated)
    {
        $this->dateCreated = $dateCreated;
    }

    /**
     * Get dateCreated
     *
     * @return date 
     */
    public function getDateCreated()
    {
        return $this->dateCreated;
    }

    /**
     * Set dateUpdated
     *
     * @param date $dateUpdated
     */
    public function setDateUpdated($dateUpdated)
    {
        $this->dateUpdated = $dateUpdated;
    }

    /**
     * Get dateUpdated
     *
     * @return date 
     */
    public function getDateUpdated()
    {
        return $this->dateUpdated;
    }

    /**
     * Set formStatus
     *
     * @param string $formStatus
     */
    public function setFormStatus($formStatus)
    {
        $this->formStatus = $formStatus;
    }

    /**
     * Get formStatus
     *
     * @return string 
     */
    public function getFormStatus()
    {
        return $this->formStatus;
    }

    /**
     * Set form
     *
     * @param FormPeriod $form
     */
    public function setForm(FormPeriod $form)
    {
        $this->form = $form;
    }

    /**
     * Get form
     *
     * @return FormPeriod 
     */
    public function getForm()
    {
        return $this->form;
    }
}