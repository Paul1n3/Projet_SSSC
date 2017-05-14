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

use Symfony\Component\Form\Forms;
use Symfony\Component\Form\Extension\HttpFoundation\HttpFoundationExtension;

class AdminController extends Controller
{
    public function homeAction(Request $request){
      $repository = $this
        ->getDoctrine()
        ->getManager()
        ->getRepository('AssoSportUserBundle:Utilisateur')
      ;
      $listeUtilisateurs = $repository->findDerniersSurSite();

      $repository = $this
        ->getDoctrine()
        ->getManager()
        ->getRepository('AssoSportAccueilBundle:Activite')
      ;
      $listeActivites = $repository->findDernieresSurSite();

      return $this->render('AssoSportAdminBundle:Default:index.html.twig',array(
        'utilisateurs' => $listeUtilisateurs, 'activites' =>$listeActivites
      ));
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
      $listeUtilisateurs = $repositoryUtilisateur->findUtilisateursProjet($projet);

      $logger = $this->get('logger');
      $logger->info(json_encode($listeUtilisateurs));

      return $this->render('AssoSportAdminBundle:Infos:listeprojet.html.twig', array(
        'users' => $listeUtilisateurs,
        'projet' => $projet)
      );
    }

    // Liste de toutes les activités rentrées sur le site
    public function activitesAction(Request $request)
    {
      $repositoryActivites = $this->getDoctrine()
        ->getManager()
        ->getRepository('AssoSport\AccueilBundle\Entity\Activite')
      ;
      $listActivites = $repositoryActivites->findAllActivites();

      $users = array();

      $content = $this->get('templating')->render('AssoSportAdminBundle:Infos:activites.html.twig', array(
        'activites' => $listActivites,
      ));
      return new Response($content);
    }

    /*public function activitespersoAction(Request $request)
    {
      $defaultData = array('message' => 'Type your message here');
      $form = $this->createFormBuilder($defaultData)
        ->add('Nom de l\'adhérent', TextType::class)

      $form->handleRequest($request);

      if ($form->isSubmitted() && $form->isValid()) {
        $nom = $request->request->get('Nom de l\'adhérent');

        $repositoryUser = $this
          ->getDoctrine()
          ->getManager()
          ->getRepository('AssoSportUserBundle:Utilisateur')
        ;
        $utilisateur = $repositoryUser->findOneBy(array('nom' => $nom));

        $repositoryActivites = $this->getDoctrine()
          ->getManager()
          ->getRepository('AssoSport\AccueilBundle\Entity\Activite')
        ;
        $listActivites = $repositoryActivites->findAllActivitesAdherent($utilisateur->getId());

        return $this->render('AssoSportAdminBundle:Infos:activitesperso.html.twig', array(
        'activites' => $listActivites
        ));
      }
      return $this->render('AssoSportAdminBundle:Default:form.html.twig', array(
          'form' => $form->createView(),
      ));
    }*/

    // Liste des activités de la personne sélectionnée dans la liste des membres adhérents de l'asso
    public function activitespersoAction($id)
    {
      $repositoryActivites = $this->getDoctrine()
        ->getManager()
        ->getRepository('AssoSport\AccueilBundle\Entity\Activite')
      ;
      $listActivites = $repositoryActivites->findAllActivitesAdherent($id);

      $repository = $this
        ->getDoctrine()
        ->getManager()
        ->getRepository('AssoSportUserBundle:Utilisateur')
      ;

      $utilisateur = $repository->findOneBy(array('id' => $id));

      $content = $this->get('templating')->render('AssoSportAdminBundle:Infos:activitesperso.html.twig', array(
        'activites' => $listActivites, 'utilisateur' => $utilisateur
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

    public function activitespersoprojetAction($id)
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

      $listActivites = $repositoryActivites->findActivitesAdherentProjet($id,$projet);

      $repository = $this
        ->getDoctrine()
        ->getManager()
        ->getRepository('AssoSportUserBundle:Utilisateur')
      ;

      $utilisateur = $repository->findOneBy(array('id' => $id));

      $content = $this->get('templating')->render('AssoSportAdminBundle:Infos:activitesprojetperso.html.twig', array(
        'activites' => $listActivites, 'utilisateur' => $utilisateur
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

    public function statProjetAction(Request $request){
      /*$repositoryProjet = $this
        ->getDoctrine()
        ->getManager()
        ->getRepository('AssoSportAccueilBundle:Projet')
      ;
      $projet = $repositoryProjet->findOneBy(array('nom' => 'Objectif Lune'));*/

      //Première catégorie
      $repositoryCategorieun = $this
        ->getDoctrine()
        ->getManager()
        ->getRepository('AssoSportProjetBundle:ProfilProjet')
      ;
      $categorie = $repositoryCategorieun->findOneBy(array('nomProfilProjet' => 'Le 1er quartier'));

      $repositoryuun = $this
        ->getDoctrine()
        ->getManager()
        ->getRepository('AssoSportUserBundle:Utilisateur')
      ;

      $listeUn = $repositoryuun->findUtilisateurProjetCategorie($categorie);

      $nbUtilisateursun = 0;
      foreach($listeUn as $utilisateur){
          $nbUtilisateursun += 1;
      }

      //Deuxième catégorie
      $repositoryCategoriede = $this
        ->getDoctrine()
        ->getManager()
        ->getRepository('AssoSportProjetBundle:ProfilProjet')
      ;
      $categoriede = $repositoryCategoriede->findOneBy(array('nomProfilProjet' => 'Le croissant'));

      $repositoryde = $this
        ->getDoctrine()
        ->getManager()
        ->getRepository('AssoSportUserBundle:Utilisateur')
      ;

      $listeUtilisateursde = $repositoryde->findUtilisateurProjetCategorie($categoriede);

      $nbUtilisateursde = 0;
        foreach($listeUtilisateursde as $utilisateur){
            $nbUtilisateursde += 1;
        }

      //Troisième catégorie
      $repositoryCategorietr = $this
        ->getDoctrine()
        ->getManager()
        ->getRepository('AssoSportProjetBundle:ProfilProjet')
      ;
      $categorietr = $repositoryCategorietr->findOneBy(array('nomProfilProjet' => 'La gibeuse'));

      $repositorytr = $this
        ->getDoctrine()
        ->getManager()
        ->getRepository('AssoSportUserBundle:Utilisateur')
      ;

      $listeUtilisateurstr = $repositorytr->findUtilisateurProjetCategorie($categorietr);

      $nbUtilisateurstr = 0;
        foreach($listeUtilisateurstr as $utilisateur){
            $nbUtilisateurstr += 1;
        }

      //Quatrième catégorie
      $repositoryCategorieca = $this
        ->getDoctrine()
        ->getManager()
        ->getRepository('AssoSportProjetBundle:ProfilProjet')
      ;
      $categorieca = $repositoryCategorieca->findOneBy(array('nomProfilProjet' => 'La pleine lune'));

      $repositoryca = $this
        ->getDoctrine()
        ->getManager()
        ->getRepository('AssoSportUserBundle:Utilisateur')
      ;

      $listeUtilisateursca = $repositoryca->findUtilisateurProjetCategorie($categorieca);

      $nbUtilisateursca = 0;
        foreach($listeUtilisateursca as $utilisateur){
            $nbUtilisateursca += 1;
        }

      return $this->render('AssoSportAdminBundle:Infos:statsProjet.html.twig', array(
        'nbUtilisateursUn' => $nbUtilisateursun, 'nbUtilisateursDeux' => $nbUtilisateursde, 'nbUtilisateursTrois' => $nbUtilisateurstr, 'nbUtilisateursQuatre' => $nbUtilisateursca,
      ));

    }

    public function statsAction($id)
    {
      // On récupère le repository Activite
      $repositoryActivites = $this->getDoctrine()
        ->getManager()
        ->getRepository('AssoSport\AccueilBundle\Entity\Activite')
      ;

      // Liste activité du mois
      $dateCeMois = date('M');
      $tempsMois = 0; $sensation = 0; $moyenneSensation = 0;
      $listActivitesMois = $repositoryActivites->findActivitesTempsAdherent($id,new \DateTime('first day of this month'), new \DateTime('now'));
      foreach($listActivitesMois as $activite){
        $tempsMois += $activite->getTemps();
        $sensation += $activite->getSensation();
      }
      if(count($listActivitesMois) != 0){
        $moyenneSensation = $sensation/count($listActivitesMois);
      }

      // Mois -1
      $dateMois1 = date('M',strtotime('-1 month'));
      $listActivitesMois1 = $repositoryActivites->findActivitesTempsAdherent($id,new \DateTime('first day of last month'), new \DateTime('first day of this month'));
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
      $listActivitesMois2 = $repositoryActivites->findActivitesTempsAdherent($id, new \DateTime('last day of 3 months ago'), new \DateTime('last day of 2 months ago'));
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
      $listActivitesMois3 = $repositoryActivites->findActivitesTempsAdherent($id, new \DateTime('last day of 4 months ago'), new \DateTime('last day of 3 months ago'));
      $tempsMois3 = 0; $sensation3 = 0; $moyenneSensation3 = 0;
      foreach($listActivitesMois3 as $activite){
        $tempsMois3 += $activite->getTemps();
        $sensation3 += $activite->getSensation();
      }
      if(count($listActivitesMois3) != 0){
        $moyenneSensation3 = $sensation3/count($listActivitesMois3);
      }

      $repository = $this
        ->getDoctrine()
        ->getManager()
        ->getRepository('AssoSportUserBundle:Utilisateur')
      ;

      $utilisateur = $repository->findOneBy(array('id' => $id));

      $content = $this->get('templating')->render('AssoSportAdminBundle:Infos:stats.html.twig', array(
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



}
