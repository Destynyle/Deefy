<?php

namespace iutnc\deefy\auth;

use iutnc\deefy\exception\AuthException;
use iutnc\deefy\repository\DeefyRepository;

class AuthnProvider {
    public static function signin(String $email, String $password): void {
        $repo = DeefyRepository::getInstance();
        $user = $repo->getUserFromEmail($email);
    
        if (is_null($user)) {
            throw new AuthException("utilisateur inconnu");
        }
    
        // Debugging output to check values.
        //echo "Mot de passe en texte clair : '$password'<br>";
        //echo "Hachage en base de données : '" . $user->getHash() . "'<br>";
        //echo "Longueur du hachage récupéré de la base : " . strlen($user->getHash()) . "<br>";

        //echo "Vérification directe de l'égalité (hachage - mot de passe): " . ($password === $user->getHash() ? 'Égalité' : 'Pas d\'égalité') . "<br>";
        //echo "Hachage généré à partir du mot de passe en texte clair : " . password_hash($password, PASSWORD_DEFAULT) . "<br>";

        // Vérification avec password_verify
        if (!password_verify($password, $user->getHash())) {
            throw new AuthException("mot de passe incorrect");
        }
    
        $_SESSION['user'] = $user;
    }
    
    

    public static function register(String $email, String $password): void {
        $repo = DeefyRepository::getInstance();
        $length = (strlen($password) <= 10);
        $user = $repo->getUserFromEmail($email);
    
        if (!is_null($user)) {
            throw new AuthException("Email existe déjà");
        } else if ($length) {
            throw new AuthException("Le mot de passe doit contenir au moins 10 caractères");
        } else {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            if ($hash === false) {
                throw new \Exception("Erreur lors de la génération du hachage du mot de passe");
            }
            $repo->insertUser($email, $hash);
        }
    }
    
    
}