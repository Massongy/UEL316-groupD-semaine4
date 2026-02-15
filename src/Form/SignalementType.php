<?php

namespace App\Form;

use App\Entity\Signalement;
use App\Enum\MotifSignalement;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SignalementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('motif', EnumType::class, [
            'class' => MotifSignalement::class,
            'label' => false,
            'placeholder' => 'Choisir un motif',
        ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Signalement::class,
        ]);
    }
}
