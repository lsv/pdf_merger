<?php

namespace App\Form;

use App\Model\FileModel;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType as CoreFileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('uploadedFile', CoreFileType::class, [
                'label' => 'Choose file...',
                'required' => true,
                'attr' => [
                    'class' => 'file-upload',
                    'accept' => 'application/pdf,application/x-pdf',
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => FileModel::class,
        ]);
    }
}
