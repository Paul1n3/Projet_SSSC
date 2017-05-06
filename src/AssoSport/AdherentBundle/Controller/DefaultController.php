<?php

namespace AssoSport\AdherentBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AssoSport\AccueilBundle\Entity\Activite;
use AssoSport\UserBundle\Entity\Utilisateur;
use AssoSport\AccueilBundle\Entity\Projet;
use AssoSport\AccueilBundle\Entity\TypeSport;
use AssoSport\AccueilBundle\Entity\Profil;
use AssoSport\AdherentBundle\Form\ActiviteType;

class DefaultController extends Controller
{
    public function ajoutAction(Request $request)
    {
        $activite = new Activite();
		$form = $this->createForm(ActiviteType::class, $activite);
		if($request->isMethod('POST')){
			if ($form->handleRequest($request)->isValid()) {
				$em = $this->getDoctrine()->getManager();
				$em->persist($activite);
				$em->flush();
			
				return $this->redirect($this->generateUrl('site_index_stats'));
			}
		}
		
		return $this->render('AssoSportAdherentBundle:Default:form.html.twig', array('form' => $form->createView()));
    }
}
