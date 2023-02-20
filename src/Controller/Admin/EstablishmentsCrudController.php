<?php

namespace App\Controller\Admin;

use App\Entity\Establishments;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CountryField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TelephoneField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class EstablishmentsCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Establishments::class;
    }

    public function configureFields(string $pageName): iterable
    {
        yield TextField::new('name');
        yield SlugField::new('slug')
            ->setTargetFieldName('name')
            ->onlyOnForms();
        yield EmailField::new('email');
        yield TextField::new('address');
        yield TextField::new('city');
        yield CountryField::new('country');
        yield TelephoneField::new('phone');
        yield DateField::new('creation_date')
            ->hideOnForm();
        yield DateField::new('update_date')
            ->hideOnForm();
        yield AssociationField::new('users');
    }
}
