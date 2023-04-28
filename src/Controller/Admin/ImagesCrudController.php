<?php

namespace App\Controller\Admin;

use App\Entity\Images;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ImagesCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Images::class;
    }

    public function configureFields(string $pageName): iterable
    {
        yield TextField::new('name');
        yield SlugField::new('slug')
            ->setTargetFieldName('name')
            ->onlyOnForms();
        yield TextEditorField::new('description');
        yield ImageField::new('image')
            ->setUploadDir('/public/upload/img/')
            ->setBasePath('upload/img/');
        yield IntegerField::new('like')
            ->hideOnForm();
        yield CollectionField::new('tags');
        yield DateField::new('creation_date')
            ->hideOnForm();
        yield DateField::new('update_date')
            ->hideOnForm();
        yield AssociationField::new('categories');
        yield AssociationField::new('creations', 'créateurs');
    }
}
