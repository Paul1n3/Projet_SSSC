<?php

namespace AssoSport\AdherentBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('AssoSportAdherentBundle:Default:index.html.twig');
    }
}
