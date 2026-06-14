<?php
// encerra a sessão
session_start();
session_destroy();
header('Location: /PWEB_1_TRABALHO/site/admin/login.php');
exit;
