<?php
$username = "siswa1";
$passwordPlain = "rahasia123"; // password asli
$hashedPassword = password_hash($passwordPlain, PASSWORD_BCRYPT);

echo "Username: $username <br>";
echo "Password asli: $passwordPlain <br>";
echo "Password hash: $hashedPassword";
