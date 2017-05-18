<?php

namespace AssoSport\AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class DemandesType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        // $roles = $this->getParent('security.role_hierarchy.roles');
        $builder
        ->add('roles', ChoiceType::class, array(
    'attr'  =>  array('class' => 'form-control',
    'style' => 'margin:5px 0;'),
    'choices' =>
    array
    (
        'ROLE_ADHERENT_ASSO' => array
        (
            'Yes' => 'ROLE_ADHERENT_ASSO'
        ),
        'ROLE_ADHERENT_PROJET' => array
        (
            'Yes' => 'ROLE_ADHERENT_PROJET'
        ),
        'ROLE_ADHERENT_COMPLET' => array
        (
            'Yes' => 'ROLE_ADHERENT_COMPLET'
        ),
    )
    ,
    'multiple' => true,
    'required' => true,
    )
)
        ->add('save', 'submit', ['label' => 'ui.button.save']);
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

    // /**
    //  * {@inheritdoc}
    //  */
    // public function getBlockPrefix()
    // {
    //     return 'assosport_accueilbundle_profil';
    // }


}
