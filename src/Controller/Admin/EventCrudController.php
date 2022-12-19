<?php

namespace App\Controller\Admin;

use App\Entity\Event;
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
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Form\Type\FileUploadType;
use FOS\CKEditorBundle\Form\Type\CKEditorType;

class EventCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Event::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Event')
            ->setEntityLabelInPlural('Event')
            ->setSearchFields(['title', 'description', 'note'])
            ->setDefaultSort(['id' => 'DESC'])
            ->addFormTheme('@FOSCKEditor/Form/ckeditor_widget.html.twig');
    }

    public function configureFields(string $pageName): iterable
    {
        yield FormField::addPanel('Main info')->setIcon('fa fa-info')->setCssClass('col-sm-6');
        yield IntegerField::new('id')->setFormTypeOption('disabled', 'disabled')->hideWhenCreating();
        yield SlugField::new('slug')->hideOnIndex()->setTargetFieldName('title');
        yield BooleanField::new('hidden');
        yield BooleanField::new('isFree')->hideOnIndex();
        yield TextField::new('title')->setColumns('col-md-10');
        yield TextField::new('subtitle')->setColumns('col-md-10')->hideOnIndex();
        yield TextField::new('timetable')->setColumns('col-md-10')->hideOnIndex();

        yield FormField::addPanel('General information')->setIcon('fa fa-info-circle')->setCssClass('col-sm-6');
        yield AssociationField::new('location')->setColumns('col-md-12')->hideOnIndex();
        yield AssociationField::new('tags')->setColumns('col-md-12')->hideOnIndex();
        yield ImageField::new('image')
            ->setBasePath('uploads/files/')
            ->setUploadDir('public_html/uploads/files')
            ->setFormType(FileUploadType::class)
            ->setRequired(false);

        yield TextField::new('link')->setColumns('col-md-10')->hideOnIndex();
        yield TextField::new('address')->setColumns('col-md-10')->hideOnIndex();

        yield MoneyField::new('price')->setCurrency('RUB')
            ->setCustomOption('storedAsCents', false)->setColumns('col-md-10')->hideOnIndex();
        yield DateField::new('date')->setColumns('col-md-10');

        yield FormField::addPanel('Additional info')->setIcon('fa fa-gear')->setCssClass('col-sm-12');
        yield FormField::addRow();
        yield TextEditorField::new('description')->setFormType(CKEditorType::class)->hideOnIndex()->setColumns('col-md-12');
        yield TextEditorField::new('note')->setFormType(CKEditorType::class)->hideOnIndex()->setColumns('col-md-12');
        yield TextEditorField::new('menu')->setFormType(CKEditorType::class)->hideOnIndex()->setColumns('col-md-12');
    }
}
