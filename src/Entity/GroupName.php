<?php

namespace App\Entity;

class GroupName
{
    public const READ = 'read';
    public const WRITE = 'write';
    public const GROUPS_ONLY_WRITE = ['groups' => [GroupName::WRITE]];
}
