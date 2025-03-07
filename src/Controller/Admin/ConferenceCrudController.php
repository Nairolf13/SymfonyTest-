<?php

namespace App\Controller\Admin;

use App\Entity\Conference;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ConferenceCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Conference::class;
    }

    public function configureFields(string $pageName): iterable
    {
        yield IdField::new('id')->hideOnForm();
        yield TextField::new('city');
        yield TextField::new('year');
        yield BooleanField::new('isInternational');

        yield DateTimeField::new('createdAt')
            ->setRequired(false)
            ->setTimezone('Europe/Paris')->onlyOnIndex();
        yield DateTimeField::new('updatedAt')
            ->setRequired(false)
            ->setTimezone('Europe/Paris')->onlyOnIndex();
    }
}
