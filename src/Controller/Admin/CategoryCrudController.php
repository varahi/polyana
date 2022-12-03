<?php

namespace App\Controller\Admin;

use App\Entity\Category;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Filter\EntityFilter;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use function Symfony\Component\Translation\t;

class CategoryCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Category::class;
    }

    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add(EntityFilter::new('item'))
            ;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Categories')
            ->setEntityLabelInPlural('Categories')
            ->setSearchFields(['id', 'title', 'description'])
            ->setDefaultSort(['id' => 'ASC']);
    }

    public function configureFields(string $pageName): iterable
    {
        yield IntegerField::new('id')->setFormTypeOption('disabled', 'disabled');
        yield TextField::new('title');
        //yield TextField::new('slug');
        //yield SlugField::new('slug')->hideOnIndex()->setTargetFieldName('title');

        yield AssociationField::new('parent');
        yield AssociationField::new('children');

        /*        yield AssociationField::new('parent')
                    ->setFormTypeOptions([
                        'by_reference' => false,
                ]);*/

        //yield CollectionField::new('children')->useEntryCrudForm(CategoryCrudController::class);
        /*        yield AssociationField::new('children')
                    ->setFormTypeOptions([
                        'by_reference' => false,
                ]);*/

        yield TextEditorField::new('description')->hideOnIndex();
        yield AssociationField::new('items')->hideOnIndex();
        yield BooleanField::new('isHidden');
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
