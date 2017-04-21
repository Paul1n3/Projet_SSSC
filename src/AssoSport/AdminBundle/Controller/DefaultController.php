<?php

namespace AssoSport\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('AssoSportAdminBundle:Default:index.html.twig');
    }
}
