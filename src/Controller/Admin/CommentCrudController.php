<?php

namespace App\Controller\Admin;

use App\Entity\Comment;
use App\Entity\Enum\CommentStateEnum;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use Symfony\Component\Validator\Constraints\Choice;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Filter\EntityFilter;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class CommentCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Comment::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Conference Comment')
            ->setEntityLabelInPlural('Conference Comments')
            ->setSearchFields(['author', 'text', 'email'])
            ->setDefaultSort(['createdAt' => 'DESC']);
    }

    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add(EntityFilter::new('conference'));
    }

    public function configureFields(string $pageName): iterable
    {
        yield AssociationField::new('conference');
        yield TextField::new('author')->setHtmlAttributes(['maxlength' => 20]);
        yield EmailField::new('email');
        yield TextareaField::new('text')
            ->hideOnIndex();
        yield ImageField::new('photoFilename')
            ->setUploadDir('/public/uploads/photos')
            ->setUploadedFileNamePattern(fn(UploadedFile $photo) => Comment::setFilename($photo))
            ->setBasePath('/uploads/photos')
            ->setLabel('Photo');
            yield ChoiceField::new('state')->setChoices([
                'Published' => CommentStateEnum::Published,
                'Ham' => CommentStateEnum::Ham,
                'Rejected' => CommentStateEnum::Rejected,
                'Submitted' => CommentStateEnum::Submitted,
                'Spam' => CommentStateEnum::Spam,
                'PotentialSpam' => CommentStateEnum::PotentialSpam,
            ]);
        yield DateTimeField::new('createdAt')
            ->setRequired(false)
            ->setTimezone('Europe/Paris')->onlyOnIndex();
        yield DateTimeField::new('updatedAt')
            ->setRequired(false)
            ->setTimezone('Europe/Paris')->onlyOnIndex();
    }
}
