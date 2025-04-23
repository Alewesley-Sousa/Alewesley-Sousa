<?php
require_once APP_PATH . 'app/models/Model.php';

class PokemonModel extends Model{
    public function getAllPokemons (): array
    {
        $stmt = $this->db->query("SELECT * FROM pokemons");

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getPokemonById($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM pokemons WHERE id = :id");
        $stmt->execute(['id'=> $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function createPokemon($name, $type, $description)
    {
        $stmt = $this->db->prepare("INSERT INTO pokemons (name, type, description) VALUES (:name, :type, :description)");
    return $stmt->execute(['name' => $name, 'type' => $type, 'description' => $description]);
    }
    public function updatePokemon($id, $name, $type, $description)
    {
        $stmt = $this->db->prepare("UPDATE pokemons SET name = :name, type = :type, description = :description WHERE id = :id");
        return $stmt->execute(['id' => $id, 'name' => $name, 'type' => $type, 'description' => $description]);
    }
    public function deletePokemon($id) 
    {
        $stmt = $this->db->prepare("DELETE FROM pokemons WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }
    
}