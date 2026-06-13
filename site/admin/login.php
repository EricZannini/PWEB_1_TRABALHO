<?php
$paginaAuth = true;
include 'header.php';
include_once 'database/db.class.php';

$error = '';

if (!empty($_POST)) {
    $login = trim($_POST['login'] ?? '');
    $senha = $_POST['senha'] ?? '';

    if (empty($login) || empty($senha)) {
        $error = 'Preencha login e senha.';
    } else {
        $db = new db('usuarios');
        $usuario = $db->findBy('login', $login);

        if ($usuario && password_verify($senha, $usuario->senha)) {
            $_SESSION['usuario_id'] = $usuario->id;
            $_SESSION['usuario_nome'] = $usuario->nome;
            $_SESSION['usuario_email'] = $usuario->email;
            header('Location: /PWEB_1_TRABALHO/site/admin/index.php');
            exit;
        } else {
            $error = 'Login ou senha inválidos.';
        }
    }
}
?>

<div class="d-flex justify-content-center align-items-center" style="min-height:70vh;">
    <div class="glass-effect p-5" style="width:100%;max-width:420px;">

        <div class="text-center mb-4">
            <i class="fa-solid fa-film fa-3x mb-3" style="color:#e63946"></i>
            <h3 class="fw-bold">TapCine Admin</h3>
            <p class="text-muted small">Acesso restrito a funcionários</p>
        </div>

        <?php if ($error): ?>
            <div class="alert alert-danger">
                <i class="fa-solid fa-triangle-exclamation me-2"></i><?= $error ?>
            </div>
        <?php endif; ?>

        <form method="POST">
            <div class="mb-3">
                <label class="form-label">Login</label>
                <div class="input-group">
                    <span class="input-group-text bg-transparent border-secondary">
                        <i class="fa-solid fa-user text-muted"></i>
                    </span>
                    <input type="text" name="login" class="form-control"
                           value="<?= htmlspecialchars($_POST['login'] ?? '') ?>"
                           placeholder="Digite seu login" autofocus>
                </div>
            </div>
            <div class="mb-4">
                <label class="form-label">Senha</label>
                <div class="input-group">
                    <span class="input-group-text bg-transparent border-secondary">
                        <i class="fa-solid fa-lock text-muted"></i>
                    </span>
                    <input type="password" name="senha" class="form-control" placeholder="••••••">
                </div>
            </div>
            <button type="submit" class="btn btn-danger w-100">
                <i class="fa-solid fa-right-to-bracket me-2"></i>Entrar
            </button>
        </form>

        <div class="text-center mt-3">
            <a href="registrar.php" class="text-muted small">Criar conta</a>
        </div>

    </div>
</div>

<?php include 'footer.php'; ?>
