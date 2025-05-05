<?php
namespace App\Enums;

class PersonnelType
{
    public const TYPE_ADMIN = 'admin';
    public const TYPE_USER = 'user';
    public const TYPE_MANAGER = 'manager';

}

enum PersonnelType: string
{
    case PER = 'PER';
    case PATS = 'PATS';
}
