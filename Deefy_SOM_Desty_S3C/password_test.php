<?php
$password = 'motdepassenouveau';
$hashFromDb = '$2y$10$WJC6axcjv46w62WkWyW5Vu/Jvkmv23/QCEYWyDtm.FycHJZ8fzbcK';

if (password_hash($password, PASSWORD_BCRYPT) === $hashFromDb) {
    echo "Le mot de passe correspond.";
} else {
    echo "Le mot de passe ne correspond toujours pas.";
}
