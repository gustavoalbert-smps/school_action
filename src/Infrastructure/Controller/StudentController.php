<?php

namespace Alura\Pdo\Infrastructure\Controller;

use PDO;

require_once '../../vendor/autoload.php';

class StudentController 
{
    private PDO $connection;

    public function __construct(PDO $connection)
    {
        $this->connection = $connection;
    }

    
}