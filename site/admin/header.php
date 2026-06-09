<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function redirect($page, $time = 1500)
{
    echo "<script>setTimeout(() => { window.location.href = '$page'; }, $time);</script>";
}

function actionMessage($success = '', $actionError = '')
{
    if (!empty($success)) {
        echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                $success
                <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
              </div>";
    }
    if (!empty($actionError)) {
        echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                $actionError
                <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
              </div>";
    }
}

function showValidationError($errors = [])
{
    if (!empty($errors)) {
        echo "<div class='alert alert-danger'><ul class='mb-0'>";
        foreach ($errors as $error) {
            echo $error;
        }
        echo "</ul></div>";
    }
}

function getFormValue($data, $field)
{
    if (is_object($data) && isset($data->$field)) {
        return htmlspecialchars($data->$field);
    }
    if (is_array($data) && isset($data[$field])) {
        return htmlspecialchars($data[$field]);
    }
    return '';
}
?>
<!doctype html>
<html lang="pt-br" data-bs-theme="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>TapCine Admin</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background-image: url('/PWEB_1_TRABALHO/site/admin/img/background_cinema_blur.png');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
        }

        .glass-effect {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.05), rgba(255, 255, 255, 0));
            border: 1px solid rgba(255, 255, 255, 0.18);
            border-radius: 32px;
            -webkit-backdrop-filter: blur(20px);
            backdrop-filter: blur(20px);
            box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.37);
            padding: 20px;
            margin-top: 20px;
        }

        .btn-imagem {
            background: transparent;
            border: none;
            padding: 0;
            box-shadow: none;
        }

        .arredondado {
            border-radius: 32px;
        }

        .dropdown-menu .dropdown-item:hover,
        .dropdown-menu .dropdown-item:focus {
            background-color: rgba(255, 255, 255, 0.1);
            border-radius: 8px;
        }

        img {
            transition: transform 0.3s;
        }
        img:hover {
            transform: scale(1.05);
        }

        .table { --bs-table-bg: transparent; }
    </style>
</head>
<body>

<div class="container">

    <?php if (empty($paginaAuth)): ?>
    <header class="blog-header glass-effect">
        <div class="row d-flex justify-content align-items-center">

            <div class="col-4">
                <a class="link-secondary text-decoration-none" href="/PWEB_1_TRABALHO/site/admin/index.php">
                    <i class="fa-solid fa-film me-1"></i>
                    <strong><span style="color:#e63946">Tap</span>Cine</strong> Admin
                </a>
            </div>

            <div class="col-4 text-center">
                <?php if (isset($_SESSION['usuario_nome'])): ?>
                    <span class="text-white-50 small">
                        Olá, <?= htmlspecialchars($_SESSION['usuario_nome']) ?>
                    </span>
                <?php endif; ?>
            </div>

            <div class="col-4 text-end">
                <?php if (isset($_SESSION['usuario_id'])): ?>
                    <a class="btn btn-sm btn-outline-secondary glass-effect"
                       href="/PWEB_1_TRABALHO/site/admin/logout.php">
                        <i class="fa-solid fa-right-from-bracket me-1"></i>Sair
                    </a>
                <?php endif; ?>
            </div>

        </div>
    </header>
    <?php endif; ?>

    <?php if (isset($_SESSION['usuario_id'])): ?>
    <div class="nav-scroller py-1 mb-2">
        <nav class="nav flex justify-content-between">

            <a href="/PWEB_1_TRABALHO/site/admin/index.php"
               class="btn glass-effect text-white">
                <i class="fa-solid fa-gauge-high me-1"></i>Dashboard
            </a>

            <a href="/PWEB_1_TRABALHO/site/admin/filme/FilmeList.php"
               class="btn glass-effect text-white">
                <i class="fa-solid fa-clapperboard me-1"></i>Filmes
            </a>

            <a href="/PWEB_1_TRABALHO/site/admin/sessao/SessaoList.php"
               class="btn glass-effect text-white">
                <i class="fa-solid fa-calendar-days me-1"></i>Sessões
            </a>

            <a href="/PWEB_1_TRABALHO/site/admin/ingresso/IngressoList.php"
               class="btn glass-effect text-white">
                <i class="fa-solid fa-ticket me-1"></i>Ingressos
            </a>

            <a href="/PWEB_1_TRABALHO/site/admin/usuario/UsuarioList.php"
               class="btn glass-effect text-white">
                <i class="fa-solid fa-users me-1"></i>Usuários
            </a>

        </nav>
    </div>
    <?php endif; ?>

    <main>
