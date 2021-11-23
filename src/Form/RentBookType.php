<?php

namespace App\Form;

use App\Entity\RentBook;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\DateTime;

class RentBookType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('rent_date', DateType::class,[
                'widget' => 'single_text',
                'data' => new \DateTime(),
                'disabled' => true
            ])
            ->add('return_date',DateType::class,[
                'widget' => 'single_text',
                'data' => new \DateTime()
            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => RentBook::class,
        ]);
    }
}
