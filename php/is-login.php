<?php
require_once '../vendor/autoload.php';

use hypergo\user\User;

exit(json_encode(User::checkLogin()));
?>