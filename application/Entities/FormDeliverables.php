<?php

namespace Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * FormDeliverables
 *
 * @Table(name="form_deliverables")
 * @Entity
 */
class FormDeliverables
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
     * @var string $keyDeliverables
     *
     * @Column(name="key_deliverables", type="string", length=500, nullable=true)
     */
    private $keyDeliverables;

    /**
     * @var integer $achieventLevel
     *
     * @Column(name="achievent_level", type="integer", nullable=true)
     */
    private $achieventLevel;

    /**
     * @var integer $selfScore
     *
     * @Column(name="self_score", type="integer", nullable=true)
     */
    private $selfScore;

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
     * Set keyDeliverables
     *
     * @param string $keyDeliverables
     */
    public function setKeyDeliverables($keyDeliverables)
    {
        $this->keyDeliverables = $keyDeliverables;
    }

    /**
     * Get keyDeliverables
     *
     * @return string 
     */
    public function getKeyDeliverables()
    {
        return $this->keyDeliverables;
    }

    /**
     * Set achieventLevel
     *
     * @param integer $achieventLevel
     */
    public function setAchieventLevel($achieventLevel)
    {
        $this->achieventLevel = $achieventLevel;
    }

    /**
     * Get achieventLevel
     *
     * @return integer 
     */
    public function getAchieventLevel()
    {
        return $this->achieventLevel;
    }

    /**
     * Set selfScore
     *
     * @param integer $selfScore
     */
    public function setSelfScore($selfScore)
    {
        $this->selfScore = $selfScore;
    }

    /**
     * Get selfScore
     *
     * @return integer 
     */
    public function getSelfScore()
    {
        return $this->selfScore;
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