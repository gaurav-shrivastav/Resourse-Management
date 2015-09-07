<?php

namespace Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * EmpTeamlead
 *
 * @Table(name="emp_teamlead")
 * @Entity
 */
class EmpTeamlead
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
     * @var Login
     *
     * @ManyToOne(targetEntity="Login")
     * @JoinColumns({
     *   @JoinColumn(name="emp_id", referencedColumnName="emp_id")
     * })
     */
    private $emp;

    /**
     * @var Login
     *
     * @ManyToOne(targetEntity="Login")
     * @JoinColumns({
     *   @JoinColumn(name="head_id", referencedColumnName="emp_id")
     * })
     */
    private $head;


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
     * Set emp
     *
     * @param Login $emp
     */
    public function setEmp(\Login $emp)
    {
        $this->emp = $emp;
    }

    /**
     * Get emp
     *
     * @return Login 
     */
    public function getEmp()
    {
        return $this->emp;
    }

    /**
     * Set head
     *
     * @param Login $head
     */
    public function setHead(\Login $head)
    {
        $this->head = $head;
    }

    /**
     * Get head
     *
     * @return Login 
     */
    public function getHead()
    {
        return $this->head;
    }
}