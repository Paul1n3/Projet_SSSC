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
 
class ActiviteProjetType extends AbstractType
{
  public function buildForm(FormBuilderInterface $builder, array $options)
  {
    var_dump($options['sports']);
    $sports = $options['sports'];

    $builder
        ->remove('temps')
        ->remove('borg')
        ->remove('sensation')
        ->remove('utilisateur')
        ->remove('adherent')
        ->remove('projet')
        ->remove('sport')
        ->add('sport', EntityType::class, array(
              'class'           =>  'AssoSportAccueilBundle:Sport',
              'choice_label'    =>  'nom',
              'multiple'        =>   false,
              'choices'         => array(
                  'Mais voyons...',
                  'Mais pas du tout !',
              ),
              /*'query_builder'   => function ($repository) {
                  return $repository
                      ->createQueryBuilder('s')
                      ->innerJoin('MyBundleName:ChildOne', 'co', 'WITH', 'co.id = c.id')
                      ->orderBy('s.nom', 'ASC');
              },*/
            ))
        ;
  }
 
  public function getParent()
  {
    return ActiviteType::class;
  }
  
}