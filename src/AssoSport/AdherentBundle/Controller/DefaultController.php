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
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Constraints\DateTime;

class DefaultController extends Controller
{
    public function ajoutAction(Request $request)
    {
		$utilisateur = $this->getUser();
        $activite = new Activite();
		$form = $this->createForm(ActiviteType::class, $activite);
		if($request->isMethod('POST')){
			if ($form->handleRequest($request)->isValid()) {
				$activite->setAdherent(1);
				$activite->setUtilisateur($utilisateur);
				$em = $this->getDoctrine()->getManager();
				$em->persist($activite);
				$em->flush();

				$repositoryActivites = $this->getDoctrine()
					->getManager()
					->getRepository('AssoSport\AccueilBundle\Entity\Activite')
				;
				$listActivitesSemaine = $repositoryActivites->findActivitesAdherent($utilisateur->getId(), new \DateTime("last Monday"), new \DateTime('now'));
				$tempsSemaine=0;
				foreach($listActivitesSemaine as $activite){
					$tempsSemaine += $activite->getTemps();
				}
				$objectif = $utilisateur->getProfilActuel();
				if($tempsSemaine >= $objectif->getTemps()){
					return $this->redirect($this->generateUrl('asso_sport_adherent_badge'));
				}

				return $this->redirect($this->generateUrl('asso_sport_adherent_carnetbord'));
			}
		}

		return $this->render('AssoSportAdherentBundle:Default:form.html.twig', array('form' => $form->createView()));
    }

	public function carnetbordAction(Request $request)
	{

		$utilisateur = $this->getUser();
		if($utilisateur==null){
			return $this->redirect($this->generateUrl('login'));
		}

		// On récupère le repository Activite
		$repositoryActivites = $this->getDoctrine()
			->getManager()
			->getRepository('AssoSport\AccueilBundle\Entity\Activite')
		;
		// Liste activité de la semaine
		$listActivitesSemaine = $repositoryActivites->findActivitesAdherent($utilisateur->getId(), new \DateTime("last Monday"), new \DateTime('now'));
		// Temps total de la semaine
		$tempsSemaine = 0;
		// Distance totale de la semaine
		$distanceSemaine = 0;
		// Nombre activités différentes
		//$nombreActivitesSemaine = $repositoryActivites->findDistinctActivitesAdherent($utilisateur->getId(),$cetteSemaine);
		// Moyenne de la sensation
		$sensationTotale = 0;
		$moyenneSensation = 0;
		$sensation1=0; $sensation2=0; $sensation3=0; $sensation4=0;
		//Boucle
		foreach($listActivitesSemaine as $activite){
			$tempsSemaine += $activite->getTemps();
			$distanceSemaine += $activite->getDistanceKm();
			$sensationTotale += $activite->getSensation();
			switch($activite->getSensation()){
				case 1:
					$sensation1++;
					break;
				case 2:
					$sensation2++;
					break;
				case 3:
					$sensation3++;
					break;
				case 4:
					$sensation4++;
					break;
			}
		}
		if(count($listActivitesSemaine) != 0){
			$moyenneSensation = $sensationTotale/count($listActivitesSemaine);
		}

		$content = $this->get('templating')->render('AssoSportAdherentBundle:Default:carnetbord.html.twig', array(
			'utilisateur' => $utilisateur,
			'listActivites' => $listActivitesSemaine,
			'tempsSemaine' => $tempsSemaine,
			'distanceSemaine' => $distanceSemaine,
			//'nombreActivitesSemaine' => $nombreActivitesSemaine,
			'moyenneSensation' => $moyenneSensation,
			'sensationTotale' => $sensationTotale,
			'sensation1' => $sensation1,
			'sensation2' => $sensation2,
			'sensation3' => $sensation3,
			'sensation4' =>	$sensation4
		));
		return new Response($content);
	}

	public function statsAction(Request $request)
	{
		$utilisateur = $this->getUser();
		if($utilisateur==null){
			return $this->redirect($this->generateUrl('login'));
		}
		// On récupère le repository Activite
		$repositoryActivites = $this->getDoctrine()
			->getManager()
			->getRepository('AssoSport\AccueilBundle\Entity\Activite')
		;

		// Liste activité du mois
		$dateCeMois = date('M');
		$tempsMois = 0; $sensation = 0; $moyenneSensation = 0;
		$listActivitesMois = $repositoryActivites->findActivitesAdherent($utilisateur->getId(),new \DateTime('first day of this month'), new \DateTime('now'));
		foreach($listActivitesMois as $activite){
			$tempsMois += $activite->getTemps();
			$sensation += $activite->getSensation();
		}
		if(count($listActivitesMois) != 0){
			$moyenneSensation = $sensation/count($listActivitesMois);
		}

		// Mois -1
		$dateMois1 = date('M',strtotime('-1 month'));
		$listActivitesMois1 = $repositoryActivites->findActivitesAdherent($utilisateur->getId(),new \DateTime('first day of last month'), new \DateTime('first day of this month'));
		$tempsMois1 = 0; $sensation1 = 0; $moyenneSensation1 = 0;
		foreach($listActivitesMois1 as $activite){
			$tempsMois1 += $activite->getTemps();
			$sensation1 += $activite->getSensation();
		}
		if(count($listActivitesMois1) != 0){
			$moyenneSensation1 = $sensation1/count($listActivitesMois1);
		}

		//Mois -2
		$dateMois2 = date('M',strtotime('-2 month'));
		$listActivitesMois2 = $repositoryActivites->findActivitesAdherent($utilisateur->getId(), new \DateTime('last day of 3 months ago'), new \DateTime('last day of 2 months ago'));
		$tempsMois2 = 0; $sensation2 = 0; $moyenneSensation2 = 0;
		foreach($listActivitesMois2 as $activite){
			$tempsMois2 += $activite->getTemps();
			$sensation2 += $activite->getSensation();
		}
		if(count($listActivitesMois2) != 0){
			$moyenneSensation2 = $sensation2/count($listActivitesMois2);
		}

		//Mois -3
		$dateMois3 = date('M',strtotime('-3 month'));
		$listActivitesMois3 = $repositoryActivites->findActivitesAdherent($utilisateur->getId(), new \DateTime('last day of 4 months ago'), new \DateTime('last day of 3 months ago'));
		$tempsMois3 = 0; $sensation3 = 0; $moyenneSensation3 = 0;
		foreach($listActivitesMois3 as $activite){
			$tempsMois3 += $activite->getTemps();
			$sensation3 += $activite->getSensation();
		}
		if(count($listActivitesMois3) != 0){
			$moyenneSensation3 = $sensation3/count($listActivitesMois3);
		}

		$content = $this->get('templating')->render('AssoSportAdherentBundle:Default:stats.html.twig', array(
			'utilisateur' => $utilisateur,
			'dateCeMois' => $dateCeMois,
			'dateMois1' => $dateMois1,
			'dateMois2' => $dateMois2,
			'dateMois3' => $dateMois3,
			'tempsMois' => $tempsMois,
			'tempsMois1' => $tempsMois1,
			'tempsMois2' => $tempsMois2,
			'tempsMois3' => $tempsMois3,
			'moyenneSensation' => $moyenneSensation,
			'moyenneSensation1' => $moyenneSensation1,
			'moyenneSensation2' => $moyenneSensation2,
			'moyenneSensation3' => $moyenneSensation3
		));
		return new Response($content);
	}

	public function badgeAction(){
		$utilisateur = $this->getUser();
		$objectif = $utilisateur->getProfilActuel();
		$content = $this->get('templating')->render('AssoSportAdherentBundle:Default:badge.html.twig', array(
			'utilisateur' => $utilisateur,
			'objectif' => $objectif
		));
		return new Response($content);
	}
}
