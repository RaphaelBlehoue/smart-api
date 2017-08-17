<?php

namespace Labs\FacturationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Conditions
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Labs\FacturationBundle\Repository\ConditionsRepository")
 */
class Conditions
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
     * @ORM\Column(name="name", type="string", length=255)
     */
    protected $name;

    /**
     * @var string
     *
     * @ORM\Column(name="informations", type="text")
     */
    protected $informations;

    /**
     * @ORM\OneToMany(targetEntity="Labs\FacturationBundle\Entity\Proforma", mappedBy="conditions")
     */
    protected $proformas;

    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->proformas = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return Conditions
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
     * Set informations
     *
     * @param string $informations
     * @return Conditions
     */
    public function setInformations($informations)
    {
        $this->informations = $informations;

        return $this;
    }

    /**
     * Get informations
     *
     * @return string 
     */
    public function getInformations()
    {
        return $this->informations;
    }

    /**
     * Add proformas
     *
     * @param \Labs\FacturationBundle\Entity\Proforma $proformas
     * @return Conditions
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
