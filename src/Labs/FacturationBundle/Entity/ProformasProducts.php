<?php

namespace Labs\FacturationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ProformasProducts
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Labs\FacturationBundle\Repository\ProformasProductsRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class ProformasProducts
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
     * @var integer
     *
     * @ORM\Column(name="qte_cmd", type="integer")
     */
    protected $qteCmd;

    /**
     * @var bigint
     *
     * @ORM\Column(name="price", type="bigint")
     */
    protected $price;



    /**
     * @var float
     *
     * @ORM\Column(name="remise", type="float", nullable=true)
     */
    protected $remise;

    /**
     * @var bigint
     *
     * @ORM\Column(name="mont_ht", type="bigint")
     */
    protected $mont_ht;


    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created", type="date")
     */
    protected $created;

    /**
     * @var integer
     *
     * @ORM\Column(name="duration", type="integer", nullable= true, options={"comment" : "information à renseigné si la proforma est de type location"})
     */
    protected $duration;

    /**
     * @ORM\ManyToOne(targetEntity="Labs\FacturationBundle\Entity\Proforma", inversedBy="proformasproducts")
     * @ORM\JoinColumn(name="proforma_id", referencedColumnName="id")
     */
    protected $proformas;


    /**
     * @ORM\ManyToOne(targetEntity="Labs\FacturationBundle\Entity\Product", inversedBy="proformasproducts")
     * @ORM\JoinColumn(name="product_id", referencedColumnName="id")
     */
    protected $products;

    /**
     * Constructor
     */
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
     * Set qteCmd
     *
     * @param integer $qteCmd
     * @return ProformasProducts
     */
    public function setQteCmd($qteCmd)
    {
        $this->qteCmd = $qteCmd;

        return $this;
    }

    /**
     * Get qteCmd
     *
     * @return integer 
     */
    public function getQteCmd()
    {
        return $this->qteCmd;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return ProformasProducts
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
     * Set proformas
     *
     * @param \Labs\FacturationBundle\Entity\Proforma $proformas
     * @return ProformasProducts
     */
    public function setProformas(\Labs\FacturationBundle\Entity\Proforma $proformas = null)
    {
        $this->proformas = $proformas;

        return $this;
    }

    /**
     * Get proformas
     *
     * @return \Labs\FacturationBundle\Entity\Proforma 
     */
    public function getProformas()
    {
        return $this->proformas;
    }

    /**
     * Set products
     *
     * @param \Labs\FacturationBundle\Entity\Product $products
     * @return ProformasProducts
     */
    public function setProducts(\Labs\FacturationBundle\Entity\Product $products = null)
    {
        $this->products = $products;

        return $this;
    }

    /**
     * Get products
     *
     * @return \Labs\FacturationBundle\Entity\Product 
     */
    public function getProducts()
    {
        return $this->products;
    }

    /**
     * Set mont_ht
     *
     * @param integer $montHt
     * @return ProformasProducts
     */
    public function setMontHt($montHt)
    {
        $this->mont_ht = $montHt;

        return $this;
    }

    /**
     * Get mont_ht
     *
     * @return integer 
     */
    public function getMontHt()
    {
        return $this->mont_ht;
    }


    /**
     * Set remise
     *
     * @param float $remise
     * @return ProformasProducts
     */
    public function setRemise($remise)
    {
        $this->remise = $remise;

        return $this;
    }

    /**
     * Get remise
     *
     * @return float 
     */
    public function getRemise()
    {
        return $this->remise;
    }


    /**
     * Set price
     *
     * @param integer $price
     * @return ProformasProducts
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return integer 
     */
    public function getPrice()
    {
        return $this->price;
    }



    /**
     * Set duration
     *
     * @param integer $duration
     *
     * @return ProformasProducts
     */
    public function setDuration($duration)
    {
        $this->duration = $duration;

        return $this;
    }

    /**
     * Get duration
     *
     * @return integer
     */
    public function getDuration()
    {
        return $this->duration;
    }
}
