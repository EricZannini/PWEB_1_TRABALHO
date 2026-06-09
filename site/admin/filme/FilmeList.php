<?php
include '../header.php';
include '../autenticacao.php';
include_once '../database/db.class.php';

$db = new db('filmes');

if (!empty($_GET['delete'])) {
    $db->destroy((int) $_GET['delete']);
    $msgDelete = 'Filme excluído com sucesso!';
}

$filmes = $db->all();

if (!empty($_POST['buscar'])) {
    $filmes = $db->search(['tipo' => $_POST['tipo'], 'valor' => $_POST['valor']]);
}
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0"><i class="fa-solid fa-clapperboard me-2" style="color:#e63946"></i>Filmes</h4>
    <a href="FilmeForm.php" class="btn btn-danger">
        <i class="fa-solid fa-plus me-1"></i>Novo Filme
    </a>
</div>

<?php if (!empty($msgDelete)): ?>
    <div class="alert alert-success"><?= $msgDelete ?></div>
<?php endif; ?>

<form method="POST" class="glass-effect p-3 mb-4 d-flex gap-2 flex-wrap">
    <select name="tipo" class="form-select" style="max-width:180px;">
        <option value="titulo">Título</option>
        <option value="genero">Gênero</option>
        <option value="classificacao">Classificação</option>
    </select>
    <input type="text" name="valor" class="form-control" style="max-width:260px;"
           placeholder="Pesquisar..."
           value="<?= htmlspecialchars($_POST['valor'] ?? '') ?>">
    <button type="submit" name="buscar" class="btn btn-outline-light">
        <i class="fa-solid fa-magnifying-glass me-1"></i>Buscar
    </button>
    <a href="FilmeList.php" class="btn btn-outline-secondary">Limpar</a>
</form>

<div class="glass-effect p-0 overflow-hidden">
    <table class="table table-hover mb-0">
        <thead>
            <tr>
                <th>#</th>
                <th>Título</th>
                <th>Gênero</th>
                <th>Duração</th>
                <th>Classificação</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($filmes)): ?>
                <tr><td colspan="6" class="text-center text-muted py-4">Nenhum filme encontrado.</td></tr>
            <?php else: ?>
                <?php foreach ($filmes as $filme): ?>
                <tr>
                    <td class="text-muted small"><?= $filme->id ?></td>
                    <td><?= htmlspecialchars($filme->titulo) ?></td>
                    <td><?= htmlspecialchars($filme->genero) ?></td>
                    <td><?= htmlspecialchars($filme->duracao) ?></td>
                    <td><span class="badge bg-secondary"><?= htmlspecialchars($filme->classificacao) ?></span></td>
                    <td>
                        <a href="FilmeForm.php?id=<?= $filme->id ?>" class="btn btn-sm btn-outline-primary me-1">
                            <i class="fa-solid fa-pen-to-square"></i>
                        </a>
                        <a href="?delete=<?= $filme->id ?>"
                           class="btn btn-sm btn-outline-danger"
                           onclick="return confirm('Excluir o filme «<?= htmlspecialchars($filme->titulo) ?>»?')">
                            <i class="fa-solid fa-trash"></i>
                        </a>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php include '../footer.php'; ?>
