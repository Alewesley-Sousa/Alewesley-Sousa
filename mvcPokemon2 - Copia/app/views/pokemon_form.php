<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($pokemon) ? 'Editar Pokémon' : 'Adicionar Pokémon' ?></title>
    <!-- bootstrap css -->
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <h1 class="mb-1"><?= isset($pokemon) ? 'Editar Pokémon' : 'Adicionar Pokemon' ?></h1>
        <form action="" method="POST">
            <div class="mb-3">
                <label for="name" class="form-label">Nome</label>
                <input type="text" class="form-control" id="name" name="name" value="<?= htmlspecialchars($pokemon['name'] ?? '') ?>" required>
            </div>
            <div class="mb-3">
                <label for="type" class="form-label">Tipo</label>
                <input type="text" class="form-control" id="type" name="type" value="<?= htmlspecialchars($pokemon['type'] ?? '') ?>" required>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Descrição</label>
                <textarea class="form-control" id="description" name="description" rows="3"><?= htmlspecialchars($pokemon['description'] ?? '') ?></textarea>
            </div>
            <button type="submit" class="btn btn-primary"><?= isset($pokemon) ? 'Atualizar' : 'Salvar' ?></button>
            <a href="/MVCpokemon2/pokemon/list" class="btn btn-secondary">Cancelar</a>
        </form>
    </div> 
</body>
</html>