<?php

namespace AssoSport\AccueilBundle\Controller;

use AssoSport\AccueilBundle\Entity\Utilisateur;
use AssoSport\AccueilBundle\Entity\Profil;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AssoSport\AccueilBundle\Form\UtilisateurType;

use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class UtilisateurController extends Controller
{
  public function printAction(Request $request)
  {
    // Création de l'entité
    $utilisateur = new Utilisateur();
    $utilisateur->setNom('Canila');
    $utilisateur->setPrenom('Damien');
    $utilisateur->setTaille(182);
    $utilisateur->setAge(61);
    $utilisateur->setPoids(90);
    $utilisateur->setSexe('M');
    $utilisateur->setAdresseMail('damien@ici.fr');
    $utilisateur->setMotDePasse('damienCanila');
    $utilisateur->setSalt('damien');
    $utilisateur->setAdherent('true');

    $repository = $this
      ->getDoctrine()
      ->getManager()
      ->getRepository('AssoSportAccueilBundle:Profil')
    ;
    $profil = $repository->findOneByNom('Moyennement Actif');

    $utilisateur->setProfilActuel($profil);


    // On récupère l'EntityManager
    $em = $this->getDoctrine()->getManager();

    // Étape 1 : On « persiste » l'entité
    $em->persist($utilisateur);

    // Étape 2 : On « flush » tout ce qui a été persisté avant
    $em->flush();

    // Reste de la méthode qu'on avait déjà écrit
    /*if ($request->isMethod('POST')) {
      $request->getSession()->getFlashBag()->add('notice', 'Annonce bien enregistrée.');

      // Puis on redirige vers la page de visualisation de cettte annonce
      return $this->redirectToRoute('oc_platform_view', array('id' => $adherent->getId()));
    }*/

    // Si on n'est pas en POST, alors on affiche le formulaire
    return $this->render('AssoSportAccueilBundle:Utilisateur:print.html.twig', array('utilisateur' => $utilisateur));
  }

  public function listeAction()
  {
    $repository = $this
      ->getDoctrine()
      ->getManager()
      ->getRepository('AssoSportAccueilBundle:Utilisateur')
    ;
    
    $listeUtilisateurs = $repository->myFindAll();

    return $this->render('AssoSportAccueilBundle:Utilisateur:liste.html.twig', array('utilisateurs' => $listeUtilisateurs));
  }

  public function trouveAction()
  {
    $repository = $this
      ->getDoctrine()
      ->getManager()
      ->getRepository('AssoSportAccueilBundle:Utilisateur')
    ;
    
    $utilisateur = $repository->myFindOne();

    return $this->render('AssoSportAccueilBundle:Utilisateur:trouve.html.twig', array('utilisateur' => $utilisateur));
  }
  
  public function formulaireAction(Request $request)
  {
    /*// Création de l'objet utilisateur
    $utilisateur = new Utilisateur();

    // Création du FormBuilder (form factory)
    $formBuilder = $this->get('form.factory')->createBuilder(FormType::class, $utilisateur);*/

    /*// Ajout des champs pour le formulaire
    $formBuilder
      ->add('nom',       TextType::class)
      ->add('prenom',    TextType::class)
      ->add('taille',    NumberType::class)
      ->add('age',       NumberType::class)
      ->add('poids',     NumberType::class)
      ->add('sexe',      ChoiceType::class, array('choices' => array('Masculin' => 'M', 'Feminin' => 'F')))
      ->add('adresseMail', EmailType::class)
      ->add('motDePasse',  PasswordType::class)
      ->add('salt',      TextType::class)
      ->add('profilActuel', ChoiceType::class, array('choices' => array('Sedentaire: 60 minutes de sport maximum par semaine' => $repository->findOneByNom('Sedentaire'),'Moyennement actif: entre 60 et 90 minutes de sport par semaine' => $repository->findOneByNom('Moyennement Actif'), 'Actif: entre 90 et 120 minutes de sport par  semaine' => $repository->findOneByNom('Actif'), 'Très actif: Plus de 120 minutes de sport par semaine' => $repository->findOneByNom('Tres Actif'))))
      ->add('adherent',  CheckboxType::class, array('required' => false))
      ->add('save',      SubmitType::class)
    ;
    
    // Génération du formulaire à partir du formBuilder
    $form = $formBuilder->getForm();*/

    /*// Génération automatique de la vue
    return $this->render('AssoSportAccueilBundle:Utilisateur:formulaire.html.twig', array(
      'form' => $form->createView(),
    ));*/

    // Si la requête est en POST
    /*if ($request->isMethod('POST')) {
      // On fait le lien Requête <-> Formulaire
      // À partir de maintenant, la variable $utilisation contient les valeurs entrées dans le formulaire par le visiteur
      $form->handleRequest($request);

      // On vérifie que les valeurs entrées sont correctes
      // (Nous verrons la validation des objets en détail dans le prochain chapitre)
      if ($form->isValid()) {
        // On enregistre notre objet $utilisation dans la base de données, par exemple
        $em = $this->getDoctrine()->getManager();
        $em->persist($utilisateur);
        $em->flush();

        $request->getSession()->getFlashBag()->add('notice', 'Nouvel utilisateur enregistré.');

        // On redirige vers la page de visualisation de l'annonce nouvellement créée
        return $this->redirectToRoute('asso_sport_accueil_liste');
      }
    }

    // À ce stade, le formulaire n'est pas valide car :
    // - Soit la requête est de type GET, donc le visiteur vient d'arriver sur la page et veut voir le formulaire
    // - Soit la requête est de type POST, mais le formulaire contient des valeurs invalides, donc on l'affiche de nouveau
    return $this->render('AssoSportAccueilBundle:Utilisateur:formulaire.html.twig', array(
      'form' => $form->createView(),
    ));*/

    $utilisateur = new Utilisateur();
    $form   = $this->get('form.factory')->create(UtilisateurType::class, $utilisateur);

    if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
      $em = $this->getDoctrine()->getManager();
      $em->persist($utilisateur);
      $em->persist($utilisateur->getProfil());
      $em->flush();

      $request->getSession()->getFlashBag()->add('notice', 'Annonce bien enregistrée.');

      return $this->redirectToRoute('asso_sport_accueil_liste');
    }

    return $this->render('AssoSportAccueilBundle:Utilisateur:formulaire.html.twig', array(
      'form' => $form->createView(),
    ));
    
  }

}
