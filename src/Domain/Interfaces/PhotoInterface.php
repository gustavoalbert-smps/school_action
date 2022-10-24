<?php

namespace Alura\Pdo\Domain\Interfaces;

use Alura\Pdo\Domain\Model\Photo;

require_once '../../vendor/autoload.php';

interface PhotoInterface
{
    public function insert(Photo $photo): bool;

    public function update(Photo $photo): bool;

    public function save(Photo $photo): bool;

    public function remove(Photo $photo): bool;
}