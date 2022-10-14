<?php

namespace Alura\Pdo\Domain\Interfaces;

use Alura\Pdo\Domain\Model\User;

require_once '../../vendor/autoload.php';

interface UserInterface 
{
    public function save(User $user): bool;

    public function insert(User $user): bool;

    public function update(User $user): bool;

    public function remove(User $user): bool;
}