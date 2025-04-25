<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Pokémon</title>
    <!-- bootstrap css -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Lista de Pokémon</h1>
        <?php
        //Verifica se há uma massagem na sessão
        if (isset($_SESSION['message'])) {
            $message = $_SESSION['message'];
            $type = $message['type']; // sucess, danger ou warning
            echo '<div class="alert-' . htmlspecialchars
            ($type) . '">' . htmlspecialchars($message
            ['text']) . '</div>';
            // Limpa a mensagem após exibi-la
            unset($_SESSION['message']);
        }
        ?>
        <a href="/MVCpokemon2/pokemon/create" class="btn btn-primary mb-3">Adicionar Novo Pokémon</a>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Tipo</th>
                    <th>Descrição</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($pokemons as $pokemon): ?>
                    <tr>
                        <td><?= htmlspecialchars($pokemon['id']) ?></td>
                        <td><?= htmlspecialchars($pokemon['name']) ?></td>
                        <td><?= htmlspecialchars($pokemon['type']) ?></td>
                        <td><?= htmlspecialchars($pokemon['description']) ?></td>
                        <td>
                            <a href="/MVCpokemon2/pokemon/edit?id=<?= $pokemon['id'] ?>" class="btn btn-sm btn-warning">Editar</a>
                            <a href="/MVCpokemon2/pokemon/delete?id=<?= htmlspecialchars($pokemon['id']) ?>" class="btn btn-sm btn-danger" onclick="return confirm('tem certeza que deseja excluir este Pokemon?')">Excluir</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    
</body>
</html>