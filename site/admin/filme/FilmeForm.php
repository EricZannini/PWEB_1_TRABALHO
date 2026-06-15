<?php
include '../header.php';
include '../autenticacao.php';
include_once '../database/db.class.php';

$db = new db('filmes');
$success = '';
$error = '';
$errors = [];
$data = new stdClass();

// novo ou edição
if (!empty($_GET['id'])) {
    $data = $db->find($_GET['id']);
}

if (!empty($_POST)) {
    $data = (object) $_POST;

    // valida
    if (empty($_POST['titulo']))
        $errors[] = '<li>Título é obrigatório.</li>';
    if (empty($_POST['genero']))
        $errors[] = '<li>Gênero é obrigatório.</li>';
    if (empty($_POST['duracao']))
        $errors[] = '<li>Duração é obrigatória.</li>';
    if (empty($_POST['classificacao']))
        $errors[] = '<li>Classificação é obrigatória.</li>';

    // salva ou atualiza
    if (empty($errors)) {
        try {
            if (empty($_POST['id'])) {
                unset($_POST['id']);
                $db->store($_POST);
                $success = 'Filme cadastrado com sucesso!';
            } else {
                $db->update($_POST);
                $success = 'Filme atualizado com sucesso!';
            }
            redirect('FilmeList.php');
        } catch (Exception $e) {
            $error = $e->getMessage();
        }
    }
}
?>

<div class="d-flex align-items-center gap-3 mb-4">
    <a href="FilmeList.php" class="btn btn-outline-secondary btn-sm">
        <i class="fa-solid fa-arrow-left"></i>
    </a>
    <h4 class="fw-bold mb-0">
        <?= empty($data->id) ? 'Novo Filme' : 'Editar Filme' ?>
    </h4>
</div>

<div class="glass-effect p-4" style="max-width:600px;">

    <?php actionMessage($success, $error); showValidationError($errors); ?>

    <form method="POST">
        <?php // id escondido — define se vai cadastrar ou editar ?>
        <input type="hidden" name="id" value="<?= getFormValue($data, 'id') ?>">

        <div class="mb-3">
            <label class="form-label">Título <span class="text-danger">*</span></label>
            <input type="text" name="titulo" class="form-control"
                   value="<?= getFormValue($data, 'titulo') ?>"
                   placeholder="Título do filme">
        </div>

        <div class="mb-3">
            <label class="form-label">Gênero <span class="text-danger">*</span></label>
            <input type="text" name="genero" class="form-control"
                   value="<?= getFormValue($data, 'genero') ?>"
                   placeholder="Gênero do filme">
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Duração <span class="text-danger">*</span></label>
                <input type="text" name="duracao" class="form-control"
                       value="<?= getFormValue($data, 'duracao') ?>"
                       placeholder="Duração">
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">Classificação <span class="text-danger">*</span></label>
                <select name="classificacao" class="form-select">
                    <option value="">Selecione...</option>
                    <?php foreach (['Livre','6+','10+','12+','14+','16+','18+'] as $c): ?>
                        <option value="<?= $c ?>"
                            <?= getFormValue($data, 'classificacao') === $c ? 'selected' : '' ?>>
                            <?= $c ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>

        <div class="d-flex gap-2 mt-2">
            <button type="submit" class="btn btn-danger">
                <i class="fa-solid fa-floppy-disk me-1"></i>Salvar
            </button>
            <a href="FilmeList.php" class="btn btn-outline-secondary">Cancelar</a>
        </div>
    </form>

</div>

<?php include '../footer.php'; ?>
