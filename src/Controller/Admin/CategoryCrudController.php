<?php

namespace App\Controller\Admin;

use App\Entity\Category;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Filter\EntityFilter;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Form\Type\FileUploadType;
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
        yield TextField::new('subtitle');
        yield SlugField::new('slug')->hideOnIndex()->setTargetFieldName('title');
        yield BooleanField::new('isFullWidth');
        yield BooleanField::new('isHidden');

        //yield AssociationField::new('parent');
        //yield AssociationField::new('children');

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
        yield ImageField::new('image')
            ->setBasePath('uploads/files/')
            ->setUploadDir('public_html/uploads/files')
            ->setFormType(FileUploadType::class)
            ->setRequired(false);
        //yield AssociationField::new('items')->hideOnIndex();


        yield TextField::new('lat')->setColumns('col-md-2')->hideOnIndex();
        yield TextField::new('lng')->setColumns('col-md-2')->hideOnIndex();
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
