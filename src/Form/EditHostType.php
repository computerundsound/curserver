<?php
declare(strict_types=1);

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EditHostType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {

        $builder
            ->add('id', HiddenType::class)
            ->add('domain', TextType::class)
            ->add('subdomain', TextType::class)
            ->add('tld', TextType::class)
            ->add('directory', TextType::class)
            ->add('document_root', TextType::class)
            ->add('comment', TextareaType::class)
            ->add('ip', TextType::class);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {

        $resolver->setDefaults([
                                   // Configure your form options here
                               ]);
    }
}
