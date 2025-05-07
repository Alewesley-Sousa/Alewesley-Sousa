<?php

class Model {
    protected $db;

    public function __construct() {
        $host = "localhost";
        $dbname = "rpg_anime";
        $usuario = "root";
        $senha = "";

        try {
            $this->db = new PDO("mysql:host=$host; dbname=$dbname; charset=utf8", $usuario, $senha);
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e){
            die("conexão não estabelecida: " . $e->getMessage());
        }
    }
}