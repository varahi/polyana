<?php

namespace App\Controller\Admin;

use App\Entity\Item;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;

use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TelephoneField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Filter\EntityFilter;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AvatarField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use Doctrine\ORM\EntityRepository;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\SearchDto;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FieldCollection;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FilterCollection;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Form\Type\FileUploadType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use FOS\CKEditorBundle\Form\Type\CKEditorType;

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

    public function configureFields(string $pageName): iterable
    {
        yield FormField::addPanel('Main info')->setIcon('fa fa-info')->setCssClass('col-sm-6');
        yield IntegerField::new('id')->setFormTypeOption('disabled', 'disabled')->hideWhenCreating();
        yield SlugField::new('slug')->hideOnIndex()->setTargetFieldName('title')->hideOnIndex();
        yield BooleanField::new('hidden');
        yield TextField::new('title')->setColumns('col-md-10');
        yield TextField::new('subtitle')->setColumns('col-md-10')->hideOnIndex();
        yield TextareaField::new('teaser')->setColumns('col-md-10')->hideOnIndex();

        //yield TextField::new('alias')->setColumns('col-md-10');

        yield FormField::addPanel('General information')->setIcon('fa fa-info-circle')->setCssClass('col-sm-6');
        yield TextField::new('email')->setColumns('col-md-10')->hideOnIndex();
        yield TextField::new('address')->setColumns('col-md-10')->hideOnIndex();
        yield TextField::new('phone')->setColumns('col-md-10')->hideOnIndex();
        yield TextField::new('phone2')->setColumns('col-md-10')->hideOnIndex();
        yield TextField::new('phone3')->setColumns('col-md-10')->hideOnIndex();
        yield TextField::new('site')->setColumns('col-md-10')->hideOnIndex();

        yield FormField::addPanel('Additional info')->setIcon('fa fa-gear')->setCssClass('col-sm-8');
        yield FormField::addRow();
        yield TextEditorField::new('description')->setFormType(CKEditorType::class)->hideOnIndex()->setColumns('col-md-12');


        yield FormField::addPanel('Relations')->setIcon('fa fa-chain')->setCssClass('col-sm-4');
        yield FormField::addRow();
        yield AssociationField::new('category')->hideOnIndex()->setColumns('col-md-12');
        yield AssociationField::new('location')->hideOnIndex()->setColumns('col-md-12');
        yield ImageField::new('image')
            ->setBasePath('uploads/files/')
            ->setUploadDir('public_html/uploads/files')
            ->setFormType(FileUploadType::class)
            ->setRequired(false);

        //yield FormField::addPanel('Relations')->setIcon('fa fa-chain')->setCssClass('col-sm-12');
        //yield FormField::addRow();
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
