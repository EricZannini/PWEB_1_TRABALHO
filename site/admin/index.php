<?php
include 'header.php';
include 'autenticacao.php';
include_once 'database/db.class.php';

$dbFilme = new db('filmes');
$dbSessao = new db('sessoes');
$dbIngresso = new db('ingressos');
$dbUsuario = new db('usuarios');

$totalFilmes = count($dbFilme->all());
$totalSessoes = count($dbSessao->all());
$totalIngressos = count($dbIngresso->all());
$totalUsuarios = count($dbUsuario->all());
?>

<h4 class="fw-bold mb-1">Dashboard</h4>
<p class="text-muted mb-4">Bem-vindo ao painel TapCine,
    <strong><?= htmlspecialchars($_SESSION['usuario_nome']) ?></strong></p>

<div class="row g-4 mb-5">

    <div class="col-sm-6 col-xl-3">
        <div class="glass-effect p-4 text-center h-100">
            <i class="fa-solid fa-clapperboard fa-2x mb-3" style="color:#e63946"></i>
            <h2 class="fw-bold"><?= $totalFilmes ?></h2>
            <p class="text-muted mb-3">Filmes</p>
            <a href="filme/FilmeList.php" class="btn btn-sm btn-danger">
                <i class="fa-solid fa-arrow-right me-1"></i>Gerenciar
            </a>
        </div>
    </div>

    <div class="col-sm-6 col-xl-3">
        <div class="glass-effect p-4 text-center h-100">
            <i class="fa-solid fa-calendar-days fa-2x mb-3" style="color:#4895ef"></i>
            <h2 class="fw-bold"><?= $totalSessoes ?></h2>
            <p class="text-muted mb-3">Sessões</p>
            <a href="sessao/SessaoList.php" class="btn btn-sm btn-outline-info">
                <i class="fa-solid fa-arrow-right me-1"></i>Gerenciar
            </a>
        </div>
    </div>

    <div class="col-sm-6 col-xl-3">
        <div class="glass-effect p-4 text-center h-100">
            <i class="fa-solid fa-ticket fa-2x mb-3" style="color:#4cc9f0"></i>
            <h2 class="fw-bold"><?= $totalIngressos ?></h2>
            <p class="text-muted mb-3">Ingressos</p>
            <a href="ingresso/IngressoList.php" class="btn btn-sm btn-outline-info">
                <i class="fa-solid fa-arrow-right me-1"></i>Gerenciar
            </a>
        </div>
    </div>

    <div class="col-sm-6 col-xl-3">
        <div class="glass-effect p-4 text-center h-100">
            <i class="fa-solid fa-users fa-2x mb-3" style="color:#6c757d"></i>
            <h2 class="fw-bold"><?= $totalUsuarios ?></h2>
            <p class="text-muted mb-3">Usuários</p>
            <a href="usuario/UsuarioList.php" class="btn btn-sm btn-outline-secondary">
                <i class="fa-solid fa-arrow-right me-1"></i>Gerenciar
            </a>
        </div>
    </div>

</div>

<h5 class="fw-semibold mb-3">Filmes em Cartaz</h5>
<div class="glass-effect p-0 overflow-hidden">
    <table class="table table-hover mb-0">
        <thead>
            <tr>
                <th>Título</th>
                <th>Gênero</th>
                <th>Duração</th>
                <th>Classificação</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($dbFilme->all() as $f): ?>
            <tr>
                <td><?= htmlspecialchars($f->titulo) ?></td>
                <td><?= htmlspecialchars($f->genero) ?></td>
                <td><?= htmlspecialchars($f->duracao) ?></td>
                <td><span class="badge bg-secondary"><?= htmlspecialchars($f->classificacao) ?></span></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php include 'footer.php'; ?>
