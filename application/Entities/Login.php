<?php

namespace Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * Login
 *
 * @Table(name="login")
 * @Entity
 */
class Login
{
    /**
     * @var integer $empId
     *
     * @Column(name="emp_id", type="integer", nullable=false)
     * @Id
     * @GeneratedValue(strategy="IDENTITY")
     */
    private $empId;

    /**
     * @var string $username
     *
     * @Column(name="username", type="string", length=45, nullable=false)
     */
    private $username;

    /**
     * @var string $password
     *
     * @Column(name="password", type="string", length=45, nullable=false)
     */
    private $password;

    /**
     * @var string $empName
     *
     * @Column(name="emp_name", type="string", length=45, nullable=false)
     */
    private $empName;

    /**
     * @var string $email
     *
     * @Column(name="email", type="string", length=45, nullable=false)
     */
    private $email;

    /**
     * @var string $userType
     *
     * @Column(name="user_type", type="string", length=20, nullable=false)
     */
    private $userType;

    /**
     * @var string $designation
     *
     * @Column(name="designation", type="string", length=45, nullable=false)
     */
    private $designation;

    /**
     * @var date $dateOfJoin
     *
     * @Column(name="date_of_join", type="date", nullable=false)
     */
    private $dateOfJoin;

    /**
     * @var integer $employeeCode
     *
     * @Column(name="employee_code", type="integer", nullable=false)
     */
    private $employeeCode;


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
     * Set username
     *
     * @param string $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * Get username
     *
     * @return string 
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set password
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * Get password
     *
     * @return string 
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set empName
     *
     * @param string $empName
     */
    public function setEmpName($empName)
    {
        $this->empName = $empName;
    }

    /**
     * Get empName
     *
     * @return string 
     */
    public function getEmpName()
    {
        return $this->empName;
    }

    /**
     * Set email
     *
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set userType
     *
     * @param string $userType
     */
    public function setUserType($userType)
    {
        $this->userType = $userType;
    }

    /**
     * Get userType
     *
     * @return string 
     */
    public function getUserType()
    {
        return $this->userType;
    }

    /**
     * Set designation
     *
     * @param string $designation
     */
    public function setDesignation($designation)
    {
        $this->designation = $designation;
    }

    /**
     * Get designation
     *
     * @return string 
     */
    public function getDesignation()
    {
        return $this->designation;
    }

    /**
     * Set dateOfJoin
     *
     * @param date $dateOfJoin
     */
    public function setDateOfJoin($dateOfJoin)
    {
        $this->dateOfJoin = $dateOfJoin;
    }

    /**
     * Get dateOfJoin
     *
     * @return date 
     */
    public function getDateOfJoin()
    {
        return $this->dateOfJoin;
    }

    /**
     * Set employeeCode
     *
     * @param integer $employeeCode
     */
    public function setEmployeeCode($employeeCode)
    {
        $this->employeeCode = $employeeCode;
    }

    /**
     * Get employeeCode
     *
     * @return integer 
     */
    public function getEmployeeCode()
    {
        return $this->employeeCode;
    }
}