<?php
require_once __DIR__ . '/../models/Model.php';
require_once __DIR__ . '/../models/PokemonModel.php';

class PokemonController
{
    private $model;

    public function __construct()
    {
        $this->model = new PokemonModel();
        session_start(); // Inicia a sessão para usar $_SESSION
    }

    public function list()
    {
        $pokemons = $this->model->getAllPokemons(); // Verifique se o nome do método está correto (case-sensitive)
        require __DIR__ . '/../views/pokemon_list.php';
    }

    public function create()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'];
            $type = $_POST['type'];
            $description = $_POST['description'];
            $this->model->createPokemon($name, $type, $description);

            // Define a mensagem e o tipo
            $_SESSION['message'] = [
                'text' => 'Pokémon adicionado com sucesso!', // Correção: => em vez de ->
                'type' => 'success'
            ];
            header("Location: /mvcPokemon2/pokemon/list");
            exit;
        }
        require __DIR__ . '/../views/pokemon_form.php';
    }

    public function edit()
    {
        $id = $_GET['id'];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'];
            $type = $_POST['type'];
            $description = $_POST['description'];
            $this->model->updatePokemon($id, $name, $type, $description);

            // Define a mensagem e o tipo
            $_SESSION['message'] = [
                'text' => 'Pokémon atualizado com sucesso!',
                'type' => 'success'
            ];
            header("Location: /MVCpokemon2/pokemon/list");
            exit;
        }
        $pokemon = $this->model->getPokemonById($id);
        require __DIR__ . '/../views/pokemon_form.php'; // Correção: Adicionado ;
    }

    public function delete()
    {
        $id = $_GET['id'] ?? null;
        if(!$id || !is_numeric($id)) {
            $_SESSION['message'] = [
            'text' => 'ID inválido!',
            'type' => 'danger'
        ];
        header("Location: /MVCpokemon2/pokemon/list");
        exit;
        }
    
        $this->model->deletePokemon($id);

        // Define a mensagem e o tipo
        $_SESSION['message'] = [
            'text' => 'Pokémon excluído com sucesso!',
            'type' => 'danger'
        ];
        header("Location: /MVCpokemon2/pokemon/list");
        exit;
    }
}