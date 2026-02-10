<?php

namespace App\Controller\Admin;

use App\Entity\Post;
use Dom\Text;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Filter\EntityFilter;

class PostCrudController extends AbstractCrudController
{
    public function __construct(private AdminUrlGenerator $adminUrlGenerator) {}

    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add(EntityFilter::new('user'));
    }

    public static function getEntityFqcn(): string
    {
        return Post::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('titre'),
            TextEditorField::new('contenu'),
            AssociationField::new('user')->onlyOnIndex(),
            IntegerField::new('commentsCount', 'Commentaires')
                ->formatValue(function ($value, $post) {
                    $url = $this->adminUrlGenerator
                        ->setController(\App\Controller\Admin\CommentCrudController::class)
                        ->setAction(Crud::PAGE_INDEX)
                        ->set('filters', [
                            'post' => [
                                'comparison' => '=',
                                'value' => $post->getId(),
                            ],
                        ])
                        ->generateUrl();

                    return sprintf('<a href="%s">%d commentaires</a>', $url, (int) $value);
                })
                ->onlyOnIndex(),
        ];
    }
}
