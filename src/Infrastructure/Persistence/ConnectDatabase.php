<?php

namespace Alura\Pdo\Infrastructure\Persistence;

require_once '../../vendor/autoload.php';

use PDO;

class ConnectDatabase 
{
    public static function connect() :PDO
    {
       
    $host = "localhost";
    $db = "school_db";
    $user = "school";
    $pass = "school@12";

    $connection = new PDO("mysql:host=$host;dbname=$db",$user,$pass);
    
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    return $connection;
    }
}