<?php

namespace AssoSport\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use FOS\UserBundle\Model\User as BaseUser;


/**
 * Utilisateur
 *
 * @ORM\Table(name="utilisateur")
 * @ORM\Entity(repositoryClass="AssoSport\AccueilBundle\Repository\UtilisateurRepository")
 */
class Utilisateur extends BaseUser
{

    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="Nom", type="string", length=255)
     * @Assert\Length(min=2, minMessage="Le nom doit faire au moins {{ limit }} caractères.")
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="Prenom", type="string", length=255)
     * @Assert\Length(min=2, minMessage="Le prenom doit faire au moins {{ limit }} caractères.")
     */
    private $prenom;

    /**
     * @var int
     *
     * @ORM\Column(name="Taille", type="integer")
     * @Assert\Range(min=100, max =270)
     */
    private $taille;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="DateNaissance", type="date")
     */
    private $dateNaissance;

    /**
     * @var int
     *
     * @ORM\Column(name="Poids", type="integer")
     * @Assert\Range(min=30, max=130)
     */
    private $poids;

    /**
     * @var string
     *
     * @ORM\Column(name="Sexe", type="string", length=255)
     * @Assert\Length(min=1, max=1)
     */
    private $sexe;

    /**
     * @var bool
     *
     * @ORM\Column(name="Adherent", type="boolean")
     * @Assert\Valid()
     */
    private $adherent;
    
    /**
   	 * @ORM\ManyToMany(targetEntity="AssoSport\AccueilBundle\Entity\Sport", cascade={"persist"})
     * @Assert\Valid()
     */
    private $sports;
    
    /**
    * @ORM\ManyToOne(targetEntity="AssoSport\AccueilBundle\Entity\Profil", cascade={"persist"})
    * @ORM\JoinColumn(nullable=false)
    * @Assert\Valid()
    */
    private $profilActuel;
    
    /**
   	 * @ORM\ManyToMany(targetEntity="AssoSport\AccueilBundle\Entity\Profil", cascade={"persist"})
     * @Assert\Valid()
     */
    private $profils;
    
    /**
   	 * @ORM\ManyToMany(targetEntity="AssoSport\AccueilBundle\Entity\Projet", cascade={"persist"})
     * @Assert\Valid()
     */
    private $projets;

    /**
    * @ORM\ManyToOne(targetEntity="AssoSport\ProjetBundle\Entity\ProfilProjet", cascade={"persist"})
    * @ORM\JoinColumn(nullable=false)
    * @Assert\Valid()
    */
    private $profilProjet;

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();

        $this->sports = new \Doctrine\Common\Collections\ArrayCollection();
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

    /**
     * Add profil
     *
     * @param \AssoSport\AccueilBundle\Entity\Profil $profil
     *
     * @return Utilisateur
     */
    public function addProfil(\AssoSport\AccueilBundle\Entity\Profil $profil)
    {
        $this->profils[] = $profil;

        return $this;
    }

    /**
     * Remove profil
     *
     * @param \AssoSport\AccueilBundle\Entity\Profil $profil
     */
    public function removeProfil(\AssoSport\AccueilBundle\Entity\Profil $profil)
    {
        $this->profils->removeElement($profil);
    }

    /**
     * Get profils
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getProfils()
    {
        return $this->profils;
    }

    /**
     * Add projet
     *
     * @param \AssoSport\AccueilBundle\Entity\Projet $projet
     *
     * @return Utilisateur
     */
    public function addProjet(\AssoSport\AccueilBundle\Entity\Projet $projet)
    {
        $this->projets[] = $projet;

        return $this;
    }

    /**
     * Remove projet
     *
     * @param \AssoSport\AccueilBundle\Entity\Projet $projet
     */
    public function removeProjet(\AssoSport\AccueilBundle\Entity\Projet $projet)
    {
        $this->projets->removeElement($projet);
    }

    /**
     * Get projets
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getProjets()
    {
        return $this->projets;
    }

    /**
     * Set profilProjet
     *
     * @param \AssoSport\ProjetBundle\Entity\ProfilProjet $profilProjet
     *
     * @return Utilisateur
     */
    public function setProfilProjet(\AssoSport\ProjetBundle\Entity\ProfilProjet $profilProjet)
    {
        $this->profilProjet = $profilProjet;

        return $this;
    }

    /**
     * Get profilProjet
     *
     * @return \AssoSport\ProjetBundle\Entity\ProfilProjet
     */
    public function getProfilProjet()
    {
        return $this->profilProjet;
    }

    /**
     * Set dateNaissance
     *
     * @param \DateTime $dateNaissance
     *
     * @return Utilisateur
     */
    public function setDateNaissance($dateNaissance)
    {
        $this->dateNaissance = $dateNaissance;

        return $this;
    }

    /**
     * Get dateNaissance
     *
     * @return \DateTime
     */
    public function getDateNaissance()
    {
        return $this->dateNaissance;
    }
}
