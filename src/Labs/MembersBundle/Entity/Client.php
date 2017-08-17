<?php

namespace Labs\MembersBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints AS Assert;

/**
 * Client
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Labs\MembersBundle\Repository\ClientRepository")
 */
class Client
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @Gedmo\Slug(fields={"name"}, updatable=true, separator="_")
     * @ORM\Column(length=128, unique=true)
     */
    protected $slug;

    /**
     * @var string
     *
     * @ORM\Column(name="adresse", type="text", nullable=true)
     */
    private $adresse;

    /**
     * @var string
     *
     * @ORM\Column(name="representant", type="string", length=255)
     */
    private $representant;

    /**
     * @var date
     *
     * @ORM\Column(name="created", type="date")
     */
    protected $created;

    /**
     * @Assert\Email(
     *     message = "Cette valeur '{{ value }}' n'est pas un email valide."
     * )
     * @ORM\Column(name="email_entreprise", type="string", length=255, nullable=true)
     */
    protected $email_entreprise;

    /**
     * @Assert\Email(
     *     message = "Cette valeur '{{ value }}' n'est pas un email valide."
     * )
     * @ORM\Column(name="email_represent", type="string", length=255, nullable=true)
     */
    protected $email_represent;

    /**
     * @ORM\OneToMany(targetEntity="Labs\FacturationBundle\Entity\Proforma", mappedBy="clients")
     */
    protected $proformas;



    /**
     * Constructor
     */
    public function __construct()
    {
        $this->proformas = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set name
     *
     * @param string $name
     * @return Client
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set slug
     *
     * @param string $slug
     * @return Client
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug
     *
     * @return string 
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set adresse
     *
     * @param string $adresse
     * @return Client
     */
    public function setAdresse($adresse)
    {
        $this->adresse = $adresse;

        return $this;
    }

    /**
     * Get adresse
     *
     * @return string 
     */
    public function getAdresse()
    {
        return $this->adresse;
    }

    /**
     * Set representant
     *
     * @param string $representant
     * @return Client
     */
    public function setRepresentant($representant)
    {
        $this->representant = $representant;

        return $this;
    }

    /**
     * Get representant
     *
     * @return string 
     */
    public function getRepresentant()
    {
        return $this->representant;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return Client
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
     * Set email_entreprise
     *
     * @param string $emailEntreprise
     * @return Client
     */
    public function setEmailEntreprise($emailEntreprise)
    {
        $this->email_entreprise = $emailEntreprise;

        return $this;
    }

    /**
     * Get email_entreprise
     *
     * @return string 
     */
    public function getEmailEntreprise()
    {
        return $this->email_entreprise;
    }

    /**
     * Set email_represent
     *
     * @param string $emailRepresent
     * @return Client
     */
    public function setEmailRepresent($emailRepresent)
    {
        $this->email_represent = $emailRepresent;

        return $this;
    }

    /**
     * Get email_represent
     *
     * @return string 
     */
    public function getEmailRepresent()
    {
        return $this->email_represent;
    }

    /**
     * Add proformas
     *
     * @param \Labs\FacturationBundle\Entity\Proforma $proformas
     * @return Client
     */
    public function addProforma(\Labs\FacturationBundle\Entity\Proforma $proformas)
    {
        $this->proformas[] = $proformas;

        return $this;
    }

    /**
     * Remove proformas
     *
     * @param \Labs\FacturationBundle\Entity\Proforma $proformas
     */
    public function removeProforma(\Labs\FacturationBundle\Entity\Proforma $proformas)
    {
        $this->proformas->removeElement($proformas);
    }

    /**
     * Get proformas
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getProformas()
    {
        return $this->proformas;
    }
}
