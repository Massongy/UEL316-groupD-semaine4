<?php

namespace App\Controller\Admin;

use App\Entity\Signalement;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use App\Enum\MotifSignalement;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;

class SignalementCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Signalement::class;
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->disable(Action::NEW)
            ->disable(Action::EDIT)
            ->add(Crud::PAGE_INDEX, Action::DETAIL);
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->onlyOnIndex(),
            AssociationField::new('comment', 'Commentaire signalé'),
            ChoiceField::new('motif')
                ->setFormType(EnumType::class)
                ->setFormTypeOptions(['class' => MotifSignalement::class]),
        ];
    }
}
