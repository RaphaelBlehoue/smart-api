<?php

namespace Labs\AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints\Date;

/**
 * Quotation
 *
 * @ORM\Table("quotations")
 * @ORM\Entity(repositoryClass="Labs\AppBundle\Repository\QuotationRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Quotation
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string", name="reference", length=255)
     */
    protected $reference;

    /**
     * @var string
     *
     * @ORM\Column(type="string", name="reference_view", length=255)
     */
    protected $referenceView;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created", type="date")
     */
    protected $created;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated", type="date")
     */
    protected $updated;

    /**
     * @var integer
     *
     * @ORM\Column(name="status", type="integer")
     */
    protected $status;

    /**
     * @var text
     *
     * @ORM\Column(name="sum_letter", type="text", nullable=true)
     */
    protected $sum_letter;

    /**
     * @var string
     *
     * @ORM\Column(name="local", type="string", length=225, nullable=true, options={"comment" : "Localisation du devis de location"})
     */
    protected $local;

    /**
     * @var Date
     *
     * @ORM\Column(name="start", type="date", nullable=true, options={"comment" : "Date de debut de la location"})
     */
    protected $start;

    /**
     * @var Date
     *
     * @ORM\Column(name="end", type="date", nullable=true, options={"comment" : "Date de fin de la location"})
     */
    protected $end;

    /**
     * @var string
     *
     * @ORM\Column(name="subject", type="text", nullable=true)
     */
    protected $subject;


    /**
     * @ORM\OneToMany(targetEntity="QuotationProduct", mappedBy="quotation", cascade={"persist", "remove"})
     */
    protected $quotationproduct;

    /**
     * @ORM\ManyToOne(targetEntity="Service", inversedBy="quotations")
     * @ORM\JoinColumn(nullable=true, name="service_id", referencedColumnName="id")
     */
    protected $service;

    /**
     * @ORM\ManyToOne(targetEntity="Condition", inversedBy="quotations")
     * @ORM\JoinColumn(name="condition_id", referencedColumnName="id")
     */
    protected $condition;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="quotations")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    protected $user;

    /**
     * @ORM\ManyToOne(targetEntity="Customer", inversedBy="quotations")
     * @ORM\JoinColumn(name="customer_id", referencedColumnName="id")
     */
    protected $customer;

    /**
     * @ORM\ManyToOne(targetEntity="Company", inversedBy="quotations")
     * @ORM\JoinColumn(name="company_id", referencedColumnName="id")
     */
    protected $company;

    /**
     * @ORM\OneToOne(targetEntity="Deliveryvoucher", mappedBy="quotation")
     */
    protected $deliveryvoucher;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->quotationproduct = new ArrayCollection();
    }

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
     * Set reference
     *
     * @param string $reference
     *
     * @return Quotation
     */
    public function setReference($reference)
    {
        $this->reference = $reference;

        return $this;
    }

    /**
     * Get reference
     *
     * @return string
     */
    public function getReference()
    {
        return $this->reference;
    }

    /**
     * Set referenceView
     *
     * @param string $referenceView
     *
     * @return Quotation
     */
    public function setReferenceView($referenceView)
    {
        $this->referenceView = $referenceView;

        return $this;
    }

    /**
     * Get referenceView
     *
     * @return string
     */
    public function getReferenceView()
    {
        return $this->referenceView;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     *
     * @return Quotation
     */
    public function setCreated($created)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set updated
     *
     * @param \DateTime $updated
     *
     * @return Quotation
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;

        return $this;
    }

    /**
     * Get updated
     *
     * @return \DateTime
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    /**
     * Set status
     *
     * @param integer $status
     *
     * @return Quotation
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return integer
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set sumLetter
     *
     * @param string $sumLetter
     *
     * @return Quotation
     */
    public function setSumLetter($sumLetter)
    {
        $this->sum_letter = $sumLetter;

        return $this;
    }

    /**
     * Get sumLetter
     *
     * @return string
     */
    public function getSumLetter()
    {
        return $this->sum_letter;
    }

    /**
     * Set local
     *
     * @param string $local
     *
     * @return Quotation
     */
    public function setLocal($local)
    {
        $this->local = $local;

        return $this;
    }

    /**
     * Get local
     *
     * @return string
     */
    public function getLocal()
    {
        return $this->local;
    }

    /**
     * Set start
     *
     * @param \DateTime $start
     *
     * @return Quotation
     */
    public function setStart($start)
    {
        $this->start = $start;

        return $this;
    }

    /**
     * Get start
     *
     * @return \DateTime
     */
    public function getStart()
    {
        return $this->start;
    }

    /**
     * Set end
     *
     * @param \DateTime $end
     *
     * @return Quotation
     */
    public function setEnd($end)
    {
        $this->end = $end;

        return $this;
    }

    /**
     * Get end
     *
     * @return \DateTime
     */
    public function getEnd()
    {
        return $this->end;
    }

    /**
     * Set subject
     *
     * @param string $subject
     *
     * @return Quotation
     */
    public function setSubject($subject)
    {
        $this->subject = $subject;

        return $this;
    }

    /**
     * Get subject
     *
     * @return string
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * Add quotationproduct
     *
     * @param \Labs\AppBundle\Entity\QuotationProduct $quotationproduct
     *
     * @return Quotation
     */
    public function addQuotationproduct(\Labs\AppBundle\Entity\QuotationProduct $quotationproduct)
    {
        $this->quotationproduct[] = $quotationproduct;

        return $this;
    }

    /**
     * Remove quotationproduct
     *
     * @param \Labs\AppBundle\Entity\QuotationProduct $quotationproduct
     */
    public function removeQuotationproduct(\Labs\AppBundle\Entity\QuotationProduct $quotationproduct)
    {
        $this->quotationproduct->removeElement($quotationproduct);
    }

    /**
     * Get quotationproduct
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getQuotationproduct()
    {
        return $this->quotationproduct;
    }

    /**
     * Set service
     *
     * @param \Labs\AppBundle\Entity\Service $service
     *
     * @return Quotation
     */
    public function setService(\Labs\AppBundle\Entity\Service $service = null)
    {
        $this->service = $service;

        return $this;
    }

    /**
     * Get service
     *
     * @return \Labs\AppBundle\Entity\Service
     */
    public function getService()
    {
        return $this->service;
    }

    /**
     * Set condition
     *
     * @param \Labs\AppBundle\Entity\Condition $condition
     *
     * @return Quotation
     */
    public function setCondition(\Labs\AppBundle\Entity\Condition $condition = null)
    {
        $this->condition = $condition;

        return $this;
    }

    /**
     * Get condition
     *
     * @return \Labs\AppBundle\Entity\Condition
     */
    public function getCondition()
    {
        return $this->condition;
    }

    /**
     * Set user
     *
     * @param \Labs\AppBundle\Entity\User $user
     *
     * @return Quotation
     */
    public function setUser(\Labs\AppBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \Labs\AppBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set customer
     *
     * @param \Labs\AppBundle\Entity\Customer $customer
     *
     * @return Quotation
     */
    public function setCustomer(\Labs\AppBundle\Entity\Customer $customer = null)
    {
        $this->customer = $customer;

        return $this;
    }

    /**
     * Get customer
     *
     * @return \Labs\AppBundle\Entity\Customer
     */
    public function getCustomer()
    {
        return $this->customer;
    }

    /**
     * Set company
     *
     * @param \Labs\AppBundle\Entity\Company $company
     *
     * @return Quotation
     */
    public function setCompany(\Labs\AppBundle\Entity\Company $company = null)
    {
        $this->company = $company;

        return $this;
    }

    /**
     * Get company
     *
     * @return \Labs\AppBundle\Entity\Company
     */
    public function getCompany()
    {
        return $this->company;
    }

    /**
     * Set deliveryvoucher
     *
     * @param \Labs\AppBundle\Entity\Deliveryvoucher $deliveryvoucher
     *
     * @return Quotation
     */
    public function setDeliveryvoucher(\Labs\AppBundle\Entity\Deliveryvoucher $deliveryvoucher = null)
    {
        $this->deliveryvoucher = $deliveryvoucher;

        return $this;
    }

    /**
     * Get deliveryvoucher
     *
     * @return \Labs\AppBundle\Entity\Deliveryvoucher
     */
    public function getDeliveryvoucher()
    {
        return $this->deliveryvoucher;
    }
}
