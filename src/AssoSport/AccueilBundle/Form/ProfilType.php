<?php

namespace AssoSport\AccueilBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;

class ProfilType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('nom', ChoiceType::class, array('choices' => array('Sedentaire: 60 minutes de sport maximum par semaine' => 'Sedentaire','Moyennement actif: entre 60 et 90 minutes de sport par semaine' => 'Moyennement Actif', 'Actif: entre 90 et 120 minutes de sport par  semaine' => 'Actif', 'Très actif: Plus de 120 minutes de sport par semaine' => 'Tres Actif')));
        
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AssoSport\AccueilBundle\Entity\Profil'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'assosport_accueilbundle_profil';
    }


}
