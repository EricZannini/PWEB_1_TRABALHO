<?php
include '../header.php';
include '../autenticacao.php';
include_once '../database/db.class.php';

$db = new db('sessoes');

if (!empty($_GET['delete'])) {
    $db->destroy((int) $_GET['delete']);
    $msgDelete = 'Sessão excluída com sucesso!';
}

$sessoes = $db->all();

if (!empty($_POST['buscar'])) {
    $sessoes = $db->search(['tipo' => $_POST['tipo'], 'valor' => $_POST['valor']]);
}
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0"><i class="fa-solid fa-calendar-days me-2" style="color:#4895ef"></i>Sessões</h4>
    <a href="SessaoForm.php" class="btn btn-danger">
        <i class="fa-solid fa-plus me-1"></i>Nova Sessão
    </a>
</div>

<?php if (!empty($msgDelete)): ?>
    <div class="alert alert-success"><?= $msgDelete ?></div>
<?php endif; ?>

<form method="POST" class="glass-effect p-3 mb-4 d-flex gap-2 flex-wrap">
    <select name="tipo" class="form-select" style="max-width:180px;">
        <option value="sala">Sala</option>
        <option value="data_sessao">Data</option>
    </select>
    <input type="text" name="valor" class="form-control" style="max-width:260px;"
           placeholder="Pesquisar..."
           value="<?= htmlspecialchars($_POST['valor'] ?? '') ?>">
    <button type="submit" name="buscar" class="btn btn-outline-light">
        <i class="fa-solid fa-magnifying-glass me-1"></i>Buscar
    </button>
    <a href="SessaoList.php" class="btn btn-outline-secondary">Limpar</a>
</form>

<div class="glass-effect p-0 overflow-hidden">
    <table class="table table-hover mb-0">
        <thead>
            <tr>
                <th>#</th>
                <th>Sala</th>
                <th>Data</th>
                <th>Hora</th>
                <th>Preço</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($sessoes)): ?>
                <tr><td colspan="6" class="text-center text-muted py-4">Nenhuma sessão encontrada.</td></tr>
            <?php else: ?>
                <?php foreach ($sessoes as $sessao): ?>
                <tr>
                    <td class="text-muted small"><?= $sessao->id ?></td>
                    <td><?= htmlspecialchars($sessao->sala) ?></td>
                    <td><?= date('d/m/Y', strtotime($sessao->data_sessao)) ?></td>
                    <td><?= substr($sessao->hora_inicio, 0, 5) ?></td>
                    <td>R$ <?= number_format($sessao->preco, 2, ',', '.') ?></td>
                    <td>
                        <a href="SessaoForm.php?id=<?= $sessao->id ?>" class="btn btn-sm btn-outline-primary me-1">
                            <i class="fa-solid fa-pen-to-square"></i>
                        </a>
                        <a href="?delete=<?= $sessao->id ?>"
                           class="btn btn-sm btn-outline-danger"
                           onclick="return confirm('Excluir esta sessão?')">
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
