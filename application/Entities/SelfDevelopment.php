<?php

namespace Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * SelfDevelopment
 *
 * @Table(name="self_development")
 * @Entity
 */
class SelfDevelopment
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
     * @var text $requirementDetail
     *
     * @Column(name="requirement_detail", type="text", nullable=true)
     */
    private $requirementDetail;

    /**
     * @var text $appraiserComment
     *
     * @Column(name="appraiser_comment", type="text", nullable=true)
     */
    private $appraiserComment;

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
     * @var FormDetails
     *
     * @ManyToOne(targetEntity="FormDetails")
     * @JoinColumns({
     *   @JoinColumn(name="formdetail_id", referencedColumnName="id")
     * })
     */
    private $formdetail;


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
     * Set requirementDetail
     *
     * @param text $requirementDetail
     */
    public function setRequirementDetail($requirementDetail)
    {
        $this->requirementDetail = $requirementDetail;
    }

    /**
     * Get requirementDetail
     *
     * @return text 
     */
    public function getRequirementDetail()
    {
        return $this->requirementDetail;
    }

    /**
     * Set appraiserComment
     *
     * @param text $appraiserComment
     */
    public function setAppraiserComment($appraiserComment)
    {
        $this->appraiserComment = $appraiserComment;
    }

    /**
     * Get appraiserComment
     *
     * @return text 
     */
    public function getAppraiserComment()
    {
        return $this->appraiserComment;
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
     * Set formdetail
     *
     * @param FormDetails $formdetail
     */
    public function setFormdetail(FormDetails $formdetail)
    {
        $this->formdetail = $formdetail;
    }

    /**
     * Get formdetail
     *
     * @return FormDetails 
     */
    public function getFormdetail()
    {
        return $this->formdetail;
    }
}