<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($personagem) ? 'Editar Personagem' : 'Adicionar Personagem' ?></title>
    
    <!-- CSS Externo -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="/../../public/Css/Estilo.css" rel="stylesheet">
    
    <style>
        /* === ESTILOS GERAIS === */
        body {
            opacity: 0;
            animation: fadeIn 0.8s ease-in forwards;
            background-color: #f8f9fa;
            background-image: url('/public/imagens/rpg-bg-pattern.png');
            background-attachment: fixed;
        }
        
        /* === ANIMAÇÕES === */
        @keyframes fadeIn {
            to { opacity: 1; }
        }
        
        @keyframes slideUp {
            from { transform: translateY(30px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }
        
        @keyframes typing {
            from { width: 0 }
            to { width: 100% }
        }
        
        /* === LAYOUT PRINCIPAL === */
        .container {
            max-width: 800px;
            background-color: white;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            padding: 30px;
            margin-top: 50px;
            margin-bottom: 50px;
            animation: slideUp 0.5s ease-out;
        }
        
        /* === ESTILOS DO TÍTULO === */
        h1 {
            color: #343a40;
            font-weight: 700;
            text-align: center;
            margin-bottom: 30px !important;
            position: relative;
            padding-bottom: 15px;
        }
        
        h1:after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 25%;
            width: 50%;
            height: 3px;
            background: linear-gradient(to right, #dc3545, #ffc107);
            border-radius: 3px;
        }
        
        /* === ESTILOS DOS FORMULÁRIOS === */
        .form-control, .form-select {
            border-radius: 8px;
            padding: 12px 15px;
            border: 2px solid #e9ecef;
            transition: all 0.3s;
        }
        
        .form-control:focus, .form-select:focus {
            border-color: #dc3545;
            box-shadow: 0 0 0 0.25rem rgba(220, 53, 69, 0.25);
        }
        
        .form-label {
            font-weight: 600;
            color: #495057;
            margin-bottom: 8px;
        }
        
        /* Validação de imagem quadrada */
        .invalid-feedback-square {
            display: none;
            color: #dc3545;
            font-size: 0.875em;
        }
        
        .is-invalid-square {
            border-color: #dc3545 !important;
        }
        
        /* === ESTILOS DOS BOTÕES === */
        .btn {
            border-radius: 8px;
            padding: 10px 20px;
            font-weight: 600;
            transition: all 0.3s;
            letter-spacing: 0.5px;
        }
        
        .btn-primary {
            background-color: #dc3545;
            border-color: #dc3545;
        }
        
        .btn-primary:hover {
            background-color: #bb2d3b;
            border-color: #bb2d3b;
            transform: translateY(-2px);
        }
        
        .btn-secondary {
            background-color: #6c757d;
            border-color: #6c757d;
        }
        
        /* === ESTILOS DA IMAGEM === */
        .img-thumbnail {
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            transition: all 0.3s;
            max-height: 150px;
        }
        
        .img-thumbnail:hover {
            transform: scale(1.05);
            box-shadow: 0 8px 15px rgba(0,0,0,0.2);
        }
        
        /* === EFEITOS INTERATIVOS === */
        .mb-3:hover .form-label {
            color: #dc3545;
        }
        
        .typing-effect {
            overflow: hidden;
            white-space: nowrap;
            animation: typing 1s steps(40, end);
        }
        
        /* === RESPONSIVIDADE === */
        @media (max-width: 768px) {
            .container {
                margin-top: 20px;
                padding: 20px;
            }
            
            h1 {
                font-size: 1.8rem;
            }
        }
    </style>
</head>
<body>
    <!-- Container Principal -->
    <div class="container mt-5">
        <!-- Título Dinâmico -->
        <h1 class="mb-4 typing-effect"><?= isset($personagem) ? 'Editar Personagem' : 'Adicionar Personagem' ?></h1>
        
        <!-- Mensagens de Feedback -->
        <?php if (isset($_SESSION['message'])): ?>
            <div class="alert alert-<?= htmlspecialchars($_SESSION['message']['type']) ?> alert-dismissible fade show">
                <?= htmlspecialchars($_SESSION['message']['text']) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            <?php unset($_SESSION['message']); ?>
        <?php endif; ?>
        
        <!-- Formulário Principal -->
        <form action="" method="POST" enctype="multipart/form-data">
            <!-- Campo Nome -->
            <div class="mb-3">
                <label for="NOME" class="form-label">Nome</label>
                <input type="text" class="form-control" id="NOME" name="NOME" 
                       value="<?= htmlspecialchars($personagem['NOME'] ?? '') ?>" required>
            </div>
            
            <!-- Campo Anime -->
            <div class="mb-3">
                <label for="ANIME" class="form-label">Anime</label>
                <input type="text" class="form-control" id="ANIME" name="ANIME" 
                       value="<?= htmlspecialchars($personagem['ANIME'] ?? '') ?>" required>
            </div>
            
            <!-- Campo Descrição -->
            <div class="mb-3">
                <label for="DESCRICAO" class="form-label">Descrição</label>
                <textarea class="form-control" id="DESCRICAO" name="DESCRICAO" rows="4"
                          style="min-height: 120px;"><?= htmlspecialchars($personagem['DESCRICAO'] ?? '') ?></textarea>
            </div>
            
            <!-- Seção de Atributos (Nível, Vida, Mana) -->
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label for="NIVEL" class="form-label">Nível</label>
                    <input type="number" class="form-control" id="NIVEL" name="NIVEL" 
                           value="<?= htmlspecialchars($personagem['NIVEL'] ?? '1') ?>" 
                           min="1" max="100" required>
                </div>
                
                <div class="col-md-4 mb-3">
                    <label for="VIDA" class="form-label">Vida</label>
                    <input type="number" class="form-control" id="VIDA" name="VIDA" 
                           value="<?= htmlspecialchars($personagem['VIDA'] ?? '1') ?>" 
                           min="1" max="100" required>
                </div>
                
                <div class="col-md-4 mb-3">
                    <label for="MANA" class="form-label">Mana</label>
                    <input type="number" class="form-control" id="MANA" name="MANA" 
                           value="<?= htmlspecialchars($personagem['MANA'] ?? '1') ?>" 
                           min="1" max="100" required>
                </div>
            </div>
            
            <!-- Seção de Upload de Imagem -->
            <div class="mb-4">
                <label for="IMAGEM" class="form-label">Imagem (deve ser quadrada - proporção 1:1)</label>
                <input type="file" class="form-control" id="IMAGEM" name="IMAGEM" 
                       accept="image/*" onchange="validateSquareImage(this)">
                <div class="invalid-feedback-square mt-1" id="squareError">
                    A imagem deve ser quadrada (mesma largura e altura).
                </div>
                
                <!-- Preview da Imagem Existente ou Nova -->
                <?php if (isset($personagem['IMAGEM']) && !empty($personagem['IMAGEM'])): ?>
                    <div class="mt-3 text-center">
                        <img src="data:image/jpeg;base64,<?= base64_encode($personagem['IMAGEM']) ?>" 
                             class="img-thumbnail mb-2" id="imagePreview">
                        <p class="text-muted">Imagem atual</p>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="REMOVER_IMAGEM" name="REMOVER_IMAGEM">
                            <label class="form-check-label" for="REMOVER_IMAGEM">Remover imagem</label>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="mt-3 text-center d-none" id="previewContainer">
                        <img src="#" class="img-thumbnail mb-2" id="imagePreview" style="max-height: 200px;">
                        <p class="text-muted">Pré-visualização</p>
                    </div>
                <?php endif; ?>
            </div>
            
            <!-- Botões de Ação -->
            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                <a href="/CrudRpgAnime/personagem/lista" class="btn btn-secondary me-md-2">
                    <i class="bi bi-arrow-left"></i> Cancelar
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save"></i> <?= isset($personagem) ? 'Atualizar' : 'Salvar' ?>
                </button>
            </div>
        </form>
    </div>
    
    <!-- JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        /**
         * Valida se a imagem é quadrada (1:1)
         * @param {HTMLInputElement} input - Elemento de input do arquivo
         */
        function validateSquareImage(input) {
            const file = input.files[0];
            const errorElement = document.getElementById('squareError');
            
            if (file) {
                const img = new Image();
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    img.src = e.target.result;
                    
                    img.onload = function() {
                        const previewContainer = document.getElementById('previewContainer');
                        const preview = document.getElementById('imagePreview');
                        
                        // Verifica proporção da imagem
                        if (this.width !== this.height) {
                            input.classList.add('is-invalid-square');
                            errorElement.style.display = 'block';
                            input.value = ''; // Limpa o input
                            
                            if (previewContainer) {
                                previewContainer.classList.add('d-none');
                            }
                        } else {
                            input.classList.remove('is-invalid-square');
                            errorElement.style.display = 'none';
                            preview.src = e.target.result;
                            
                            if (previewContainer) {
                                previewContainer.classList.remove('d-none');
                            }
                        }
                    };
                };
                
                reader.readAsDataURL(file);
            }
        }
        
        /**
         * Mostra preview da imagem selecionada
         * @param {Event} event - Evento de change do input
         */
        function previewImage(event) {
            const previewContainer = document.getElementById('previewContainer');
            const preview = document.getElementById('imagePreview');
            const file = event.target.files[0];
            
            if (file) {
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    if (previewContainer) previewContainer.classList.remove('d-none');
                }
                
                reader.readAsDataURL(file);
            }
        }
        
        // Inicialização quando o DOM estiver carregado
        document.addEventListener('DOMContentLoaded', function() {
            // Efeito de digitação no título
            const title = document.querySelector('h1');
            if (title) {
                title.style.animation = 'typing 1s steps(40, end)';
            }
            
            // Validação dos campos numéricos
            document.querySelectorAll('input[type="number"]').forEach(input => {
                input.addEventListener('input', function() {
                    const max = parseInt(this.max);
                    if (this.value > max) {
                        this.value = max;
                    }
                });
            });
        });
    </script>
</body>
</html>