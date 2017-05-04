<?php
// src/Site/IndexBundle/Form/ProjetType.php
 
namespace AssoSport\AdherentBundle\Form;
 
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
 
class ProjetType extends AbstractType
{
  public function buildForm(FormBuilderInterface $builder, array $options)
  {
    $builder
			->add('id',		IntegerType::class)
		;
  }
 
  public function setDefaultOptions(OptionsResolverInterface $resolver)
  {
    $resolver->setDefaults(array(
      'data_class' => 'AssoSport\AccueilBundle\Entity\Projet'
    ));
  }
 
  public function getBlockPrefix()
  {
    return 'oc_platformbundle_adverttype';
  }
}