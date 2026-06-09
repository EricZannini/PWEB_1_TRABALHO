<?php
include '../header.php';
include '../autenticacao.php';
include_once '../database/db.class.php';

$db = new db('usuarios');
$success = '';
$error = '';
$errors = [];
$data = new stdClass();
$editando = false;

if (!empty($_GET['id'])) {
    $data     = $db->find((int) $_GET['id']);
    $editando = true;
}

if (!empty($_POST)) {
    $data     = (object) $_POST;
    $editando = !empty($_POST['id']);

    if (empty($_POST['nome']))
        $errors[] = '<li>Nome é obrigatório.</li>';
    if (empty($_POST['email']))
        $errors[] = '<li>E-mail é obrigatório.</li>';
    if (empty($_POST['login']))
        $errors[] = '<li>Login é obrigatório.</li>';
    if (!$editando && empty($_POST['senha']))
        $errors[] = '<li>Senha é obrigatória.</li>';

    if (empty($errors)) {
        try {
            if (!$editando) {
                unset($_POST['id']);
                $_POST['senha'] = password_hash($_POST['senha'], PASSWORD_DEFAULT);
                $db->store($_POST);
                $success = 'Usuário cadastrado com sucesso!';
            } else {
                $dados = [
                    'id'       => $_POST['id'],
                    'nome'     => $_POST['nome'],
                    'telefone' => $_POST['telefone'] ?? '',
                    'email'    => $_POST['email'],
                    'login'    => $_POST['login'],
                ];
                if (!empty($_POST['senha'])) {
                    $dados['senha'] = password_hash($_POST['senha'], PASSWORD_DEFAULT);
                }
                $db->update($dados);
                $success = 'Usuário atualizado com sucesso!';
            }
            redirect('UsuarioList.php');
        } catch (Exception $e) {
            $error = $e->getMessage();
        }
    }
}
?>

<div class="d-flex align-items-center gap-3 mb-4">
    <a href="UsuarioList.php" class="btn btn-outline-secondary btn-sm">
        <i class="fa-solid fa-arrow-left"></i>
    </a>
    <h4 class="fw-bold mb-0">
        <?= $editando ? 'Editar Usuário' : 'Novo Usuário' ?>
    </h4>
</div>

<div class="glass-effect p-4" style="max-width:600px;">

    <?php actionMessage($success, $error); showValidationError($errors); ?>

    <form method="POST">
        <input type="hidden" name="id" value="<?= getFormValue($data, 'id') ?>">

        <div class="mb-3">
            <label class="form-label">Nome completo <span class="text-danger">*</span></label>
            <input type="text" name="nome" class="form-control"
                   value="<?= getFormValue($data, 'nome') ?>">
        </div>

        <div class="mb-3">
            <label class="form-label">Telefone</label>
            <input type="text" name="telefone" class="form-control"
                   value="<?= getFormValue($data, 'telefone') ?>"
                   placeholder="(49) 99999-0000">
        </div>

        <div class="mb-3">
            <label class="form-label">E-mail <span class="text-danger">*</span></label>
            <input type="email" name="email" class="form-control"
                   value="<?= getFormValue($data, 'email') ?>">
        </div>

        <div class="mb-3">
            <label class="form-label">Login <span class="text-danger">*</span></label>
            <input type="text" name="login" class="form-control"
                   value="<?= getFormValue($data, 'login') ?>">
        </div>

        <div class="mb-4">
            <label class="form-label">
                Senha <?= $editando ? '<span class="text-muted small">(deixe em branco para não alterar)</span>' : '<span class="text-danger">*</span>' ?>
            </label>
            <input type="password" name="senha" class="form-control">
        </div>

        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-danger">
                <i class="fa-solid fa-floppy-disk me-1"></i>Salvar
            </button>
            <a href="UsuarioList.php" class="btn btn-outline-secondary">Cancelar</a>
        </div>
    </form>

</div>

<?php include '../footer.php'; ?>
