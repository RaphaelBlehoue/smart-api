<?php

namespace Labs\FacturationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Commandes
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Labs\FacturationBundle\Repository\CommandesRepository")
 */
class Commandes
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
     * @var \DateTime
     *
     * @ORM\Column(name="created", type="datetime")
     */
    protected $created;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="delivery", type="date")
     */
    protected $delivery;

    /**
     * @var integer
     *
     * @ORM\Column(name="status", type="integer")
     */
    protected $status;

    /**
     * @ORM\OneToOne(targetEntity="Labs\FacturationBundle\Entity\Proforma", inversedBy="commandes", cascade={"persist"})
     */
    protected $proforma;

    /**
     * @var string
     * @ORM\Column(name="reference", type="string", length=225)
     */
    protected $reference;


    public function __construct()
    {
        $this->created = new \DateTime();
        $this->delivery = new \DateTime();
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
     * Set created
     *
     * @param \DateTime $created
     * @return Commandes
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
     * Set delivery
     *
     * @param \DateTime $delivery
     * @return Commandes
     */
    public function setDelivery($delivery)
    {
        $this->delivery = $delivery;

        return $this;
    }

    /**
     * Get delivery
     *
     * @return \DateTime 
     */
    public function getDelivery()
    {
        return $this->delivery;
    }

    /**
     * Set status
     *
     * @param integer $status
     * @return Commandes
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
     * Set proforma
     *
     * @param \Labs\FacturationBundle\Entity\Proforma $proforma
     * @return Commandes
     */
    public function setProforma(\Labs\FacturationBundle\Entity\Proforma $proforma = null)
    {
        $this->proforma = $proforma;

        return $this;
    }

    /**
     * Get proforma
     *
     * @return \Labs\FacturationBundle\Entity\Proforma 
     */
    public function getProforma()
    {
        return $this->proforma;
    }

    /**
     * Set reference
     *
     * @param string $reference
     * @return Commandes
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
}
