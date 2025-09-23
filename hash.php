<?php
$senha = 'MinhaSenhaForte123!';
echo password_hash($senha, PASSWORD_BCRYPT);
