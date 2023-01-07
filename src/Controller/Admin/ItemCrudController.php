<?php

namespace App\Controller\Admin;

use App\Entity\Item;
use App\Form\Crud\AttachmentType;
use App\Form\Crud\ImageFormType;
use App\Form\Crud\TagFormType;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Form\Type\FileUploadType;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Assets;

class ItemCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Item::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Item')
            ->setEntityLabelInPlural('Item')
            ->setSearchFields(['title', 'alias', 'email'])
            ->setDefaultSort(['id' => 'DESC'])
            ->addFormTheme('@FOSCKEditor/Form/ckeditor_widget.html.twig');
    }

    public function configureAssets(Assets $assets): Assets
    {
        return $assets
            ->addCssFile('assets/css/easy_admin_custom.css');
    }


    public function configureFields(string $pageName): iterable
    {
        yield FormField::addPanel('Main info')->setIcon('fa fa-info')->setCssClass('col-sm-6');
        yield IntegerField::new('id')->setFormTypeOption('disabled', 'disabled')->hideWhenCreating();
        yield SlugField::new('slug')->hideOnIndex()->setTargetFieldName('title');
        yield BooleanField::new('hidden');
        yield BooleanField::new('isSelected')->hideOnIndex();
        yield TextField::new('title')->setColumns('col-md-10');
        yield TextField::new('subtitle')->setColumns('col-md-10')->hideOnIndex();
        yield TextField::new('timetable')->setColumns('col-md-10')->hideOnIndex();
        yield MoneyField::new('averageCheck')->setCurrency('RUB')
            ->setCustomOption('storedAsCents', false)->setColumns('col-md-10')->hideOnIndex();

        //yield TextField::new('alias')->setColumns('col-md-10');

        yield FormField::addPanel('General information')->setIcon('fa fa-info-circle')->setCssClass('col-sm-6');
        yield TextField::new('email')->setColumns('col-md-10')->hideOnIndex();
        yield TextField::new('address')->setColumns('col-md-10')->hideOnIndex();
        yield TextField::new('phone')->setColumns('col-md-10')->hideOnIndex();
        yield TextField::new('phone2')->setColumns('col-md-10')->hideOnIndex();
        yield TextField::new('phone3')->setColumns('col-md-10')->hideOnIndex();
        yield TextField::new('site')->setColumns('col-md-10')->hideOnIndex();

        yield TextField::new('lat')->setColumns('col-md-10')->hideOnIndex();
        yield TextField::new('lng')->setColumns('col-md-10')->hideOnIndex();

        yield FormField::addPanel('Relations')->setIcon('fa fa-chain')->setCssClass('col-sm-6');
        yield FormField::addRow();
        yield AssociationField::new('category')->setColumns('col-md-10')->hideOnIndex();
        yield AssociationField::new('location')->setColumns('col-md-10')->hideOnIndex();
        //yield AssociationField::new('tags')->setColumns('col-md-12')->hideOnIndex();
        yield CollectionField::new('tags')->setFormTypeOption('entry_type', TagFormType::class)->hideOnIndex();

        yield FormField::addPanel('Images')->setIcon('fa fa-image')->setCssClass('col-sm-6');
        yield FormField::addRow();

        yield ImageField::new('image')
            ->setBasePath('uploads/files/')
            ->setUploadDir('public_html/uploads/files')
            ->setFormType(FileUploadType::class)
            ->setRequired(false)
            ->setLabel('Cover image');

        yield CollectionField::new('attachments')
            ->setEntryType(AttachmentType::class)
            ->setTemplatePath('bundles/EasyAdminBundle/crud/form_theme.html.twig')
            ->setFormTypeOption('by_reference', false)
            ->onlyOnForms();

        yield CollectionField::new('attachments')
            ->setTemplatePath('bundles/EasyAdminBundle/crud/images.html.twig')
            ->onlyOnDetail();

        yield FormField::addPanel('Additional info')->setIcon('fa fa-gear')->setCssClass('col-sm-12');
        yield FormField::addRow();
        //yield TextareaField::new('teaser')->setColumns('col-md-12')->hideOnIndex();
        yield TextEditorField::new('description')->setFormType(CKEditorType::class)->hideOnIndex()->setColumns('col-md-12');
        yield TextEditorField::new('note')->setFormType(CKEditorType::class)->hideOnIndex()->setColumns('col-md-12');
    }

    public function configureActions(Actions $actions): Actions
    {
        //return parent::configureActions($actions); // TODO: Change the autogenerated stub
        return $actions->add(CRUD::PAGE_INDEX, 'detail');
    }
}
