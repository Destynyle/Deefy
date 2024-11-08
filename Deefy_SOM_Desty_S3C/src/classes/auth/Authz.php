<?php
namespace iutnc\deefy\auth;

use iutnc\deefy\repository\DeefyRepository;

class Authz {

    public function checkRole($role): bool {
        if (isset($_SESSION['user'])) {
            // Correction : Utilisation de -> pour accéder à getRole()
            if ($_SESSION['user']->getRole() == $role) {
                return true;
            }
        }
        return false;
    }

    public function checkPlaylistOwner($id): bool {
        if (!isset($_SESSION['user'])) {
            return false;
        }
        
        $repo = DeefyRepository::getInstance();
        $userRoleActuelle = $repo->getUserRolefromId($_SESSION['user']->getId());

        // Si l'utilisateur est un administrateur (role 100), accès autorisé
        if ($userRoleActuelle == '100') {
            return true;
        }

        // Récupération de l'ID du propriétaire de la playlist
        $id_user = $repo->getUserIdFromPlaylist($id);
        if ($id_user == "-1") { // Si la playlist n'a pas de propriétaire
            return false;
        }

        // Comparaison de l'ID de l'utilisateur connecté et du propriétaire de la playlist
        if ($id_user == $_SESSION['user']->getId()) {
            return true;
        }
        
        return false;
    }
}
