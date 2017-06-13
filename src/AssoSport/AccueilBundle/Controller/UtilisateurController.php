<?php

namespace AssoSport\AccueilBundle\Controller;

use AssoSport\UserBundle\Entity\Utilisateur;
use AssoSport\AccueilBundle\Entity\Projet;
use AssoSport\AccueilBundle\Entity\Sport;
use AssoSport\AccueilBundle\Entity\Profil;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AssoSport\AccueilBundle\Form\UtilisateurType;
use AssoSport\AccueilBundle\Form\UtilisateurProfilType;
use AssoSport\AccueilBundle\Form\SportType;
use FOS\UserBundle\Model\UserManager;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

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
  public function formulaireAction(Request $request)
  {
    $utilisateur = new Utilisateur();
    $form   = $this->get('form.factory')->create(UtilisateurType::class, $utilisateur);

    if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {

      $utilisateur->setUsername($utilisateur->getEmail());
      $utilisateur->setEnabled('true');
      $utilisateur->setDemande(1);

      $em = $this->getDoctrine()->getManager();
      $em->persist($utilisateur);
      $em->flush();

      $request->getSession()->getFlashBag()->add('notice', 'Utilisateur bien enregistré.');

      return $this->redirectToRoute('asso_sport_accueil_homepage');
    }

    return $this->render('AssoSportAccueilBundle:Utilisateur:formulaire.html.twig', array(
      'form' => $form->createView(),
    ));

  }

  public function inscriptionAction(Request $request)
  {
      $utilisateur = $this->getUser();

      $form   = $this->get('form.factory')->create(UtilisateurProfilType::class, $utilisateur);

      if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {

          $utilisateur->setDemande(1);
          $utilisateur->setParticipant(1);

          $em = $this->getDoctrine()->getManager();
          $em->persist($utilisateur);
          $em->flush();

          $request->getSession()->getFlashBag()->add('notice', 'Nouveau projet enregistré.');

          return $this->redirectToRoute('asso_sport_accueil_homepage');
      }

      return $this->render('AssoSportAccueilBundle:Utilisateur:profilInscription.html.twig', array(
          'form' => $form->createView(),
      ));
  }

}
