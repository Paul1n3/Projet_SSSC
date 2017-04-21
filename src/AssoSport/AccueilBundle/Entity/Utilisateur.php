<?php

namespace AssoSport\AccueilBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Utilisateur
 *
 * @ORM\Table(name="utilisateur")
 * @ORM\Entity(repositoryClass="AssoSport\AccueilBundle\Repository\UtilisateurRepository")
 */
class Utilisateur
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="Nom", type="string", length=255)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="Prenom", type="string", length=255)
     */
    private $prenom;

    /**
     * @var int
     *
     * @ORM\Column(name="Taille", type="integer")
     */
    private $taille;

    /**
     * @var int
     *
     * @ORM\Column(name="Age", type="integer")
     */
    private $age;

    /**
     * @var int
     *
     * @ORM\Column(name="Poids", type="integer")
     */
    private $poids;

    /**
     * @var string
     *
     * @ORM\Column(name="Sexe", type="string", length=255)
     */
    private $sexe;

    /**
     * @var string
     *
     * @ORM\Column(name="AdresseMail", type="string", length=255, unique=true)
     */
    private $adresseMail;

    /**
     * @var string
     *
     * @ORM\Column(name="MotDePasse", type="string", length=255)
     */
    private $motDePasse;

    /**
     * @var string
     *
     * @ORM\Column(name="Salt", type="string", length=255)
     */
    private $salt;

    /**
     * @var bool
     *
     * @ORM\Column(name="Adherent", type="boolean")
     */
    private $adherent;
    
    /**
   	 * @ORM\ManyToMany(targetEntity="AssoSport\AccueilBundle\Entity\Sport", cascade={"persist"})
     */
    private $sports;
    
    /**
    * @ORM\ManyToOne(targetEntity="AssoSport\AccueilBundle\Entity\Profil")
    * @ORM\JoinColumn(nullable=false)
    */
    private $profilActuel;



    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set nom
     *
     * @param string $nom
     *
     * @return Utilisateur
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set prenom
     *
     * @param string $prenom
     *
     * @return Utilisateur
     */
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;

        return $this;
    }

    /**
     * Get prenom
     *
     * @return string
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * Set taille
     *
     * @param integer $taille
     *
     * @return Utilisateur
     */
    public function setTaille($taille)
    {
        $this->taille = $taille;

        return $this;
    }

    /**
     * Get taille
     *
     * @return int
     */
    public function getTaille()
    {
        return $this->taille;
    }

    /**
     * Set age
     *
     * @param integer $age
     *
     * @return Utilisateur
     */
    public function setAge($age)
    {
        $this->age = $age;

        return $this;
    }

    /**
     * Get age
     *
     * @return int
     */
    public function getAge()
    {
        return $this->age;
    }

    /**
     * Set poids
     *
     * @param integer $poids
     *
     * @return Utilisateur
     */
    public function setPoids($poids)
    {
        $this->poids = $poids;

        return $this;
    }

    /**
     * Get poids
     *
     * @return int
     */
    public function getPoids()
    {
        return $this->poids;
    }

    /**
     * Set sexe
     *
     * @param string $sexe
     *
     * @return Utilisateur
     */
    public function setSexe($sexe)
    {
        $this->sexe = $sexe;

        return $this;
    }

    /**
     * Get sexe
     *
     * @return string
     */
    public function getSexe()
    {
        return $this->sexe;
    }

    /**
     * Set adresseMail
     *
     * @param string $adresseMail
     *
     * @return Utilisateur
     */
    public function setAdresseMail($adresseMail)
    {
        $this->adresseMail = $adresseMail;

        return $this;
    }

    /**
     * Get adresseMail
     *
     * @return string
     */
    public function getAdresseMail()
    {
        return $this->adresseMail;
    }

    /**
     * Set motDePasse
     *
     * @param string $motDePasse
     *
     * @return Utilisateur
     */
    public function setMotDePasse($motDePasse)
    {
        $this->motDePasse = $motDePasse;

        return $this;
    }

    /**
     * Get motDePasse
     *
     * @return string
     */
    public function getMotDePasse()
    {
        return $this->motDePasse;
    }

    /**
     * Set salt
     *
     * @param string $salt
     *
     * @return Utilisateur
     */
    public function setSalt($salt)
    {
        $this->salt = $salt;

        return $this;
    }

    /**
     * Get salt
     *
     * @return string
     */
    public function getSalt()
    {
        return $this->salt;
    }

    /**
     * Set adherent
     *
     * @param boolean $adherent
     *
     * @return Utilisateur
     */
    public function setAdherent($adherent)
    {
        $this->adherent = $adherent;

        return $this;
    }

    /**
     * Get adherent
     *
     * @return bool
     */
    public function getAdherent()
    {
        return $this->adherent;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->sports = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add sport
     *
     * @param \AssoSport\PlatformBundle\Entity\Sport $sport
     *
     * @return Utilisateur
     */
    public function addSport(\AssoSport\PlatformBundle\Entity\Sport $sport)
    {
        $this->sports[] = $sport;

        return $this;
    }

    /**
     * Remove sport
     *
     * @param \AssoSport\PlatformBundle\Entity\Sport $sport
     */
    public function removeSport(\AssoSport\PlatformBundle\Entity\Sport $sport)
    {
        $this->sports->removeElement($sport);
    }

    /**
     * Get sports
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSports()
    {
        return $this->sports;
    }

    /**
     * Set profilActuel
     *
     * @param \AssoSport\AccueilBundle\Entity\Profil $profilActuel
     *
     * @return Utilisateur
     */
    public function setProfilActuel(\AssoSport\AccueilBundle\Entity\Profil $profilActuel)
    {
        $this->profilActuel = $profilActuel;

        return $this;
    }

    /**
     * Get profilActuel
     *
     * @return \AssoSport\AccueilBundle\Entity\Profil
     */
    public function getProfilActuel()
    {
        return $this->profilActuel;
    }
}
