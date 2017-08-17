<?php

namespace Labs\FacturationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Service
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Labs\FacturationBundle\Repository\ServiceRepository")
 */
class Service
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
     * @ORM\OneToMany(targetEntity="Labs\FacturationBundle\Entity\Proforma", mappedBy="services")
     */
    protected $proformas;



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
     * @return Service
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
     * Constructor
     */
    public function __construct()
    {
        $this->proformas = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add proformas
     *
     * @param \Labs\FacturationBundle\Entity\Proforma $proformas
     * @return Service
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
