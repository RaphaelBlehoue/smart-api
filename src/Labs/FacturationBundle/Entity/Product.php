<?php

namespace Labs\FacturationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Gedmo\Mapping\Annotation as Gedmo;


/**
 * Product
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Labs\FacturationBundle\Repository\ProductRepository")
 * @UniqueEntity(
 *      fields={"reference", "name"},
 *      message="Cette valeur existe déjà dans la base de donnée des produits, renommez la"
 * )
 * @ORM\HasLifecycleCallbacks()
 */
class Product
{
    /**
     * @ORM\Column(type="string", length=36)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="UUID")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    protected $name;

    /**
     * @Gedmo\Slug(fields={"name"}, updatable=true, separator="_")
     * @ORM\Column(length=128, unique=true)
     */
    protected $slug;

    /**
     * @var string $reference
     *
     * @ORM\Column(name="reference", type="string", length=255, unique=true)
     * @Assert\NotNull()
     * @Assert\NotBlank()
     */
    protected $reference;

    /**
     * @var integer
     * @ORM\Column(name="buy_price", type="bigint", nullable=true, options={"comment" : "Prix d'achat de la machandise" })
     */
    protected $buy_price;

    /**
     * @var integer
     * @ORM\Column(name="hire_price", type="bigint", nullable=true , options={"comment" : "Prix de location de la machandise" })
     */
    protected $hire_price;

    /**
     * @var integer
     * @ORM\Column(name="cout", type="bigint", nullable=true , options={"comment" : "Cout du produit de type service" })
     */
    protected $cout;

    /**
     * @var float
     *
     * @ORM\Column(name="coef", type="float", nullable=true, options={"comment" : "coefficient de multiplication du produits pour la vente" })
     */
    protected $coef;

    /**
     * @var integer
     *
     * @ORM\Column(name="min_stock", type="integer", nullable=true , options={"comment" : "stock minimum du produit" })
     */
    protected $min_stock;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    protected $description;

    /**
     * @var boolean
     *
     * @ORM\Column(name="type", type="integer", nullable=true, options={"comment" : "Type de service : soit produit ou service"})
     * @Assert\NotBlank(message="Faite le choix de la nature du produit")
     * @Assert\NotNull(message="Ce champs doit faire l'objet d'une selection")
     */
    protected $type = 0;


    /**
     * @var date
     *
     * @ORM\Column(name="created", type="date")
     */
    protected $created;


    /**
     * @ORM\OneToMany(targetEntity="Labs\FacturationBundle\Entity\ProformasProducts", mappedBy="products")
     */
    protected $proformasproducts;

    /**
     * @ORM\ManyToOne(targetEntity="Labs\FacturationBundle\Entity\Unite", inversedBy="products")
     */
    protected $unites;

    /**
     * @ORM\ManyToOne(targetEntity="Labs\FacturationBundle\Entity\Category", inversedBy="products")
     */
    protected $category;

    /**
     * @ORM\ManyToOne(targetEntity="Labs\FacturationBundle\Entity\Mark", inversedBy="products")
     */
    protected $marks;

    /**
     * @ORM\OneToMany(targetEntity="Labs\FacturationBundle\Entity\Stock", mappedBy="product", cascade={"remove"})
     */
    protected $stock;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->stock = new \Doctrine\Common\Collections\ArrayCollection();
        $this->created = new \DateTime();
    }

    /**
     * Get id
     *
     * @return string 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Product
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
     * @return Product
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
     * Set reference
     *
     * @param string $reference
     * @return Product
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
     * Set buy_price
     *
     * @param integer $buyPrice
     * @return Product
     */
    public function setBuyPrice($buyPrice)
    {
        $this->buy_price = $buyPrice;

        return $this;
    }

    /**
     * Get buy_price
     *
     * @return integer 
     */
    public function getBuyPrice()
    {
        return $this->buy_price;
    }

    /**
     * Set coef
     *
     * @param float $coef
     * @return Product
     */
    public function setCoef($coef)
    {
        $this->coef = $coef;

        return $this;
    }

    /**
     * Get coef
     *
     * @return float 
     */
    public function getCoef()
    {
        return $this->coef;
    }

    /**
     * Set min_stock
     *
     * @param integer $minStock
     * @return Product
     */
    public function setMinStock($minStock)
    {
        $this->min_stock = $minStock;

        return $this;
    }

    /**
     * Get min_stock
     *
     * @return integer 
     */
    public function getMinStock()
    {
        return $this->min_stock;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Product
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return Product
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
     * Set unites
     *
     * @param \Labs\FacturationBundle\Entity\Unite $unites
     * @return Product
     */
    public function setUnites(\Labs\FacturationBundle\Entity\Unite $unites = null)
    {
        $this->unites = $unites;

        return $this;
    }

    /**
     * Get unites
     *
     * @return \Labs\FacturationBundle\Entity\Unite 
     */
    public function getUnites()
    {
        return $this->unites;
    }

    /**
     * Set category
     *
     * @param \Labs\FacturationBundle\Entity\Category $category
     * @return Product
     */
    public function setCategory(\Labs\FacturationBundle\Entity\Category $category = null)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return \Labs\FacturationBundle\Entity\Category 
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Set marks
     *
     * @param \Labs\FacturationBundle\Entity\Mark $marks
     * @return Product
     */
    public function setMarks(\Labs\FacturationBundle\Entity\Mark $marks = null)
    {
        $this->marks = $marks;

        return $this;
    }

    /**
     * Get marks
     *
     * @return \Labs\FacturationBundle\Entity\Mark 
     */
    public function getMarks()
    {
        return $this->marks;
    }

    /**
     * Add stock
     *
     * @param \Labs\FacturationBundle\Entity\Stock $stock
     * @return Product
     */
    public function addStock(\Labs\FacturationBundle\Entity\Stock $stock)
    {
        $this->stock[] = $stock;

        return $this;
    }

    /**
     * Remove stock
     *
     * @param \Labs\FacturationBundle\Entity\Stock $stock
     */
    public function removeStock(\Labs\FacturationBundle\Entity\Stock $stock)
    {
        $this->stock->removeElement($stock);
    }

    /**
     * Get stock
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getStock()
    {
        return $this->stock;
    }

    /**
     * Add proformasproducts
     *
     * @param \Labs\FacturationBundle\Entity\ProformasProducts $proformasproducts
     * @return Product
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
     * Set hire_price
     *
     * @param integer $hirePrice
     * @return Product
     */
    public function setHirePrice($hirePrice)
    {
        $this->hire_price = $hirePrice;

        return $this;
    }

    /**
     * Get hire_price
     *
     * @return integer 
     */
    public function getHirePrice()
    {
        return $this->hire_price;
    }

    /**
     * Set type
     *
     * @param boolean $type
     *
     * @return Product
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return boolean
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set cout
     *
     * @param integer $cout
     *
     * @return Product
     */
    public function setCout($cout)
    {
        $this->cout = $cout;

        return $this;
    }

    /**
     * Get cout
     *
     * @return integer
     */
    public function getCout()
    {
        return $this->cout;
    }

    /**
     * @ORM\PreUpdate()
     */
    public function updateData()
    {
        if($this->type == 1)
        {
            $this->setBuyPrice(null);
            $this->setHirePrice(null);
            $this->setCoef(null);
            $this->setMinStock(null);
            $this->setUnites(null);
            $this->setMarks(null);
            return true;
        }else{
            $this->setCout(null);
            return true;
        }

    }
}
