<?php

namespace App\Controller\Admin;

use App\Entity\Users;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CountryField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TelephoneField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UsersCrudController extends AbstractCrudController
{
    public function __construct(
        private UserPasswordHasherInterface $passwordHasher
    ) {  
    }

    public static function getEntityFqcn(): string
    {
        return Users::class;
    }

    public function configureFields(string $pageName): iterable
    {
        yield TextField::new('first_name');
        yield TextField::new('last_name');
        yield SlugField::new('slug')
            ->setTargetFieldName('last_name')
            ->onlyOnForms();
        yield EmailField::new('email');
        yield TextField::new('password')
            ->setFormType(PasswordType::class)
            ->onlyOnForms();
        yield ChoiceField::new('roles')
            ->allowMultipleChoices()
            ->renderAsBadges([
                'ROLE_SUPER_ADMIN' => 'danger',
                'ROLE_ADMIN' => 'warning',
                'ROLE_TATTLER' => 'info',
                'ROLE_USER' => 'success'
            ])
            ->setChoices([
                'Super Admin' => 'ROLE_SUPER_ADMIN',
                'Gérant' => 'ROLE_ADMIN',
                'Tattoueur' => 'ROLE_TATTLER',
                'Utilisateur' => 'ROLE_USER'
            ]);
        yield TextField::new('address');
        yield TextField::new('city');
        yield CountryField::new('country');
        yield TelephoneField::new('phone');
        yield DateField::new('creation_date')
            ->hideOnForm();
        yield DateField::new('update_date')
            ->hideOnForm();
        yield AssociationField::new('favoris')
            ->hideOnForm();
    }

    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        /** @var User $user */
        $user = $entityInstance;

        $plainPassword = $user->getPassword();
        $hashedPassword = $this->passwordHasher->hashPassword($user, $plainPassword);

        $user->setPassword($hashedPassword);

        parent::persistEntity($entityManager, $entityInstance);
    }
}
