<?php

namespace Labs\AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Movement
 *
 * @ORM\Table("movements")
 * @ORM\Entity(repositoryClass="Labs\AppBundle\Repository\MovementRepository")
 */
class Movement
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
     * @var integer
     *
     * @ORM\Column(name="code", type="integer")
     */
    protected $code;

    /**
     * @ORM\OneToMany(targetEntity="Inventory", mappedBy="movement")
     */
    protected $inventories;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->inventories = new ArrayCollection();
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
     *
     * @return Movement
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
     * Set code
     *
     * @param integer $code
     *
     * @return Movement
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Get code
     *
     * @return integer
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Add inventory
     *
     * @param \Labs\AppBundle\Entity\Inventory $inventory
     *
     * @return Movement
     */
    public function addInventory(\Labs\AppBundle\Entity\Inventory $inventory)
    {
        $this->inventories[] = $inventory;

        return $this;
    }

    /**
     * Remove inventory
     *
     * @param \Labs\AppBundle\Entity\Inventory $inventory
     */
    public function removeInventory(\Labs\AppBundle\Entity\Inventory $inventory)
    {
        $this->inventories->removeElement($inventory);
    }

    /**
     * Get inventories
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getInventories()
    {
        return $this->inventories;
    }
}
