<?php

namespace Labs\MembersBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="Users")
 */
class User extends BaseUser
{
    /**
     * @ORM\Column(type="guid")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="UUID")
     */
    protected $id;

    /**
     * @var string
     * @ORM\Column(name="firstname", type="string", length=225, nullable=true)
     */
    protected $firstname;

    /**
     * @var string
     * @ORM\Column(name="lastname", type="string", length=225, nullable=true)
     */
    protected $lastname;

    /**
     * @ORM\OneToMany(targetEntity="Labs\FacturationBundle\Entity\Proforma", mappedBy="users")
     */
    protected $proformas;


    public function __construct()
    {
        parent::__construct();
    }

    public function setEmail($email){
        parent::setEmail($email);
        $this->setUsername($email);
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
     * Set firstname
     *
     * @param string $firstname
     * @return User
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * Get firstname
     *
     * @return string 
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * Set lastname
     *
     * @param string $lastname
     * @return User
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * Get lastname
     *
     * @return string 
     */
    public function getLastname()
    {
        return $this->lastname;
    }


    /**
     * Add proformas
     *
     * @param \Labs\FacturationBundle\Entity\Proforma $proformas
     * @return User
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
