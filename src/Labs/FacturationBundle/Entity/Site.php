<?php

namespace Labs\FacturationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints AS Assert;
/**
 * Site
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Labs\FacturationBundle\Repository\SiteRepository")
 */
class Site
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
     * @ORM\Column(name="lnt", type="string", length=255, nullable=true)
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
     * @ORM\OneToMany(targetEntity="Labs\FacturationBundle\Entity\Entrepot", mappedBy="site")
     */
    protected $entrepots;


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->entrepots = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return Site
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
     * Set lng
     *
     * @param string $lng
     * @return Site
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
     * @return Site
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
     * Add entrepots
     *
     * @param \Labs\FacturationBundle\Entity\Entrepot $entrepots
     * @return Site
     */
    public function addEntrepot(\Labs\FacturationBundle\Entity\Entrepot $entrepots)
    {
        $this->entrepots[] = $entrepots;

        return $this;
    }

    /**
     * Remove entrepots
     *
     * @param \Labs\FacturationBundle\Entity\Entrepot $entrepots
     */
    public function removeEntrepot(\Labs\FacturationBundle\Entity\Entrepot $entrepots)
    {
        $this->entrepots->removeElement($entrepots);
    }

    /**
     * Get entrepots
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getEntrepots()
    {
        return $this->entrepots;
    }

    /**
     * Set slug
     *
     * @param string $slug
     * @return Site
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
     * Set created
     *
     * @param \DateTime $created
     * @return Site
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
}
