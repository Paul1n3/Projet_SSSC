<?php

namespace AssoSport\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use AssoSport\AccueilBundle\Entity\Profil;
use AssoSport\AccueilBundle\Entity\Sport;
use AssoSport\AccueilBundle\Entity\Projet;
use AssoSport\AccueilBundle\Entity\TypeSport;
use AssoSport\ProjetBundle\Entity\ProfilProjet;

use AssoSport\AccueilBundle\Form\ProfilType;
use AssoSport\AccueilBundle\Form\SportType;
use AssoSport\AccueilBundle\Form\ProjetType;
use AssoSport\AccueilBundle\Form\TypeSportType;
use AssoSport\ProjetBundle\Form\ProfilProjetType;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminController extends Controller
{
    public function homeAction(Request $request){
        return $this->render('AssoSportAdminBundle:Default:index.html.twig');
    }

    public function profilAction(Request $request)
    {
        $profil = new Profil();
        $form   = $this->get('form.factory')->create(ProfilType::class, $profil);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($profil);
            $em->flush();

            $request->getSession()->getFlashBag()->add('notice', 'Nouveau profil enregistré.');

            return $this->redirectToRoute('asso_sport_admin_homepage');
      }

      return $this->render('AssoSportAdminBundle:Nouveautes:profil.html.twig', array(
          'form' => $form->createView(),
      ));
    }

    public function sportAction(Request $request)
    {
        $sport = new Sport();
        $form   = $this->get('form.factory')->create(SportType::class, $sport);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($sport);
            $em->flush();

            $request->getSession()->getFlashBag()->add('notice', 'Nouveau sport enregistré.');

            return $this->redirectToRoute('asso_sport_admin_homepage');
      }

      return $this->render('AssoSportAdminBundle:Nouveautes:sport.html.twig', array(
          'form' => $form->createView(),
      ));
    }

    public function projetAction(Request $request)
    {
        $projet = new Projet();
        $form   = $this->get('form.factory')->create(ProjetType::class, $projet);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($projet);
            $em->flush();

            $request->getSession()->getFlashBag()->add('notice', 'Nouveau projet enregistré.');

            return $this->redirectToRoute('asso_sport_admin_homepage');
      }

      return $this->render('AssoSportAdminBundle:Nouveautes:projet.html.twig', array(
          'form' => $form->createView(),
      ));
    }

    public function typesportAction(Request $request)
    {
        $typeSport = new TypeSport();
        $form   = $this->get('form.factory')->create(TypeSportType::class, $typeSport);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($typeSport);
            $em->flush();

            $request->getSession()->getFlashBag()->add('notice', 'Nouveau type de sport enregistré.');

            return $this->redirectToRoute('asso_sport_admin_homepage');
      }

      return $this->render('AssoSportAdminBundle:Nouveautes:typeSport.html.twig', array(
          'form' => $form->createView(),
      ));
    }

    public function profilprojetAction(Request $request)
    {
        $profilProjet = new ProfilProjet();
        $form   = $this->get('form.factory')->create(ProfilProjetType::class, $profilProjet);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($profilProjet);
            $em->flush();

            $request->getSession()->getFlashBag()->add('notice', 'Nouveau profil de projet enregistré.');

            return $this->redirectToRoute('asso_sport_admin_homepage');
      }

      return $this->render('AssoSportAdminBundle:Nouveautes:profilProjet.html.twig', array(
          'form' => $form->createView(),
      ));
    }

    public function listeAction(Request $request)
    {
      $repository = $this
        ->getDoctrine()
        ->getManager()
        ->getRepository('AssoSportUserBundle:Utilisateur')
      ;
    
      $listeUtilisateurs = $repository->myFindAll();

      return $this->render('AssoSportAdminBundle:Infos:liste.html.twig', array('utilisateurs' => $listeUtilisateurs));
    }

    public function assolisteAction(Request $request)
    {
      $repository = $this
        ->getDoctrine()
        ->getManager()
        ->getRepository('AssoSportUserBundle:Utilisateur')
      ;
    
      $listeUtilisateurs = $repository->findUtilisateurAsso();

      return $this->render('AssoSportAdminBundle:Infos:assoliste.html.twig', array('utilisateurs' => $listeUtilisateurs));
    }


    // Liste des participants au projet
    public function projetlisteAction()
    {
      $repositoryProjet = $this
        ->getDoctrine()
        ->getManager()
        ->getRepository('AssoSportAccueilBundle:Projet')
      ;
      $projet = $repositoryProjet->findOneBy(array('nom' => 'Objectif Lune'));

      $repositoryUtilisateur = $this
        ->getDoctrine()
        ->getManager()
        ->getRepository('AssoSportUserBundle:Utilisateur')
      ;
    
      $listeUtilisateurs = $repositoryUtilisateur->findUtilisateurProjet($projet);

      return $this->render('AssoSportAdminBundle:Infos:default.html.twig', array('liste', $listeUtilisateurs, 'projet' => $projet));
      
    }

    // Liste de toutes les activités rentrées sur le site
    public function activitesAction(Request $request)
    {
      $repositoryActivites = $this->getDoctrine()
        ->getManager()
        ->getRepository('AssoSport\AccueilBundle\Entity\Activite')
      ;
      $listActivites = $repositoryActivites->findAllActivites();
    
      $content = $this->get('templating')->render('AssoSportAdminBundle:Infos:activites.html.twig', array(
        'activites' => $listActivites
      ));
      return new Response($content);
    }

    public function activitespersoAction(Request $request)
    {
      $repositoryActivites = $this->getDoctrine()
        ->getManager()
        ->getRepository('AssoSport\AccueilBundle\Entity\Activite')
      ;
      $listActivites = $repositoryActivites->findAllActivitesAdherent(2);
    
      $content = $this->get('templating')->render('AssoSportAdminBundle:Infos:activitesperso.html.twig', array(
        'activites' => $listActivites
      ));
      return new Response($content);
    }

    public function distanceprojetAction(Request $request)
    {
      //Calcul de la distance totale effectuée pour le projet
      $repositoryActivitesAll = $this->getDoctrine()
        ->getManager()
        ->getRepository('AssoSport\AccueilBundle\Entity\Activite')
      ;
      $listActivitesAll = $repositoryActivitesAll->findAllActivitesProjet();

      //Récupération du projet
      $repositoryProjet = $this
        ->getDoctrine()
        ->getManager()
        ->getRepository('AssoSportAccueilBundle:Projet')
      ;
      $projet = $repositoryProjet->findOneBy(array('nom' => 'Objectif Lune'));

      $distanceTotale = 0;
      foreach($listActivitesAll as $activite){
        $distanceTotale += $activite->getDistanceKm();
      }
      return $this->render('AssoSportAdminBundle:Projet:distancetotale.html.twig', array(
        'distance' => $distanceTotale, 'projet' => $projet
      ));
    }

    public function activitespersoprojetAction(Request $request)
    {
      $repositoryActivites = $this->getDoctrine()
        ->getManager()
        ->getRepository('AssoSport\AccueilBundle\Entity\Activite')
      ;

      $repositoryProjet = $this
        ->getDoctrine()
        ->getManager()
        ->getRepository('AssoSportAccueilBundle:Projet')
      ;
      $projet = $repositoryProjet->findOneBy(array('nom' => 'Objectif Lune'));

      $listActivites = $repositoryActivites->findActivitesAdherentProjet(2,$projet);
    
      $content = $this->get('templating')->render('AssoSportAdminBundle:Infos:activitesprojetperso.html.twig', array(
        'activites' => $listActivites
      ));
      return new Response($content);
    }

    public function demandesAction(Request $request){
      $repository = $this
        ->getDoctrine()
        ->getManager()
        ->getRepository('AssoSportUserBundle:Utilisateur')
      ;
    
      $listeUtilisateurs = $repository->findDemandes();

      return $this->render('AssoSportAdminBundle:Infos:demandes.html.twig', array(
        'demandes' => $listeUtilisateurs
      ));

    }


}
