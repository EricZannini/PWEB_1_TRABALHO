<?php
if (!isset($_SESSION['usuario_id'])) {
    header('Location: /PWEB_1_TRABALHO/site/admin/login.php');
    exit;
}
