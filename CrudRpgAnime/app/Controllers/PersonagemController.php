<?php
require_once __DIR__ . '/../Models/Model.php';
require_once __DIR__ . '/../Models/PersonagemModel.php';

class PersonagemController {
    private $Model;

    public function __construct()
    {
        $this->Model = new PersonagemModel();
        session_start();
    }

    public function lista()
    {
        $Personagens = $this->Model->TodosPersonagens();
        require __DIR__ . '/../Views/Personagem_lista.php';
    }

    public function criar()
    {
	    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	        $NOME = $_POST['NOME'];
	        $ANIME = $_POST['ANIME'];
	        $DESCRICAO = $_POST['DESCRICAO'];
	        $NIVEL = $_POST['NIVEL'];
	        $VIDA = $_POST['VIDA'];
	        $MANA = $_POST['MANA'];
	        
	        // Processar a imagem
	        $IMAGEM = null;
	        if (isset($_FILES['IMAGEM']) && $_FILES['IMAGEM']['error'] === UPLOAD_ERR_OK) {
	            // Validação de imagem quadrada no servidor
	            $imageInfo = getimagesize($_FILES['IMAGEM']['tmp_name']);
	            if ($imageInfo[0] !== $imageInfo[1]) {
	                $_SESSION['message'] = [
	                    'text' => 'A imagem deve ser quadrada (mesma largura e altura).',
	                    'type' => 'danger'
	                ];
	                header("Location: /CrudRpgAnime/personagem/criar");
	                exit;
	            }
	            $IMAGEM = file_get_contents($_FILES['IMAGEM']['tmp_name']);
	        }
	
	        $this->Model->EnviarPersonagem($NOME, $ANIME, $DESCRICAO, $NIVEL, $VIDA, $MANA, $IMAGEM);
	
	        $_SESSION['message'] = [
	            'text' => 'Personagem criado com sucesso!',
	            'type' => 'success'   
	        ];
	        header("Location: /CrudRpgAnime/personagem/lista");
	        exit;
	    }
	    require __DIR__ . '/../Views/Personagem_form.php';
    }

    public function editar()
    {
	    $ID = $_GET['id'];
	    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	        $NOME = $_POST['NOME'];
	        $ANIME = $_POST['ANIME'];
	        $DESCRICAO = $_POST['DESCRICAO'];
	        $NIVEL = $_POST['NIVEL'];
	        $VIDA = $_POST['VIDA'];
	        $MANA = $_POST['MANA'];
	        
	        // Processar a imagem - mantém a existente se não for enviada nova
	        $IMAGEM = null;
	        if (isset($_FILES['IMAGEM']) && $_FILES['IMAGEM']['error'] === UPLOAD_ERR_OK) {
	            // Validação de imagem quadrada no servidor
	            $imageInfo = getimagesize($_FILES['IMAGEM']['tmp_name']);
	            if ($imageInfo[0] !== $imageInfo[1]) {
	                $_SESSION['message'] = [
	                    'text' => 'A imagem deve ser quadrada (mesma largura e altura).',
	                    'type' => 'danger'
	                ];
	                header("Location: /CrudRpgAnime/personagem/editar?id=" . $ID);
	                exit;
	            }
	            $IMAGEM = file_get_contents($_FILES['IMAGEM']['tmp_name']);
	        } else {
	            // Se não enviou nova imagem, mantém a existente
	            $personagemExistente = $this->Model->PegarIdPersonagem($ID);
	            $IMAGEM = $personagemExistente['IMAGEM'];
	        }
	
	        $this->Model->AtualizarPersonagem($ID, $NOME, $ANIME, $DESCRICAO, $NIVEL, $VIDA, $MANA, $IMAGEM);
	
	        $_SESSION['message'] = [
	            'text' => "O personagem $NOME foi atualizado com sucesso!",
	            'type' => 'success'
	        ];
	        header("Location: /CrudRpgAnime/personagem/lista");
	        exit;
	    }
	    $personagem = $this->Model->PegarIdPersonagem($ID);
	    require __DIR__ . '/../Views/Personagem_form.php';
    }

    public function Apagar()
    {
        $id = $_GET['id'] ?? null;
        if(!$id || !is_numeric($id)) {
            $_SESSION['message'] = [
                'text' => 'ID inválido!',
                'type' => 'danger'
            ];
            header("Location: /CrudRpgAnime/personagem/lista");
            exit;
        }
        $this->Model->ApagarPersonagem($id);

        $_SESSION['message'] = [
            'text' => "O personagem foi excluído com sucesso!",
            'type' => 'danger'
        ];
        header("Location: /CrudRpgAnime/personagem/lista");
        exit;
    }
}