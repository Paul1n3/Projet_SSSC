<?php

namespace AssoSport\AccueilBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AccueilController extends Controller
{
    public function homeAction()
    {
        return $this->render('AssoSportAccueilBundle:Home:index.html.twig');
    }

}
