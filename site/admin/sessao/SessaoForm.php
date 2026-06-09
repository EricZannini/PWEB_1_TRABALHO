<?php
include '../header.php';
include '../autenticacao.php';
include_once '../database/db.class.php';

$db      = new db('sessoes');
$success = '';
$error   = '';
$errors  = [];
$data    = new stdClass();

if (!empty($_GET['id'])) {
    $data = $db->find((int) $_GET['id']);
}

if (!empty($_POST)) {
    $data = (object) $_POST;

    if (empty($_POST['sala']))
        $errors[] = '<li>Sala é obrigatória.</li>';
    if (empty($_POST['data_sessao']))
        $errors[] = '<li>Data é obrigatória.</li>';
    if (empty($_POST['hora_inicio']))
        $errors[] = '<li>Hora de início é obrigatória.</li>';
    if (!isset($_POST['preco']) || $_POST['preco'] === '')
        $errors[] = '<li>Preço é obrigatório.</li>';

    if (empty($errors)) {
        try {
            if (empty($_POST['id'])) {
                unset($_POST['id']);
                $db->store($_POST);
                $success = 'Sessão cadastrada com sucesso!';
            } else {
                $db->update($_POST);
                $success = 'Sessão atualizada com sucesso!';
            }
            redirect('SessaoList.php');
        } catch (Exception $e) {
            $error = $e->getMessage();
        }
    }
}
?>

<div class="d-flex align-items-center gap-3 mb-4">
    <a href="SessaoList.php" class="btn btn-outline-secondary btn-sm">
        <i class="fa-solid fa-arrow-left"></i>
    </a>
    <h4 class="fw-bold mb-0">
        <?= empty($data->id) ? 'Nova Sessão' : 'Editar Sessão' ?>
    </h4>
</div>

<div class="glass-effect p-4" style="max-width:600px;">

    <?php actionMessage($success, $error); showValidationError($errors); ?>

    <form method="POST">
        <input type="hidden" name="id" value="<?= getFormValue($data, 'id') ?>">

        <div class="mb-3">
            <label class="form-label">Sala <span class="text-danger">*</span></label>
            <input type="text" name="sala" class="form-control"
                   value="<?= getFormValue($data, 'sala') ?>"
                   placeholder="Ex: Sala 1, Sala VIP">
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Data <span class="text-danger">*</span></label>
                <input type="date" name="data_sessao" class="form-control"
                       value="<?= getFormValue($data, 'data_sessao') ?>">
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">Hora de Início <span class="text-danger">*</span></label>
                <input type="time" name="hora_inicio" class="form-control"
                       value="<?= getFormValue($data, 'hora_inicio') ?>">
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label">Preço (R$) <span class="text-danger">*</span></label>
            <input type="number" name="preco" step="0.01" min="0" class="form-control"
                   value="<?= getFormValue($data, 'preco') ?>"
                   placeholder="0.00">
        </div>

        <div class="d-flex gap-2 mt-2">
            <button type="submit" class="btn btn-danger">
                <i class="fa-solid fa-floppy-disk me-1"></i>Salvar
            </button>
            <a href="SessaoList.php" class="btn btn-outline-secondary">Cancelar</a>
        </div>
    </form>

</div>

<?php include '../footer.php'; ?>
