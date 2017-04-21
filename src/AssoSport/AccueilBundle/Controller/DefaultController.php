<?php

namespace AssoSport\AccueilBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('AssoSportAccueilBundle:Default:index.html.twig');
    }
}
