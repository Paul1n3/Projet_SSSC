<?php

namespace AssoSport\AccueilBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use AssoSport\AccueilBundle\Entity\Profil;

use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class UtilisateurType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
          ->add('nom',       TextType::class)
          ->add('prenom',    TextType::class)
          ->add('taille',    IntegerType::class)
          ->add('dateNaissance', DateType::class, array(
            'years' => range(1920, date('Y'))))
          ->add('poids',     IntegerType::class)
          ->add('sexe',      ChoiceType::class, array('choices' => array('Masculin' => 'M', 'Feminin' => 'F')))
          ->add('email',    EmailType::class)
          ->add('plainPassword', RepeatedType::class, array(
            'type' => PasswordType::class,
            'invalid_message' => 'The password fields must match.',
            'options' => array('attr' => array('class' => 'password-field')),
            'required' => true,
            'first_options'  => array('label' => 'Password'),
            'second_options' => array('label' => 'RepeatPassword'),
          ))
          ->add('adherent',  CheckboxType::class, array('required' => false))
          ->add('participant',  CheckboxType::class, array('required' => false))
          //->add('profilActuel', ProfilType::class)
          ->add('profilActuel', EntityType::class, array(
              'class'           =>  'AssoSportAccueilBundle:Profil',
              'choice_label'    =>  'nom',
              'multiple'        =>   false,
            ))
          ->add('sports', EntityType::class, array(
              'class'           =>  'AssoSportAccueilBundle:Sport',
              'choice_label'    =>  'nom',
              'multiple'        =>   true,
              'required'   => false,
            ))
          ->add('projets', EntityType::class, array(
              'class'           =>  'AssoSportAccueilBundle:Projet',
              'choice_label'    =>  'nom',
              'multiple'        =>   true,
              'required'        => false,
            ))
          ->add('profilProjet', EntityType::class, array(
              'class'           =>  'AssoSportProjetBundle:ProfilProjet',
              'choice_label'    =>  'nomProfilProjet',
              'multiple'        =>   false,
            ))
          ->add('save',      SubmitType::class)
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AssoSport\UserBundle\Entity\Utilisateur'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'assosport_accueilbundle_utilisateur';
    }
}
