<?php

namespace App\Form;

use App\Entity\Categories;
use App\Entity\Images;
use Cocur\Slugify\Slugify;
use DateTimeImmutable;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ImageUploadType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class)
            ->add('description', TextType::class)
            ->add('image', FileType::class)
            ->add('likes', HiddenType::class)
            ->add('tags', TextType::class)
            ->add('slug', HiddenType::class)
            ->add('lists', HiddenType::class)
            ->add('categories', EntityType::class, [
                'class' => Categories::class,
                'multiple' => true,
                'expanded' => true,
            ])
            ->add('creations', HiddenType::class)
            ->add('favoris', HiddenType::class)
        ;

        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
            $image = $event->getData();
            if (!$image || !$image->getId()) {
                $image->setCreationDate(new DateTimeImmutable());
                $image->setUpdateDate(new DateTimeImmutable());
            }
        });

        $builder->addEventListener(FormEvents::POST_SUBMIT, function (FormEvent $event) {
            $image = $event->getData();
            $form = $event->getForm();
            $slugify = new Slugify();

            $image->setSlug($slugify->slugify($image->getName()));
        });
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Images::class,
        ]);
    }
}
