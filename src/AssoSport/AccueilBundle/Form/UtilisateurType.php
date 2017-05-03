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
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

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
          ->add('taille',    NumberType::class)
          ->add('age',       NumberType::class)
          ->add('poids',     NumberType::class)
          ->add('sexe',      ChoiceType::class, array('choices' => array('Masculin' => 'M', 'Feminin' => 'F')))
          ->add('adresseMail', EmailType::class)
          ->add('motDePasse',  PasswordType::class)
          ->add('adherent',  CheckboxType::class, array('required' => false))
          ->add('profilActuel', ProfilType::class)
          ->add('sports', CollectionType::class, array(
                'entry_type'   => SportType::class,
                'allow_add'    => false,
                'allow_delete' => false
            ))
            //CheckboxType::class, array(aller chercher tous les sports)
          ->add('projets',        CheckboxType::class, array('required' => false))
          ->add('save',      SubmitType::class)
        ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AssoSport\AccueilBundle\Entity\Utilisateur'
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
