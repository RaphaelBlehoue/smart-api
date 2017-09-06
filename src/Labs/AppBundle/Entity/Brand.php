<?php

namespace Labs\AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Brand
 *
 * @ORM\Table("brands")
 * @ORM\Entity(repositoryClass="Labs\AppBundle\Repository\BrandRepository")
 */
class Brand
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
    * @Assert\NotBlank(message="Entrez une marque avant enregistrement")
    * @ORM\Column(name="name", type="string", length=255)
    */
    protected $name;

    /**
     * @ORM\OneToMany(targetEntity="Product", mappedBy="brand")
     */
    protected $products;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->products = new ArrayCollection();
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
     * @return Brand
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
     * Add product
     *
     * @param \Labs\AppBundle\Entity\Product $product
     *
     * @return Brand
     */
    public function addProduct(\Labs\AppBundle\Entity\Product $product)
    {
        $this->products[] = $product;

        return $this;
    }

    /**
     * Remove product
     *
     * @param \Labs\AppBundle\Entity\Product $product
     */
    public function removeProduct(\Labs\AppBundle\Entity\Product $product)
    {
        $this->products->removeElement($product);
    }

    /**
     * Get products
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getProducts()
    {
        return $this->products;
    }
}
