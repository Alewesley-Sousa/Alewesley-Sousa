<?php 
ini_set('display_errors', 1);
error_reporting(E_ALL);
class Model{
    protected $db;
    public function __construct() {
        // conexão com o banco de dados
        $host = 'localhost' ; //onde ele esta hospedado
        $dbname = 'pokedex' ; //nome do meu banco de dados
        $username = 'root' ; //para acessar o php colocamos o nome de usuario, root por padrao
        $password = '' ; //senha

        try {
            $this->db = new PDO("mysql:host=$host; dbname=$dbname; charset=utf8", $username, $password); //$this serve para se referir ao objeto atual dentro do banco
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            // echo "Conexão com o banco de dados estabelecida com sucesso!";

        } catch (PDOException $e) {
            die('Erro ao conectar ao banco de dados:' . $e->getMessage());
        }
    }
}

?>