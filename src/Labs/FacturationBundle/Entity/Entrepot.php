<?php

namespace Labs\FacturationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;


/**
 * Entrepot
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Labs\FacturationBundle\Repository\EntrepotRepository")
 */
class Entrepot
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
     * @Gedmo\Slug(fields={"name"}, updatable=true, separator="_")
     * @ORM\Column(length=128, unique=true)
     */
    protected $slug;


    /**
     * @var string
     *
     * @ORM\Column(name="lng", type="string", length=255, nullable=true)
     */
   protected $lng;

    /**
     * @var string
     *
     * @ORM\Column(name="lnt", type="string", length=255,  nullable=true)
     */
   protected $lnt;

    /**
     * @var date
     *
     * @ORM\Column(name="created", type="date")
     */
    protected $created;

    /**
     * @var
     *
     * @ORM\ManyToOne(targetEntity="Labs\FacturationBundle\Entity\Site", inversedBy="entrepots")
     */
    protected $site;

    /**
     * @var
     *
     * @ORM\OneToMany(targetEntity="Labs\FacturationBundle\Entity\Stock", mappedBy="entrepot")
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
     * @return Entrepot
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
     * @return Entrepot
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
     * Set lng
     *
     * @param string $lng
     * @return Entrepot
     */
    public function setLng($lng)
    {
        $this->lng = $lng;

        return $this;
    }

    /**
     * Get lng
     *
     * @return string 
     */
    public function getLng()
    {
        return $this->lng;
    }

    /**
     * Set lnt
     *
     * @param string $lnt
     * @return Entrepot
     */
    public function setLnt($lnt)
    {
        $this->lnt = $lnt;

        return $this;
    }

    /**
     * Get lnt
     *
     * @return string 
     */
    public function getLnt()
    {
        return $this->lnt;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return Entrepot
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
     * Set site
     *
     * @param \Labs\FacturationBundle\Entity\Site $site
     * @return Entrepot
     */
    public function setSite(\Labs\FacturationBundle\Entity\Site $site = null)
    {
        $this->site = $site;

        return $this;
    }

    /**
     * Get site
     *
     * @return \Labs\FacturationBundle\Entity\Site 
     */
    public function getSite()
    {
        return $this->site;
    }

    /**
     * Add stock
     *
     * @param \Labs\FacturationBundle\Entity\Stock $stock
     * @return Entrepot
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
}
