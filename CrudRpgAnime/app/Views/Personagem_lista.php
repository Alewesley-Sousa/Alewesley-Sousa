<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Personagem</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="/CrudRpgAnime/public/Css/Estilo.css" rel="stylesheet">
    <style>
        .descricao {
            min-width: 300px;
        }
        .descricao-container {
        max-height: 200px; /* Limite de altura */
        overflow-y: auto; /* Rolagem vertical */
        word-wrap: break-word; /* Quebra de palavras longas */
        }
        #p {
            background: linear-gradient(to right, #eee, #bbbbbb);
            border: 1px solid black;
            border-radius: 20px;
            padding: 20px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            z-index: 10;
            position: relative;
        }

        #p h1 {
            color: #032800;
            font-weight: 700;
            text-align: center;
            margin-bottom: 30px !important;
            position: relative;
            padding-bottom: 15px;
            font-weight: 900;
            text-shadow: 1px 1px 2px rgba(0,0,0,0.1);
        }
        
        #p h1:after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 25%;
            width: 50%;
            height: 6px;
            background: linear-gradient(to right, #14CD07, #138606);
            border-radius: 3px;
        }
        #nomeFilter, 
        #animeFilter, 
        #nivelFilter {
            transition: all 0.6s;
        }

        #nomeFilter:hover, 
        #animeFilter:hover, 
        #nivelFilter:hover {
            border-color: #14CD07; /* Cor verde */
            box-shadow: 0 0 5px #14CD07;
        }
        /* Melhorias na tabela */
        .table {
            border-collapse: separate;
            border-spacing: 0;
            background-color: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }

        .table thead th {
            background-color: #032800;
            color: white;
            font-weight: 800;
            padding: 12px;
            text-align: center;
            vertical-align: middle;
            border: none;
        }

        .table tbody tr {
            transition: all 0.2s ease;
        }

        .table tbody tr:hover {
            background-color:rgb(219, 219, 219);
        }

        .table tbody td {
            padding: 10px;
            vertical-align: middle;
            border-bottom: 5px solid #dee2e6;
        }

        /* Melhorias nas imagens */
        .img-thumbnail {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 20px;
            border: 1px solid white;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        /* Melhorias nos badges de nível */
        .badge-tag {
            display: inline-block;
            margin-top: 5px;
            padding: 4px 8px;
            font-size: 0.75rem;
            font-weight: 600;
            border-radius: 12px;
        }

        /* Efeitos de animação */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        } 

        .table-loading {
            opacity: 0;
            animation: fadeIn 0.5s ease forwards;
        }

        .table-row-loading {
            opacity: 0;
            transform: translateY(20px);
        }

        /* Estilos para o modal de confirmação (existente) */
        .confirm-modal {
            border: 3px solid #0CBA00;
            background-color: #1a1a1a;
            color: #fff;
            box-shadow: 0 0 20px rgba(14, 215, 0, 0.6);
            border-radius: 10px;
            opacity: 1;
        }

        .confirm-modal .modal-header {
            background: linear-gradient(to right, #12B506, #0B7903);
            border-bottom: 2px solid #ffcc00;
            opacity: 1;
        }

        .confirm-modal .modal-body {
            background-color: #2d2d2d;
            text-align: center;
            opacity: 1;
        }

        .confirm-modal .btn-danger {
            background-color: #dc3545;
            border-color: #ffcc00;
            transition: all 0.3s;
            opacity: 1;
        }

        .confirm-modal .btn-danger:hover {
            background-color: #a71d2a;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
        }

        .pixel-img {
            image-rendering: pixelated;
            width: 150px;
            height: 150px;
            object-fit: contain;
            filter: drop-shadow(0 0 5px rgba(255, 215, 0, 0.5));
            margin: 0 auto;
            display: block;
        }

        .character-name {
            font-family: 'Arial', monospace;
            font-size: 1.2rem;
            background-color: #000;
            color: #ffcc00;
            padding: 8px;
            border-radius: 4px;
            margin: 10px 0;
            display: inline-block;

        }
        #editar {
        	transition: all 0.3s;
        }
        
        #editar:hover {
        	background-color: #D27102;
        	transform: translateY(-3px);
        	font-weight: 700;
        }
        
        #excluir {
        	transition: all 0.3s;
        }
        
        #excluir:hover {
        	background-color: #980E04;
        	transform: translateY(-3px);
        	font-weight: 700;
        }
    </style>
</head>
<body>
    <div class="container mt-5" id="p">
        <h1 class="mb-4">Lista de Personagem</h1>
        <div class="styled-line"></div>
        
        <?php if (isset($_SESSION['message'])): ?>
            <div class="alert alert-<?= htmlspecialchars($_SESSION['message']['type']) ?>">
                <?= htmlspecialchars($_SESSION['message']['text']) ?>
            </div>
            <?php unset($_SESSION['message']); ?>
        <?php endif; ?>
        
        <div class="row mb-3">
            <div class="col-md-3">
                <input type="text" id="nomeFilter" class="form-control" placeholder="Filtrar por nome...">
            </div>
            <div class="col-md-3">
                <input type="text" id="animeFilter" class="form-control" placeholder="Filtrar por anime...">
            </div>
            <div class="col-md-2">
                <select id="nivelFilter" class="form-select">
                    <option value="">Todos níveis</option>
                    <option value="1">Novato (1+)</option>
                    <option value="6">Aprendiz (5+)</option>
                    <option value="11">Pré-Veterano (10+)</option>
                    <option value="26">Veterano (25+)</option>
                    <option value="31">Pré-Mestre (30+)</option>
                    <option value="51">Mestre (50+)</option>
                    <option value="61">Pós-Mestre (60+)</option>
                    <option value="76">Ancião (75+)</option>
                    <option value="100">SUPREMACIA (100)</option>
                </select>
            </div>
            <div class="col-md-2">
                <button id="resetFilters" class="btn btn-outline-secondary">Limpar</button>
            </div>
            <div class="col-md-2">
                <a href="/CrudRpgAnime/personagem/criar" class="btn btn-primary">Adicionar Novo</a>
            </div>
        </div>
        
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Avatar</th>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>Anime</th>
                        <th>Descrição</th>
                        <th>Nível</th>
                        <th>Vida</th>
                        <th>Mana</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($Personagens as $personagem): ?>
                        <tr>
                            <td>
                                <?php if (!empty($personagem['IMAGEM'])): ?>
                                    <img src="data:image/jpeg;base64,<?= base64_encode($personagem['IMAGEM']) ?>" class="img-thumbnail">
                                <?php else: ?>
                                    <div class="img-thumbnail bg-secondary d-flex align-items-center justify-content-center text-white">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 16 16">
                                            <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0zm4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4zm-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10z"/>
                                        </svg>
                                    </div>
                                <?php endif; ?>
                            </td>
                            <td><?= htmlspecialchars($personagem['ID']) ?></td>
                            <td><?= htmlspecialchars($personagem['NOME']) ?></td>
                            <td><?= htmlspecialchars($personagem['ANIME']) ?></td>
                            <td class="descricao">
                                <div class="descricao-container">
                                    <?= htmlspecialchars($personagem['DESCRICAO']) ?>
                                </div>
                            </td>
                            <td>
                                <span><?= htmlspecialchars($personagem['NIVEL']) ?></span>
                            </td>
                            <td><?= htmlspecialchars($personagem['VIDA']) ?></td>
                            <td><?= htmlspecialchars($personagem['MANA']) ?></td>
                            <td>
                                <div class="d-flex gap-2">
                                    <a href="/CrudRpgAnime/personagem/editar?id=<?= $personagem['ID'] ?>" class="btn btn-sm btn-warning" id="editar">Editar</a>
                                    <a href="/CrudRpgAnime/personagem/apagar?id=<?= $personagem['ID'] ?>" class="btn btn-sm btn-danger btn-delete" id="excluir">Excluir</a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
	<script>
	document.addEventListener('DOMContentLoaded', function() {
	    // Efeitos visuais
	    const table = document.querySelector('table');
	    table.classList.add('table-loading');
	    
	    const rows = document.querySelectorAll('tbody tr');
	    rows.forEach((row, index) => {
	        row.classList.add('table-row-loading');
	        row.style.animationDelay = `${index * 0.05}s`;
	        row.style.animation = 'fadeIn 0.3s ease forwards';
	        
	        // Novo sistema de tags baseado no nível
	        const nivel = parseInt(row.cells[5].textContent);
	        let tag = '';
	        
	        if (nivel >= 1 && nivel <= 4) tag = 'Novato';
	        else if (nivel >= 5 && nivel <= 9) tag = 'Aprendiz';
	        else if (nivel >= 10 && nivel <= 24) tag = 'Pré-Veterano';
	        else if (nivel >= 25 && nivel <= 29) tag = 'Veterano';
	        else if (nivel >= 30 && nivel <= 49) tag = 'Pré-Mestre';
	        else if (nivel >= 50 && nivel <= 59) tag = 'Mestre';
	        else if (nivel >= 60 && nivel <= 74) tag = 'Pós-Mestre';
	        else if (nivel >= 75 && nivel <= 99) tag = 'Ancião';
	        else if (nivel === 100) tag = 'SUPREMACIA';
	        
	        if (tag) {
	            const nomeOriginal = row.cells[2].innerHTML;
	            let badgeClass = 'bg-secondary';
	            
	            // Classes de cores diferentes para cada tag
	            if (tag === 'SUPREMACIA') badgeClass = 'bg-danger';
	            else if (tag === 'Ancião') badgeClass = 'bg-dark';
	            else if (tag === 'Mestre' || tag === 'Pós-Mestre') badgeClass = 'bg-warning text-dark';
	            else if (tag === 'Veterano' || tag === 'Pré-Mestre') badgeClass = 'bg-primary';
	            else if (tag === 'Pré-Veterano') badgeClass = 'bg-info text-dark';
	            
	            row.cells[2].innerHTML = `
	                <div style="text-align: center">
	                    <div>${nomeOriginal}</div>
	                    <span class="badge ${badgeClass} badge-tag">${tag}</span>
	                </div>`;
	        }
	    });
	
	    // Filtros
		function applyFilters() {
		    const nomeValue = document.getElementById('nomeFilter').value.toLowerCase();
		    const animeValue = document.getElementById('animeFilter').value.toLowerCase();
		    const nivelValue = document.getElementById('nivelFilter').value;
		    
		    rows.forEach(row => {
		        const nome = row.cells[2].textContent.toLowerCase();
		        const anime = row.cells[3].textContent.toLowerCase();
		        const nivel = parseInt(row.cells[5].textContent) || 0;
		        
		        row.style.display = (nome.includes(nomeValue) && 
		                           anime.includes(animeValue) && 
		                           (!nivelValue || nivel >= parseInt(nivelValue))) 
		                           ? '' : 'none';
		    });
		}
	    
	    // Event listeners para filtros
	    document.getElementById('nomeFilter').addEventListener('input', applyFilters);
	    document.getElementById('animeFilter').addEventListener('input', applyFilters);
	    document.getElementById('nivelFilter').addEventListener('change', applyFilters);
	    
	    document.getElementById('resetFilters').addEventListener('click', () => {
	        document.getElementById('nomeFilter').value = '';
	        document.getElementById('animeFilter').value = '';
	        document.getElementById('nivelFilter').value = '';
	        applyFilters();
	    });
	
	    // Aplica filtros inicialmente
	    applyFilters();
	
	    // Confirmação de exclusão com imagem do Goku pixelada
	    document.querySelectorAll('.btn-delete').forEach(btn => {
	        btn.addEventListener('click', function(e) {
	            e.preventDefault();
			const nomeCell = this.closest('tr').cells[2];
			// Verifica se há uma div dentro da célula (caso do personagem lendário)
			const personagemNome = nomeCell.querySelector('div > div') 
			    ? nomeCell.querySelector('div > div').textContent.trim() 
			    : nomeCell.textContent.trim();
	            
	            const modalHtml = `
	            <div class="modal fade" id="confirmDeleteModal">
	                <div class="modal-dialog">
	                    <div class="modal-content confirm-modal">
	                        <div class="modal-header bg-danger text-white">
	                            <h5 class="modal-title">🗡️ Excluir Personagem</h5>
	                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
	                        </div>
	                        <div class="modal-body">
	                            <img src="/CrudRpgAnime/public/imagens/goku-pixel.png" 
	                                 class="pixel-img mb-3" 
	                                 alt="Goku Pixel Art">
	                            <h6>Você está excluindo:</h6>
	                            <div class="character-name">${personagemNome}</div>
	                            <div class="alert alert-danger py-2 mt-3 mb-0">
	                                <i class="bi bi-exclamation-triangle-fill"></i> Esta ação é irreversível!
	                            </div>
	                        </div>
	                        <div class="modal-footer justify-content-center border-top-0">
	                            <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">
	                                <i class="bi bi-x-circle"></i> Cancelar
	                            </button>
	                            <a href="${this.href}" class="btn btn-danger px-4">
	                                <i class="bi bi-trash3-fill"></i> Confirmar
	                            </a>
	                        </div>
	                    </div>
	                </div>
	            </div>`;
	            
	            document.body.insertAdjacentHTML('beforeend', modalHtml);
	            new bootstrap.Modal(document.getElementById('confirmDeleteModal')).show();
	            
	            document.getElementById('confirmDeleteModal').addEventListener('hidden.bs.modal', function() {
	                this.remove();
	            });
	        });
	    });
	});
	</script>

    <img src="\CrudRpgAnime\public\Imagens\Rodape.png" alt="rodape" class="rodape">

</body>
</html>