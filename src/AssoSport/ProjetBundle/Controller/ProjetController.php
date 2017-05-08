<?php

namespace AssoSport\ProjetBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ProjetController extends Controller
{
    public function homeAction()
    {
        $utilisateur = $this->getUser();

        return $this->render('AssoSportProjetBundle:Projet:projet.html.twig', array('utilisateur' => $utilisateur));
    }
}