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
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Form\DataTransformerInterface;

class ImageUploadType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class)
            ->add('description', TextType::class)
            ->add('image', FileType::class, [
                'constraints' => [
                    new File([
                        'maxSize' => '5M',
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/png',
                        ],
                        'mimeTypesMessage' => 'Veuillez télécharger une image au format JPG ou PNG.',
                    ]),
                ],
            ])
            ->add('likes', HiddenType::class)
            ->add('tags', TextType::class)
            ->add('slug', HiddenType::class)
            ->add('lists', HiddenType::class, [
                'required' => false,
                'mapped' => false,
            ])
            ->add('categories', EntityType::class, [
                'class' => Categories::class,
                'multiple' => true,
                'expanded' => true,
            ])
            ->add('creations', HiddenType::class, [
                'required' => false,
                'mapped' => false,
            ])
            ->add('favoris', HiddenType::class, [
                'required' => false,
                'mapped' => false,
            ])
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

            $uploadedFile = $form->get('image')->getData();
            $uploadDirectory = $form->getConfig()->getOption('upload_directory'); // Récupération de l'option personnalisée

            $filename = md5(uniqid()) . '.' . $uploadedFile->getClientOriginalExtension();

            $uploadedFile->move($uploadDirectory, $filename);

            $image->setImage($filename);

            $image->setSlug($slugify->slugify($image->getName()));
        });

        $builder->get('tags')->addModelTransformer(new class implements DataTransformerInterface {
            public function transform($value)
            {
                return implode(', ', $value);
            }
        
            public function reverseTransform($value)
            {
                return explode(', ', $value);
            }
        });
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Images::class,
            'upload_directory' => null,
        ]);
    }
}
