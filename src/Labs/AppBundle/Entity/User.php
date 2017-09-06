<?php

namespace Labs\AppBundle\Entity;

//use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * User
 *
 * @ORM\Table(name="Users")
 * @ORM\Entity
 */
class User /*extends BaseUser*/
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
     * @ORM\OneToMany(targetEntity="Quotation", mappedBy="user")
     */
    protected $quotations;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->quotations = new ArrayCollection();
    }

    /**
     * Get id
     *
     * @return guid
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set firstname
     *
     * @param string $firstname
     *
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
     *
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
     * Add quotation
     *
     * @param \Labs\AppBundle\Entity\Quotation $quotation
     *
     * @return User
     */
    public function addQuotation(\Labs\AppBundle\Entity\Quotation $quotation)
    {
        $this->quotations[] = $quotation;

        return $this;
    }

    /**
     * Remove quotation
     *
     * @param \Labs\AppBundle\Entity\Quotation $quotation
     */
    public function removeQuotation(\Labs\AppBundle\Entity\Quotation $quotation)
    {
        $this->quotations->removeElement($quotation);
    }

    /**
     * Get quotations
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getQuotations()
    {
        return $this->quotations;
    }
}
