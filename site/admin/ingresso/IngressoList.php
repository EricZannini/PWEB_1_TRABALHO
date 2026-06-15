<?php
include '../header.php';
include '../autenticacao.php';
include_once '../database/db.class.php';

$db = new db('ingressos');

// deleta
if (!empty($_GET['delete'])) {
    $db->destroy($_GET['delete']);
    $msgDelete = 'Ingresso excluído com sucesso!';
}

// pega tudo
$ingressos = $db->all();

// pesquisa
if (!empty($_POST['buscar'])) {
    $ingressos = $db->search(['tipo' => $_POST['tipo'], 'valor' => $_POST['valor']]);
}
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0"><i class="fa-solid fa-ticket me-2" style="color:#4cc9f0"></i>Ingressos</h4>
    <a href="IngressoForm.php" class="btn btn-danger">
        <i class="fa-solid fa-plus me-1"></i>Novo Ingresso
    </a>
</div>

<?php if (!empty($msgDelete)): ?>
    <div class="alert alert-success"><?= $msgDelete ?></div>
<?php endif; ?>

<form method="POST" class="glass-effect p-3 mb-4 d-flex gap-2 flex-wrap">
    <select name="tipo" class="form-select" style="max-width:200px;">
        <option value="cliente_nome">Nome do Cliente</option>
        <option value="assento">Assento</option>
        <option value="tipo_ingresso">Tipo</option>
    </select>
    <input type="text" name="valor" class="form-control" style="max-width:260px;"
           placeholder="Pesquisar..."
           value="<?= $_POST['valor'] ?? '' ?>">
    <button type="submit" name="buscar" class="btn btn-outline-light">
        <i class="fa-solid fa-magnifying-glass me-1"></i>Buscar
    </button>
    <a href="IngressoList.php" class="btn btn-outline-secondary">Limpar</a>
</form>

<div class="glass-effect p-0 overflow-hidden">
    <table class="table table-hover mb-0">
        <thead>
            <tr>
                <th>#</th>
                <th>Cliente</th>
                <th>Assento</th>
                <th>Tipo</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($ingressos)): ?>
                <tr><td colspan="5" class="text-center text-muted py-4">Nenhum ingresso encontrado.</td></tr>
            <?php else: ?>
                <?php // mostra cada linha na tabela ?>
                <?php foreach ($ingressos as $ingresso): ?>
                <tr>
                    <td class="text-muted small"><?= $ingresso->id ?></td>
                    <td><?= $ingresso->cliente_nome ?></td>
                    <td><span class="badge bg-secondary"><?= $ingresso->assento ?></span></td>
                    <td><?= $ingresso->tipo_ingresso ?></td>
                    <td>
                        <a href="IngressoForm.php?id=<?= $ingresso->id ?>" class="btn btn-sm btn-outline-primary me-1">
                            <i class="fa-solid fa-pen-to-square"></i>
                        </a>
                        <a href="?delete=<?= $ingresso->id ?>"
                           class="btn btn-sm btn-outline-danger"
                           onclick="return confirm('Deseja excluir este ingresso?')">
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
