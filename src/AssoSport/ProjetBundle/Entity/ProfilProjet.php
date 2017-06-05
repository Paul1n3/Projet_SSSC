<?php

namespace AssoSport\ProjetBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * ProfilProjet
 *
 * @ORM\Table(name="profil_projet")
 * @ORM\Entity(repositoryClass="AssoSport\ProjetBundle\Repository\ProfilProjetRepository")
 */
class ProfilProjet
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
     * @ORM\Column(name="NomProfilProjet", type="string", length=255)
     */
    private $nomProfilProjet;

    /**
     * @var string
     *
     * @ORM\Column(name="NomCategorie", type="string", length=255)
     */
    private $nomCategorie;

    /**
     * @var int
     *
     * @ORM\Column(name="Distance", type="integer")
     * @Assert\Range(min=0, minMessage="Veuillez entrer une distance positive.")
     */
    private $distance;

    /**
     * @var int
     *
     * @ORM\Column(name="NbPlaces", type="integer")
     * @Assert\Range(min=0, minMessage="Veuillez entrer une distance positive.")
     */
    private $nbPlaces;

    /**
    * @ORM\ManyToOne(targetEntity="AssoSport\AccueilBundle\Entity\Projet")
    * @ORM\JoinColumn(nullable=false)
    */
    private $projetAssocie;


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
     * Set nomProfilProjet
     *
     * @param string $nomProfilProjet
     *
     * @return ProfilProjet
     */
    public function setNomProfilProjet($nomProfilProjet)
    {
        $this->nomProfilProjet = $nomProfilProjet;

        return $this;
    }

    /**
     * Get nomProfilProjet
     *
     * @return string
     */
    public function getNomProfilProjet()
    {
        return $this->nomProfilProjet;
    }

    /**
     * Set nomCategorie
     *
     * @param string $nomCategorie
     *
     * @return ProfilProjet
     */
    public function setNomCategorie($nomCategorie)
    {
        $this->nomCategorie = $nomCategorie;

        return $this;
    }

    /**
     * Get nomCategorie
     *
     * @return string
     */
    public function getNomCategorie()
    {
        return $this->nomCategorie;
    }

    /**
     * Set distance
     *
     * @param integer $distance
     *
     * @return ProfilProjet
     */
    public function setDistance($distance)
    {
        $this->distance = $distance;

        return $this;
    }

    /**
     * Get distance
     *
     * @return int
     */
    public function getDistance()
    {
        return $this->distance;
    }

    /**
     * Set nbPlaces
     *
     * @param integer $nbPlaces
     *
     * @return ProfilProjet
     */
    public function setNbPlaces($nbPlaces)
    {
        $this->nbPlaces = $nbPlaces;

        return $this;
    }

    /**
     * Get nbPlaces
     *
     * @return int
     */
    public function getNbPlaces()
    {
        return $this->nbPlaces;
    }

    /**
     * Set projetAssocie
     *
     * @param \AssoSport\AccueilBundle\Entity\Projet $projetAssocie
     *
     * @return ProfilProjet
     */
    public function setProjetAssocie(\AssoSport\AccueilBundle\Entity\Projet $projetAssocie)
    {
        $this->projetAssocie = $projetAssocie;

        return $this;
    }

    /**
     * Get projetAssocie
     *
     * @return \AssoSport\AccueilBundle\Entity\Projet
     */
    public function getProjetAssocie()
    {
        return $this->projetAssocie;
    }
}
