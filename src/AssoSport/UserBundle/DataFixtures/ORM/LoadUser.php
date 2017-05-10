<?php
// src/OC/UserBundle/DataFixtures/ORM/LoadUser.php

namespace AssoSport\UserBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AssoSport\UserBundle\Entity\utilisateur;
use AssoSport\AccueilBundle\Entity\profil;
use AssoSport\AccueilBundle\Entity\projet;

class LoadUser implements FixtureInterface
{
  public function load(ObjectManager $manager)
  {
    // Les noms d'utilisateurs à créer
    $listNames = array('Alexandre', 'Marine', 'Anna');

    foreach ($listNames as $name) {
      // On crée l'utilisateur
      $user = new utilisateur;

      // Le nom d'utilisateur et le mot de passe sont identiques pour l'instant
      $user->setUsername($name);
      $user->setPassword($name);
      $user->setEmail('user@mail.com');
      $user->setNom($name);
      $user->setPrenom($name);
      $user->setTaille('1.5');
      $user->setPoids('8');
      $user->setSexe('M');
      $user->setAdherent('adherent');
      $mydate=new \DateTime();
      $user->setDateNaissance($mydate);


      // On ne se sert pas du sel pour l'instant
      $user->setSalt('');
      // On définit uniquement le role ROLE_USER qui est le role de base
      $user->setRoles(array('ROLE_ADHERENT_COMPLET'));

      // On le persiste
      $manager->persist($user);
    }

    // On déclenche l'enregistrement
    $manager->flush();
  }
}
