<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Personagem</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="/../../public/Css/Estilo.css" rel="stylesheet">
    <style>
		/* Adicione no seu <style> */
		
		body {
		    opacity: 0;
		    animation: fadeIn 1s ease-in forwards;
		    background-color: #444444;
		    background-image: url('/../../public/Imagens/shelong.png');
		    background-size: cover;
		    background-position: center;
		    background-repeat: no-repeat;
		    background-attachment: fixed;
		    margin: 0;
		    padding: 0;
		    min-height: 100vh;
		    position: relative;
		}
		

		}
		
		@keyframes fadeIn {
		    to { opacity: 1; }
		}
        .img-thumbnail { max-width: 100px; max-height: 100px; }
        .container { padding-bottom: 50px; }
        
        /* Efeitos de animação */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .table-loading { opacity: 0; animation: fadeIn 0.5s ease forwards; }
        .table-row-loading { opacity: 0; transform: translateY(20px); }
        
        /* Efeitos de interação */
        .table tbody tr { transition: all 0.3s ease; }
        .table tbody tr:hover { background-color: rgba(0,0,0,0.02); }
        
        /* Tags de status */
        .badge-tag { 
        	display: block;
		    margin: 5px auto 0;
		    width: fit-content;
        }

        /* Estilos para o modal de confirmação */
        .pixel-img {
            image-rendering: -moz-crisp-edges;
            image-rendering: pixelated;
            width: 150px;
            height: 150px;
            object-fit: contain;
            filter: drop-shadow(0 0 5px rgba(255, 215, 0, 0.5));
            margin: 0 auto;
            display: block;
        }
        .confirm-modal {
            border: 3px solid #dc3545;
            background-color: #1a1a1a;
            color: #fff;
            box-shadow: 0 0 20px rgba(220, 53, 69, 0.6);
        }
        .confirm-modal .modal-header {
            background: linear-gradient(to right, #dc3545, #8b0000);
            border-bottom: 2px solid #ffcc00;
        }
        .confirm-modal .modal-body {
            background-color: #2d2d2d;
            text-align: center;
        }
        .confirm-modal .btn-danger {
            background-color: #dc3545;
            border-color: #ffcc00;
            transition: all 0.3s;
        }
        .confirm-modal .btn-danger:hover {
            background-color: #a71d2a;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
        }
        .character-name {
            font-family: 'Courier New', monospace;
            font-size: 1.2rem;
            background-color: #000;
            color: #ffcc00;
            padding: 8px;
            border-radius: 4px;
            margin: 10px 0;
            display: inline-block;
        }
        
		footer {
		    position: fixed;
		    bottom: 0;
		    left: 0;
		    width: 100%;
		    height: auto;
		    z-index: 1000;
		    margin: 0;
		    padding: 0;
		}
		
		.rodape {
		    width: 100%;
		    display: block;
		    margin: 0;
		    padding: 0;
		}
		#p {
		    background: linear-gradient(to right, #cccccc,#bbbbbb);
		    border: 1px black solid;
		    margin-bottom: 80px; /* Espaço extra para o rodapé */
		    padding-bottom: 20px;
		}
    </style>
</head>
<body>
    <div class="container mt-5" id="p">
        <h1 class="mb-4">Lista de Personagem</h1>
        
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
        
        <table class="table table-striped">
            <thead>
                <tr>
                    <th></th>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Anime</th>
                    <th>Descrição</th>
                    <th>Nivel</th>
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
                                <span class="text-muted">Sem imagem</span>
                            <?php endif; ?>
                        </td>
                        <td><?= htmlspecialchars($personagem['ID']) ?></td>
                        <td><?= htmlspecialchars($personagem['NOME']) ?></td>
                        <td><?= htmlspecialchars($personagem['ANIME']) ?></td>
                        <td><?= htmlspecialchars($personagem['DESCRICAO']) ?></td>
                        <td><?= htmlspecialchars($personagem['NIVEL']) ?></td>
                        <td><?= htmlspecialchars($personagem['VIDA']) ?></td>
                        <td><?= htmlspecialchars($personagem['MANA']) ?></td>
                        <td>
                            <a href="/CrudRpgAnime/personagem/editar?id=<?= $personagem['ID'] ?>" class="btn btn-sm btn-warning">Editar</a>
                            <a href="/CrudRpgAnime/personagem/apagar?id=<?= $personagem['ID'] ?>" class="btn btn-sm btn-danger btn-delete">Excluir</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <footer>
    	<img src="/../../public/Imagens/Rodape.png" alt="rodape" class="rodape">
    </footer>
    
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
	                            <img src="/public/imagens/goku-pixel.png" 
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
</body>
</html>