<?php
// src/Site/IndexBundle/Form/ActiviteType.php
 
namespace AssoSport\AdherentBundle\Form;
 
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
 
class ActiviteType extends AbstractType
{
  public function buildForm(FormBuilderInterface $builder, array $options)
  {
    $builder
			->add('date',		DateType::class)
			->add('temps',		IntegerType::class)
			->add('borg',		IntegerType::class)
			->add('sensation',	IntegerType::class)
			->add('distanceKm',	IntegerType::class)
      ->add('sport', EntityType::class, array(
              'class'           =>  'AssoSportAccueilBundle:Sport',
              'choice_label'    =>  'nom',
              'multiple'        =>   false,
            ))
		->add('save',      SubmitType::class)
    ;
  }
 
  public function setDefaultOptions(OptionsResolverInterface $resolver)
  {
    $resolver->setDefaults(array(
      'data_class' => 'AssoSport\AccueilBundle\Entity\Activite'
    ));
  }
 
  public function getBlockPrefix()
  {
    return 'oc_platformbundle_adverttype';
  }
}