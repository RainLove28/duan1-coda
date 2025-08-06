<?php
session_start();
session_destroy();
header('Location: simple_login.php?message=logout_success');
exit;
?>
