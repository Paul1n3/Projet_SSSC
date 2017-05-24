<?php

namespace AssoSport\AccueilBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AccueilController extends Controller
{
    public function homeAction()
    {
        return $this->render('AssoSportAccueilBundle:Home:index.html.twig');
    }

    public function connectAction()
    {
        return $this->render('AssoSportAccueilBundle:Home:connect.html.twig');
    }

    public function aProposAction()
    {
      return $this->render('AssoSportAccueilBundle:Home:apropos.html.twig');
    }

}
