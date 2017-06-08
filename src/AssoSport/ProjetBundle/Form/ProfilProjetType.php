<?php

namespace AssoSport\ProjetBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class ProfilProjetType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('nomProfilProjet',        TextType::class)
        ->add('nomCategorie',       TextType::class)
        ->add('distance',       IntegerType::class)
        ->add('nbPlaces',       IntegerType::class)
        ->add('projetAssocie', EntityType::class, array(
              'class'           =>  'AssoSportAccueilBundle:Projet',
              'choice_label'    =>  'nom',
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
            'data_class' => 'AssoSport\ProjetBundle\Entity\ProfilProjet'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'assosport_projetbundle_profilprojet';
    }


}
