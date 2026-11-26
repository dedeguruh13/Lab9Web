<?php
// modules/auth/logout.php
unset($_SESSION['user_id'], $_SESSION['user_nama']);
session_regenerate_id(true);
setFlash('success', 'Anda telah logout.');
redirect('auth/login');
