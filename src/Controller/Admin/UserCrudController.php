<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Enum\Role;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;

class UserCrudController extends AbstractCrudController
{
    public function __construct(
        private UserPasswordHasherInterface $passwordHasher
    ) {}

    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        if (!$entityInstance instanceof \App\Entity\User) {
            return;
        }

        $this->hashPasswordIfProvided($entityInstance);

        parent::persistEntity($entityManager, $entityInstance);
    }

    public function updateEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        if (!$entityInstance instanceof \App\Entity\User) {
            return;
        }

        $this->hashPasswordIfProvided($entityInstance);

        parent::updateEntity($entityManager, $entityInstance);
    }

    private function hashPasswordIfProvided(\App\Entity\User $user): void
    {
        $password = $user->getPassword();

        if ($password === null || $password === '') {
            return;
        }

        $user->setPassword(
            $this->passwordHasher->hashPassword($user, $password)
        );
    }

    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('nom'),
            TextField::new('prenom'),
            EmailField::new('email'),
            ChoiceField::new('roles')
                ->setChoices([
                    'Utilisateur' => Role::MEMBRE->value,
                    'Admin' => Role::ADMIN->value,
                ])
                ->allowMultipleChoices()
                ->renderExpanded(false),
            Field::new('password')
                ->setFormType(PasswordType::class)
                ->setFormTypeOptions([
                    'required' => $pageName === Crud::PAGE_NEW,
                    'empty_data' => '',
                ])
                ->onlyOnForms(),
            Field::new('createdAt')->hideOnForm(),
            Field::new('updatedAt')->hideOnForm(),
            Field::new('actif')->onlyOnIndex(),
        ];
    }
}
