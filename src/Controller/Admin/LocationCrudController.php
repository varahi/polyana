<?php

namespace App\Controller\Admin;

use App\Entity\Location;
use App\Form\Crud\ChildrenLocationFormType;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Filter\EntityFilter;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;

class LocationCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Location::class;
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
            ->setEntityLabelInSingular('Location')
            ->setEntityLabelInPlural('Location')
            ->setSearchFields(['id', 'title'])
            ->setDefaultSort(['id' => 'ASC']);
    }

    public function _configureFields(string $pageName): iterable
    {
        yield IntegerField::new('id')->setFormTypeOption('disabled', 'disabled');
        //yield TextField::new('slug');
        yield SlugField::new('slug')->setTargetFieldName('title');
        yield TextField::new('title');

        yield AssociationField::new('parent');
//        yield AssociationField::new('parent')
//            ->setFormTypeOptions([
//                'by_reference' => false,
//            ]);

        //yield AssociationField::new('children');
        //yield CollectionField::new('children');
//        yield AssociationField::new('children')
//            ->setFormTypeOptions([
//                'by_reference' => false,
//            ]);

        yield TextEditorField::new('description')->hideOnIndex();
        //yield AssociationField::new('items')->hideOnIndex();
        yield BooleanField::new('isHidden');
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IntegerField::new('id')->setFormTypeOption('disabled', 'disabled'),
            SlugField::new('slug')->setTargetFieldName('title'),
            BooleanField::new('isHidden'),
            TextField::new('title'),
            AssociationField::new('parent'),
            //CollectionField::new('children')->setFormTypeOption('entry_type', ChildrenLocationFormType::class)
        ];
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
