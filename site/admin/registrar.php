<?php
$paginaAuth = true;
include 'header.php';
include_once 'database/db.class.php';

$success = '';
$errors = [];
$data = new stdClass();

if (!empty($_POST)) {
    $data = (object) $_POST;

    if (empty($_POST['nome']))
        $errors[] = '<li>Nome é obrigatório.</li>';
    if (empty($_POST['email']))
        $errors[] = '<li>E-mail é obrigatório.</li>';
    if (empty($_POST['login']))
        $errors[] = '<li>Login é obrigatório.</li>';
    if (empty($_POST['senha']))
        $errors[] = '<li>Senha é obrigatória.</li>';

    if (empty($errors)) {
        $db = new db('usuarios');

        $existe = $db->findBy('login', $_POST['login']);
        if ($existe) {
            $errors[] = '<li>Este login já está em uso.</li>';
        } else {
            $db->store([
                'nome'     => $_POST['nome'],
                'telefone' => $_POST['telefone'] ?? '',
                'email'    => $_POST['email'],
                'login'    => $_POST['login'],
                'senha'    => password_hash($_POST['senha'], PASSWORD_DEFAULT),
            ]);
            $success = 'Usuário cadastrado com sucesso!';
            redirect('login.php');
        }
    }
}
?>

<div class="d-flex justify-content-center align-items-center" style="min-height:70vh;">
    <div class="glass-effect p-5" style="width:100%;max-width:480px;">

        <div class="text-center mb-4">
            <i class="fa-solid fa-user-plus fa-2x mb-2" style="color:#e63946"></i>
            <h4 class="fw-bold">Criar conta</h4>
        </div>

        <?php actionMessage($success); showValidationError($errors); ?>

        <form method="POST">
            <div class="mb-3">
                <label class="form-label">Nome completo</label>
                <input type="text" name="nome" class="form-control"
                       placeholder="Nome completo"
                       value="<?= getFormValue($data, 'nome') ?>">
            </div>
            <div class="mb-3">
                <label class="form-label">Telefone</label>
                <input type="text" name="telefone" class="form-control"
                       placeholder="Telefone de contato"
                       value="<?= getFormValue($data, 'telefone') ?>">
            </div>
            <div class="mb-3">
                <label class="form-label">E-mail</label>
                <input type="email" name="email" class="form-control"
                       placeholder="Endereço de e-mail"
                       value="<?= getFormValue($data, 'email') ?>">
            </div>
            <div class="mb-3">
                <label class="form-label">Login</label>
                <input type="text" name="login" class="form-control"
                       placeholder="Escolha um login"
                       value="<?= getFormValue($data, 'login') ?>">
            </div>
            <div class="mb-4">
                <label class="form-label">Senha</label>
                <input type="password" name="senha" class="form-control"
                       placeholder="Escolha uma senha">
            </div>
            <button type="submit" class="btn btn-danger w-100">Cadastrar</button>
            <a href="login.php" class="btn btn-outline-secondary w-100 mt-2">Voltar ao login</a>
        </form>

    </div>
</div>

<?php include 'footer.php'; ?>
