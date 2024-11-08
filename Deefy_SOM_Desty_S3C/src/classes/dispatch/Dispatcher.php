<?php
namespace iutnc\deefy\dispatch;
use iutnc\deefy\action\DefaultAction;
use iutnc\deefy\action\DisplayPlaylistAction;
use iutnc\deefy\action\DisplayAllPlaylistAction;
use iutnc\deefy\action\AddPodcastTrackAction;
use iutnc\deefy\action\AddPlaylistAction;
use iutnc\deefy\action\AddUserAction;
use iutnc\deefy\action\SigninAction;
use iutnc\deefy\action\SignoutAction;

class Dispatcher {

    protected string $action;

    public function __construct() {
        $this->action = $_GET['action'] ?? 'default';
    }

    public function run(): void {
        session_start();
        switch($this->action) {
            case 'display-playlist':
                $action = new DisplayPlaylistAction();
                $html = $this->renderPage($action->execute());
                break;
            case 'display-all-playlist':
                $action = new DisplayAllPlaylistAction();
                $html = $this->renderPage($action->execute());
                break;
            case 'add-track':
                $action = new AddPodcastTrackAction();
                $html = $this->renderPage($action->execute());
                break;
            case 'add-playlist':
                $action = new AddPlaylistAction();
                $html = $this->renderPage($action->execute());
                break;
            case 'add-user':
                $action = new AddUserAction();
                $html = $this->renderPage($action->execute());
                break;
            case 'signin':
                $action = new SigninAction();
                $html = $this->renderPage($action->execute());
                break;
            case 'signout':
                $action = new SignoutAction();
                $html = $this->renderPage($action->execute());
                break;
            default:
                $action = new DefaultAction();
                $html = $this->renderPage($action->execute());
                break;
        }
    }

    private function renderPage(string $html): void {
        $playlistId = isset($_SESSION['playlistId']) ? htmlspecialchars($_SESSION['playlistId'], ENT_QUOTES, 'UTF-8') : '';
        
        echo <<<END
        <!DOCTYPE html>
        <html lang="fr">
            <head>
                <meta charset="UTF-8">
                <title>Deefy</title>
                <link rel="stylesheet" href="/Deefy_SOM_Desty_S3C/src/styles/style.css">
            </head>
            <body>
                <!-- Sidebar -->
                <div class="sidebar">
                    <h1>Deefy</h1>
                    <a href='?action=display-playlist&id={$playlistId}'>Voir playlist actuelle</a>
                    <a href='?action=add-track'>Ajouter track</a>
                    <a href='?action=add-playlist'>Ajouter playlist</a>
                    <a href='?action=display-all-playlist'>Voir toute playlist</a>
                    <a href='?action=add-user'>S'inscrire</a>
                    <a href='?action=signin'>Connexion</a>
                    <a href='?action=signout'>Déconnexion</a>
                </div>

                <!-- Main content area -->
                <div class="main-content">
                    $html
                </div>

                <!-- Footer player -->
                <div class="footer-player">
                    <div class="controls">
                        <button>&#9664;&#9664;</button>
                        <button>&#9654;</button>
                        <button>&#9654;&#9654;</button>
                    </div>
                    <div class="track-info">Lecture en cours : Titre - Artiste</div>
                </div>
                <!-- Copyright -->
            <footer style="text-align: center; padding: 10px; background-color: var(--background-light); color: var(--text-secondary);">
                &copy; 2024 Deefy made by SOM Desty. Tous droits réservés.
            </footer>
            </body>
        </html>
        END;
    }
}
?>
