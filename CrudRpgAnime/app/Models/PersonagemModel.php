<?php
require_once __DIR__ . '/Model.php';

class PersonagemModel extends Model {
    public function TodosPersonagens(): array 
    {
        $stmt = $this->db->query("SELECT * FROM personagem");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function PegarIdPersonagem($ID)
    {
        $stmt = $this->db->prepare("SELECT * FROM personagem WHERE ID = :ID");
        $stmt->execute([':ID'=> $ID]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function EnviarPersonagem($NOME, $ANIME, $DESCRICAO, $NIVEL, $VIDA, $MANA, $IMAGEM = null) {
        $stmt = $this->db->prepare("INSERT INTO personagem (NOME, ANIME, DESCRICAO, NIVEL, VIDA, MANA, IMAGEM) VALUES (:NOME, :ANIME, :DESCRICAO, :NIVEL, :VIDA, :MANA, :IMAGEM)");
        return $stmt->execute([
            ':NOME' => $NOME, 
            ':ANIME' => $ANIME, 
            ':DESCRICAO' => $DESCRICAO, 
            ':NIVEL' => $NIVEL, 
            ':VIDA' => $VIDA, 
            ':MANA' => $MANA, 
            ':IMAGEM' => $IMAGEM
        ]);
    }

    public function AtualizarPersonagem($ID, $NOME, $ANIME, $DESCRICAO, $NIVEL, $VIDA, $MANA, $IMAGEM = null) {
        $stmt = $this->db->prepare("UPDATE personagem SET NOME = :NOME, ANIME = :ANIME, DESCRICAO = :DESCRICAO, NIVEL = :NIVEL, VIDA = :VIDA, MANA = :MANA, IMAGEM = :IMAGEM WHERE ID = :ID");
        return $stmt->execute([
            ':NOME' => $NOME, 
            ':ANIME' => $ANIME, 
            ':DESCRICAO' => $DESCRICAO, 
            ':NIVEL' => $NIVEL, 
            ':VIDA' => $VIDA, 
            ':MANA' => $MANA, 
            ':IMAGEM' => $IMAGEM, 
            ':ID' => $ID
        ]);
    }

    public function ApagarPersonagem($ID) {
        $stmt = $this->db->prepare("DELETE FROM personagem WHERE ID = :ID");
        return $stmt->execute([':ID' => $ID ]);
    }
}