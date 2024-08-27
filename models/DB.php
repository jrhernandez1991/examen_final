<?php
class DB extends PDO
{
    public function __construct()
    {
        $dsn = "mysql:host=localhost;dbname=examen_final";
        parent::__construct($dsn, "root", "");
    }
}
?>
