<?php

namespace App\Controller\Admin;

use App\Entity\Establishments;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class EstablishmentsCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Establishments::class;
    }

    /*
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('title'),
            TextEditorField::new('description'),
        ];
    }
    */
}
