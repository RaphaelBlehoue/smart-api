<?php

namespace Labs\FacturationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints AS Assert;


/**
 * Compagny
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Labs\FacturationBundle\Repository\CompagnyRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Compagny
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
     * @Assert\File(maxSize="100000000")
     */
    public $file;


    protected $tempFilename;

    /**
     * @var string
     *
     * @ORM\Column(name="country", type="string", length=255)
     */
    protected $country;

    /**
     * @var string
     *
     * @ORM\Column(name="bank", type="string", length=255)
     */
    protected $bank;

    /**
     * @var string
     *
     * @ORM\Column(name="compte_cc", type="string", length=255, nullable=true)
     */
    protected $compte_cc;

    /**
     * @var string
     *
     * @ORM\Column(name="center_impot", type="string", length=255, nullable=true)
     */
    protected $center_impot;

    /**
     * @var string
     *
     * @ORM\Column(name="city", type="string", length=255)
     */
    protected $city;

    /**
     * @var string
     *
     * @ORM\Column(name="adresse", type="text")
     */
    protected $adresse;

    /**
     * @var string
     *
     * @ORM\Column(name="street", type="string", length=255)
     */
    protected $street;

    /**
     * @var string
     *
     * @ORM\Column(name="regime", type="string", length=255)
     */
    protected $regime;

    /**
     * @var string
     *
     * @ORM\Column(name="phone", type="string", length=255)
     */
    protected $phone;

    /**
     * @var string
     *
     * @ORM\Column(name="represent", type="string", length=255)
     */
    protected $represent;

    /**
     * @var string
     *
     * @ORM\Column(name="phone_two", type="string", length=255)
     */
    protected $phoneTwo;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    protected $name;

    /**
     * @var string
     *
     * @ORM\Column(name="url", type="string", length=255, nullable=true)
     */
    protected $url;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255)
     */
    protected $email;

    /**
     * @var string
     *
     * @ORM\Column(name="fax", type="string", length=255)
     */
    protected $fax;

    /**
     * @ORM\OneToMany(targetEntity="Labs\FacturationBundle\Entity\Proforma", mappedBy="compagny")
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
     * Set country
     *
     * @param string $country
     * @return Compagny
     */
    public function setCountry($country)
    {
        $this->country = $country;

        return $this;
    }

    /**
     * Get country
     *
     * @return string 
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * Set bank
     *
     * @param string $bank
     * @return Compagny
     */
    public function setBank($bank)
    {
        $this->bank = $bank;

        return $this;
    }

    /**
     * Get bank
     *
     * @return string 
     */
    public function getBank()
    {
        return $this->bank;
    }

    /**
     * Set city
     *
     * @param string $city
     * @return Compagny
     */
    public function setCity($city)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get city
     *
     * @return string 
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set adresse
     *
     * @param string $adresse
     * @return Compagny
     */
    public function setAdresse($adresse)
    {
        $this->adresse = $adresse;

        return $this;
    }

    /**
     * Get adresse
     *
     * @return string 
     */
    public function getAdresse()
    {
        return $this->adresse;
    }

    /**
     * Set street
     *
     * @param string $street
     * @return Compagny
     */
    public function setStreet($street)
    {
        $this->street = $street;

        return $this;
    }

    /**
     * Get street
     *
     * @return string 
     */
    public function getStreet()
    {
        return $this->street;
    }

    /**
     * Set regime
     *
     * @param string $regime
     * @return Compagny
     */
    public function setRegime($regime)
    {
        $this->regime = $regime;

        return $this;
    }

    /**
     * Get regime
     *
     * @return string 
     */
    public function getRegime()
    {
        return $this->regime;
    }

    /**
     * Set phone
     *
     * @param string $phone
     * @return Compagny
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get phone
     *
     * @return string 
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set represent
     *
     * @param string $represent
     * @return Compagny
     */
    public function setRepresent($represent)
    {
        $this->represent = $represent;

        return $this;
    }

    /**
     * Get represent
     *
     * @return string 
     */
    public function getRepresent()
    {
        return $this->represent;
    }

    /**
     * Set phoneTwo
     *
     * @param string $phoneTwo
     * @return Compagny
     */
    public function setPhoneTwo($phoneTwo)
    {
        $this->phoneTwo = $phoneTwo;

        return $this;
    }

    /**
     * Get phoneTwo
     *
     * @return string 
     */
    public function getPhoneTwo()
    {
        return $this->phoneTwo;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Compagny
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
     * Set email
     *
     * @param string $email
     * @return Compagny
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set fax
     *
     * @param string $fax
     * @return Compagny
     */
    public function setFax($fax)
    {
        $this->fax = $fax;

        return $this;
    }

    /**
     * Get fax
     *
     * @return string 
     */
    public function getFax()
    {
        return $this->fax;
    }

    public function setFile(UploadedFile $file)
    {
        $this->file = $file;
        if(null !== $this->url)
        {
            $this->tempFilename = $this->url;
            $this->url = null;
        }else{
            $this->url = 'initial';
        }
    }

    public function getFile()
    {
        return $this->file;
    }

    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function preUpload()
    {

        if (null !== $this->getFile()) {
            // generation d'un nom unique pour le fichier
            $filename = sha1(uniqid(mt_rand(), true));
            // Le nom du fichier est son id, on doit juste stocker également son extension
            // Pour faire propre, on devrait renommer cet attribut en « extension », plutôt que « icon »
            $this->url = $filename.'.'.$this->getFile()->guessExtension();
        }

    }

    /**
     * @ORM\PostPersist()
     * @ORM\PostUpdate()
     */
    public function upload()
    {
        // Si jamais il n'y a pas de fichier (champ facultatif)
        if (null === $this->getFile()) {
            return;
        }

        // On déplace le fichier envoyé dans le répertoire de notre choix
        $this->file->move(
            $this->getUploadRootDir(), // Le répertoire de destination
            $this->url  // Le nom du fichier à créer, ici « id.extension »
        );

        // check if we have an old image
        /* if (isset($this->tempFilename)) {
             // delete the old image
             unlink($this->getUploadRootDir().'/'.$this->tempFilename);
             // clear the temp image path
             $this->tempFilename = null;
         }*/
        $this->file = null;
    }

    public function getAbsolutePath()
    {
        return null === $this->url
            ? null
            : $this->getUploadRootDir().'/'.$this->url;
    }

    /**
     * @ORM\PostRemove()
     */
    public function removeUpload()
    {
        $file = $this->getAbsolutePath();
        if ($file) {
            unlink($file);
        }
    }


    public function getUploadDir()
    {
        // On retourne le chemin relatif vers l'image pour un navigateur
        return 'uploads/compagny';
    }


    protected function getUploadRootDir()
    {
        // On retourne le chemin relatif vers l'image pour notre code PHP
        return __DIR__.'/../../../../web/'.$this->getUploadDir();
    }


    /**
     * @return string
     */
    public function getAssertPath()
    {
        return $this->getUploadDir().'/'.$this->url;
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
     * @return Compagny
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

    /**
     * Set compte_cc
     *
     * @param string $compteCc
     * @return Compagny
     */
    public function setCompteCc($compteCc)
    {
        $this->compte_cc = $compteCc;

        return $this;
    }

    /**
     * Get compte_cc
     *
     * @return string 
     */
    public function getCompteCc()
    {
        return $this->compte_cc;
    }

    /**
     * Set center_impot
     *
     * @param string $centerImpot
     * @return Compagny
     */
    public function setCenterImpot($centerImpot)
    {
        $this->center_impot = $centerImpot;

        return $this;
    }

    /**
     * Get center_impot
     *
     * @return string 
     */
    public function getCenterImpot()
    {
        return $this->center_impot;
    }

    /**
     * Set url
     *
     * @param string $url
     * @return Compagny
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url
     *
     * @return string 
     */
    public function getUrl()
    {
        return $this->url;
    }
}
