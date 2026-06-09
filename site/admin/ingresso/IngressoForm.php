<?php
include '../header.php';
include '../autenticacao.php';
include_once '../database/db.class.php';

$db      = new db('ingressos');
$success = '';
$error   = '';
$errors  = [];
$data    = new stdClass();

if (!empty($_GET['id'])) {
    $data = $db->find((int) $_GET['id']);
}

if (!empty($_POST)) {
    $data = (object) $_POST;

    if (empty($_POST['cliente_nome']))
        $errors[] = '<li>Nome do cliente é obrigatório.</li>';
    if (empty($_POST['assento']))
        $errors[] = '<li>Assento é obrigatório.</li>';
    if (empty($_POST['tipo_ingresso']))
        $errors[] = '<li>Tipo de ingresso é obrigatório.</li>';

    if (empty($errors)) {
        try {
            if (empty($_POST['id'])) {
                unset($_POST['id']);
                $db->store($_POST);
                $success = 'Ingresso cadastrado com sucesso!';
            } else {
                $db->update($_POST);
                $success = 'Ingresso atualizado com sucesso!';
            }
            redirect('IngressoList.php');
        } catch (Exception $e) {
            $error = $e->getMessage();
        }
    }
}
?>

<div class="d-flex align-items-center gap-3 mb-4">
    <a href="IngressoList.php" class="btn btn-outline-secondary btn-sm">
        <i class="fa-solid fa-arrow-left"></i>
    </a>
    <h4 class="fw-bold mb-0">
        <?= empty($data->id) ? 'Novo Ingresso' : 'Editar Ingresso' ?>
    </h4>
</div>

<div class="glass-effect p-4" style="max-width:600px;">

    <?php actionMessage($success, $error); showValidationError($errors); ?>

    <form method="POST">
        <input type="hidden" name="id" value="<?= getFormValue($data, 'id') ?>">

        <div class="mb-3">
            <label class="form-label">Nome do Cliente <span class="text-danger">*</span></label>
            <input type="text" name="cliente_nome" class="form-control"
                   value="<?= getFormValue($data, 'cliente_nome') ?>"
                   placeholder="Nome completo">
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Assento <span class="text-danger">*</span></label>
                <input type="text" name="assento" class="form-control"
                       value="<?= getFormValue($data, 'assento') ?>"
                       placeholder="Ex: A1, B5, C12">
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">Tipo de Ingresso <span class="text-danger">*</span></label>
                <select name="tipo_ingresso" class="form-select">
                    <option value="">Selecione...</option>
                    <?php foreach (['Inteira', 'Meia', 'Gratuidade', 'VIP'] as $tipo): ?>
                        <option value="<?= $tipo ?>"
                            <?= getFormValue($data, 'tipo_ingresso') === $tipo ? 'selected' : '' ?>>
                            <?= $tipo ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>

        <div class="d-flex gap-2 mt-2">
            <button type="submit" class="btn btn-danger">
                <i class="fa-solid fa-floppy-disk me-1"></i>Salvar
            </button>
            <a href="IngressoList.php" class="btn btn-outline-secondary">Cancelar</a>
        </div>
    </form>

</div>

<?php include '../footer.php'; ?>
