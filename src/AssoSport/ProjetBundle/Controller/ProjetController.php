<?php

namespace AssoSport\ProjetBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use AssoSport\AccueilBundle\Entity\Activite;
use Symfony\Component\HttpFoundation\Request;

use AssoSport\AdherentBundle\Form\ActiviteProjetType;
use \DateTime;

class ProjetController extends Controller
{
    public function homeAction()
    {
        $utilisateur = $this->getUser();

        //Récupération de la distance à effectuer par semaine
        $repositoryProfilProjet = $this->getDoctrine()
            ->getManager()
            ->getRepository('AssoSport\ProjetBundle\Entity\ProfilProjet')
        ;
        $monProfilProjet = $repositoryProfilProjet->findOneBy(array('id' => $utilisateur->getProfilProjet()));

        //Distance à effectuer durant toute la durée du projet
        $distanceARealiser = ($monProfilProjet->getDistance()) * 47;

        // Récupération des activités effectuées durant la semaine
        $repositoryActivites = $this->getDoctrine()
            ->getManager()
            ->getRepository('AssoSport\AccueilBundle\Entity\Activite')
        ;
        $date = new DateTime('last Monday');
        $listActivites = $repositoryActivites->findActivitesAdherent($utilisateur->getId(), $date);

        $distanceSemaine = 0;
        foreach($listActivites as $activiteSemaine){
            $distanceSemaine += $activiteSemaine->getDistanceKm();
        }

        // Récupération des activités effectuées depuis le début du projet
        $repositoryActivitesAdherent = $this->getDoctrine()
            ->getManager()
            ->getRepository('AssoSport\AccueilBundle\Entity\Activite')
        ;
        $listActivitesAdherent = $repositoryActivites->findAllActivitesAdherent($utilisateur->getId());

        $distanceAdherent = 0;
        foreach($listActivitesAdherent as $activiteAdherent){
            $distanceAdherent += $activiteAdherent->getDistanceKm();
        }

        //Calcul de la distance totale effectuée pour le projet
        $repositoryActivitesAll = $this->getDoctrine()
            ->getManager()
            ->getRepository('AssoSport\AccueilBundle\Entity\Activite')
        ;
        $listActivitesAll = $repositoryActivitesAll->findAllActivitesProjet();

        $distanceTotale = 0;
        foreach($listActivitesAll as $activite){
            $distanceTotale += $activite->getDistanceKm();
        }
        $distanceTerreLune = 384400;
        $distancePourcentage = ($distanceTotale / $distanceTerreLune) * 100;

        return $this->render('AssoSportProjetBundle:Projet:projet.html.twig', array('utilisateur' => $utilisateur, 'listActivites' => $listActivites, 'distanceSemaine' => $distanceSemaine,  'distanceTotale' => $distanceTotale, 'distanceAdherent' => $distanceAdherent, 'monProfilProjet' => $monProfilProjet, 'distanceARealiser' => $distanceARealiser, 'distanceTerreLune' => $distanceTerreLune, 'distancePourcentage' => $distancePourcentage));
    }

    public function ajoutAction(Request $request)
    {
        $utilisateur = $this->getUser();

        $repositoryProjet = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('AssoSportAccueilBundle:Projet')
        ;
        $projet = $repositoryProjet->findOneBy(array('nom' => 'Objectif Lune'));

        $repositoryProjet = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('AssoSportAccueilBundle:Projet')
        ;
        $projet = $repositoryProjet->findOneBy(array('nom' => 'Objectif Lune'));

        $activite = new Activite();

        $form = $this->createForm(ActiviteProjetType::class, $activite);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {

            $activite->setUtilisateur($utilisateur);
            $activite->setAdherent(0);
            $activite->setTemps(0);
            $activite->setBorg(6);
            $activite->setSensation(1);
            $activite->setProjet($projet);

            $em = $this->getDoctrine()->getManager();
            $em->persist($activite);
            $em->flush();

            $request->getSession()->getFlashBag()->add('notice', 'Nouvelle activité enregistrée.');

            return $this->redirectToRoute('asso_sport_projet_homepage');
        }

        return $this->render('AssoSportProjetBundle:Projet:form.html.twig', array(
            'form' => $form->createView(),
        ));
    }
}
