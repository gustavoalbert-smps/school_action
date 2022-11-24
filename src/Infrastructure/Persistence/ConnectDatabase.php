<?php

namespace Alura\Pdo\Infrastructure\Persistence;

//require_once '../../vendor/autoload.php';

use PDO;

class ConnectDatabase 
{
    public static function connect() :PDO
    {
       
    $host = "us-cdbr-east-06.cleardb.net"; 
    $db = "heroku_de282252de2da63";
    $user = "b52465a7c79918";
    $pass = "e99bcde1";

    $options = array(\PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8");

    $connection = new PDO("mysql:host=$host;dbname=$db",$user,$pass, $options);
    
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    return $connection;
    }
}