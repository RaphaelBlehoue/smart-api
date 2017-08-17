<?php

namespace Labs\FacturationBundle\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * Stock
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Labs\FacturationBundle\Repository\StockRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Stock
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
     * @ORM\Column(type="string", name="reference", length=8, options={"comment" : "référence de l'inventaire"})
     */
    protected $reference;

    /**
     * @var string
     *
     * @ORM\Column(type="string", name="sku", length=8, options={"comment" : "faire référence au produit relié a ce mouvement"})
     */
    protected $sku;

    /**
     * @var integer
     *
     * @ORM\Column(name="code_mouv", type="integer", options={"comment" : "correspond au status du mouvement du stock"})
     */
    protected $code_mouv;

    /**
     * @var string
     *
     * @ORM\Column(name="referrer", type="string", length=225, options={"comment" : "reference à la quelle ce mouvement est relié"}, nullable=true)
     */
    protected $referrer;


    /**
     * @var integer
     *
     * @ORM\Column(name="quantity", type="integer", nullable=false)
     */
    protected $quantity;

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
     * @ORM\ManyToOne(targetEntity="Labs\FacturationBundle\Entity\Product", inversedBy="stock")
     */
    protected $product;

    /**
     * @ORM\ManyToOne(targetEntity="Labs\FacturationBundle\Entity\Entrepot", inversedBy="stock")
     */
    protected $entrepot;

    /**
     * @ORM\ManyToOne(targetEntity="Labs\FacturationBundle\Entity\Mouvement", inversedBy="stock")
     */
    protected $mouvement;


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
     * Set sku
     *
     * @param string $sku
     * @return Stock
     */
    public function setSku($sku)
    {
        $this->sku = $sku;

        return $this;
    }

    /**
     * Get sku
     *
     * @return string 
     */
    public function getSku()
    {
        return $this->sku;
    }


    /**
     * Set quantity
     *
     * @param integer $quantity
     * @return Stock
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * Get quantity
     *
     * @return integer 
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return Stock
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
     * @return Stock
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
     * Set product
     *
     * @param \Labs\FacturationBundle\Entity\Product $product
     * @return Stock
     */
    public function setProduct(\Labs\FacturationBundle\Entity\Product $product = null)
    {
        $this->product = $product;

        return $this;
    }

    /**
     * Get product
     *
     * @return \Labs\FacturationBundle\Entity\Product 
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * Set entrepot
     *
     * @param \Labs\FacturationBundle\Entity\Entrepot $entrepot
     * @return Stock
     */
    public function setEntrepot(\Labs\FacturationBundle\Entity\Entrepot $entrepot = null)
    {
        $this->entrepot = $entrepot;

        return $this;
    }

    /**
     * Get entrepot
     *
     * @return \Labs\FacturationBundle\Entity\Entrepot 
     */
    public function getEntrepot()
    {
        return $this->entrepot;
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
     * Set code_mouv
     *
     * @param integer $codeMouv
     * @return Stock
     */
    public function setCodeMouv($codeMouv)
    {
        $this->code_mouv = $codeMouv;

        return $this;
    }

    /**
     * Get code_mouv
     *
     * @return integer 
     */
    public function getCodeMouv()
    {
        return $this->code_mouv;
    }

    /**
     * @ORM\PrePersist()
     */
    public function ramdomSku()
    {
        $code = bin2hex(uniqid(mcrypt_create_iv(8, MCRYPT_DEV_RANDOM)));
        $this->setReference($code);
    }

    /**
     * @ORM\PrePersist()
     */
    public function SaveSku()
    {
        $this->setSku($this->getProduct()->getReference());
    }

    /**
     * @ORM\PrePersist()
     */
    public function SaveReferrerCdt(){
        if($this->getMouvement()->getId() == 1){
            $this->referrer = "Manuel";
        }
    }

    /**
     * Set reference
     *
     * @param string $reference
     * @return Stock
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
     * Set referrer
     *
     * @param string $referrer
     * @return Stock
     */
    public function setReferrer($referrer)
    {
        $this->referrer = $referrer;

        return $this;
    }

    /**
     * Get referrer
     *
     * @return string 
     */
    public function getReferrer()
    {
        return $this->referrer;
    }

    /**
     * Set mouvement
     *
     * @param \Labs\FacturationBundle\Entity\Mouvement $mouvement
     * @return Stock
     */
    public function setMouvement(\Labs\FacturationBundle\Entity\Mouvement $mouvement = null)
    {
        $this->mouvement = $mouvement;

        return $this;
    }

    /**
     * Get mouvement
     *
     * @return \Labs\FacturationBundle\Entity\Mouvement 
     */
    public function getMouvement()
    {
        return $this->mouvement;
    }
}
