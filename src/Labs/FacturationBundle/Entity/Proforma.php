<?php

namespace Labs\FacturationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints\Date;

/**
 * Proforma
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Labs\FacturationBundle\Repository\ProformaRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Proforma
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
     * @ORM\Column(name="arrete", type="text", nullable=true)
     */
    protected $arrete;

    /**
     * @var string
     *
     * @ORM\Column(name="local", type="string", length=225, nullable=true, options={"comment" : "Localisation de la proforma de location"})
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
     * @var text
     *
     * @ORM\Column(name="subject", type="text", nullable=true)
     */
    protected $subject;


    /**
     * @ORM\OneToMany(targetEntity="Labs\FacturationBundle\Entity\ProformasProducts", mappedBy="proformas", cascade={"persist", "remove"})
     */
    protected $proformasproducts;

    /**
     * @ORM\ManyToOne(targetEntity="Labs\FacturationBundle\Entity\Service", inversedBy="proformas")
     * @ORM\JoinColumn(nullable=true, name="service_id", referencedColumnName="id")
     */
    protected $services;

    /**
     * @ORM\ManyToOne(targetEntity="Labs\FacturationBundle\Entity\Conditions", inversedBy="proformas")
     * @ORM\JoinColumn(name="condition_id", referencedColumnName="id")
     */
    protected $conditions;

    /**
     * @ORM\ManyToOne(targetEntity="Labs\MembersBundle\Entity\User", inversedBy="proformas")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    protected $users;

    /**
     * @ORM\ManyToOne(targetEntity="Labs\MembersBundle\Entity\Client", inversedBy="proformas")
     * @ORM\JoinColumn(name="client_id", referencedColumnName="id")
     */
    protected $clients;

    /**
     * @ORM\ManyToOne(targetEntity="Labs\FacturationBundle\Entity\Compagny", inversedBy="proformas")
     * @ORM\JoinColumn(name="compagny_id", referencedColumnName="id")
     */
    protected $compagny;

    /**
     * @ORM\OneToOne(targetEntity="Labs\FacturationBundle\Entity\Commandes", mappedBy="proforma")
     */
    protected $commandes;



    public function __construct()
    {
        $this->created = new \DateTime();
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
     * @return Proforma
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
     * Set status
     *
     * @param integer $status
     * @return Proforma
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
     * Set arrete
     *
     * @param string $arrete
     * @return Proforma
     */
    public function setArrete($arrete)
    {
        $this->arrete = $arrete;

        return $this;
    }

    /**
     * Get arrete
     *
     * @return string 
     */
    public function getArrete()
    {
        return $this->arrete;
    }

    /**
     * Set services
     *
     * @param \Labs\FacturationBundle\Entity\Service $services
     * @return Proforma
     */
    public function setServices(\Labs\FacturationBundle\Entity\Service $services = null)
    {
        $this->services = $services;

        return $this;
    }

    /**
     * Get services
     *
     * @return \Labs\FacturationBundle\Entity\Service 
     */
    public function getServices()
    {
        return $this->services;
    }

    /**
     * Set conditions
     *
     * @param \Labs\FacturationBundle\Entity\Conditions $conditions
     * @return Proforma
     */
    public function setConditions(\Labs\FacturationBundle\Entity\Conditions $conditions = null)
    {
        $this->conditions = $conditions;

        return $this;
    }

    /**
     * Get conditions
     *
     * @return \Labs\FacturationBundle\Entity\Conditions 
     */
    public function getConditions()
    {
        return $this->conditions;
    }

    /**
     * Set users
     *
     * @param \Labs\MembersBundle\Entity\User $users
     * @return Proforma
     */
    public function setUsers(\Labs\MembersBundle\Entity\User $users = null)
    {
        $this->users = $users;

        return $this;
    }

    /**
     * Get users
     *
     * @return \Labs\MembersBundle\Entity\User 
     */
    public function getUsers()
    {
        return $this->users;
    }

    /**
     * Set clients
     *
     * @param \Labs\MembersBundle\Entity\Client $clients
     * @return Proforma
     */
    public function setClients(\Labs\MembersBundle\Entity\Client $clients = null)
    {
        $this->clients = $clients;

        return $this;
    }

    /**
     * Get clients
     *
     * @return \Labs\MembersBundle\Entity\Client 
     */
    public function getClients()
    {
        return $this->clients;
    }

    /**
     * @ORM\PreUpdate()
     * @ORM\PrePersist()
     */
    public function UpdateDate()
    {
        $this->updated = new \DateTime();
    }



    /**
     * Set created
     *
     * @param \DateTime $created
     * @return Proforma
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
     * @return Proforma
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
     * Set compagny
     *
     * @param \Labs\FacturationBundle\Entity\Compagny $compagny
     * @return Proforma
     */
    public function setCompagny(\Labs\FacturationBundle\Entity\Compagny $compagny = null)
    {
        $this->compagny = $compagny;

        return $this;
    }

    /**
     * Get compagny
     *
     * @return \Labs\FacturationBundle\Entity\Compagny 
     */
    public function getCompagny()
    {
        return $this->compagny;
    }

    /**
     * Add proformasproducts
     *
     * @param \Labs\FacturationBundle\Entity\ProformasProducts $proformasproducts
     * @return Proforma
     */
    public function addProformasproduct(\Labs\FacturationBundle\Entity\ProformasProducts $proformasproducts)
    {
        $this->proformasproducts[] = $proformasproducts;

        return $this;
    }

    /**
     * Remove proformasproducts
     *
     * @param \Labs\FacturationBundle\Entity\ProformasProducts $proformasproducts
     */
    public function removeProformasproduct(\Labs\FacturationBundle\Entity\ProformasProducts $proformasproducts)
    {
        $this->proformasproducts->removeElement($proformasproducts);
    }

    /**
     * Get proformasproducts
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getProformasproducts()
    {
        return $this->proformasproducts;
    }

    /**
     * Set commandes
     *
     * @param \Labs\FacturationBundle\Entity\Commandes $commandes
     * @return Proforma
     */
    public function setCommandes(\Labs\FacturationBundle\Entity\Commandes $commandes = null)
    {
        $this->commandes = $commandes;

        return $this;
    }

    /**
     * Get commandes
     *
     * @return \Labs\FacturationBundle\Entity\Commandes 
     */
    public function getCommandes()
    {
        return $this->commandes;
    }

    /**
     * Set subject
     *
     * @param string $subject
     * @return Proforma
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
     * Set local
     *
     * @param string $local
     *
     * @return Proforma
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
     * @return Proforma
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
     * @return Proforma
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
     * Set referenceView
     *
     * @param string $referenceView
     *
     * @return Proforma
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
}
