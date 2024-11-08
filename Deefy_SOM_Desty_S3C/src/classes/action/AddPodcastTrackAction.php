<?php
namespace iutnc\deefy\action;

use iutnc\deefy\audio\tracks\PodcastTrack;
use iutnc\deefy\render\AudioListRenderer;
use iutnc\deefy\repository\DeefyRepository;

class AddPodcastTrackAction extends Action {

    public function execute() : string {
        $html = " ";
        if (isset($_SESSION['user'])) {
            if (isset($_SESSION['playlist'])) {
                if ($this->http_method === 'GET') {
                    $html .= <<<END
                    <form action="?action=add-track" method="POST" enctype="multipart/form-data">
                        <label for="name">Nom:</label>
                        <input type="text" id="name" name="name" required>
                        
                        <label for="audioFile">Fichier audio (.mp3 uniquement):</label>
                        <input type="file" id="audioFile" name="audioFile" accept=".mp3" >
                        
                        <input type="submit" value="Ajouter la piste">
                    </form>
                    END;
    
                } else if ($this->http_method === 'POST') { 
                    $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
                    if (isset($_FILES['audioFile']) && $_FILES['audioFile']['error'] === UPLOAD_ERR_OK) {
                        $file = $_FILES['audioFile'];
                        $fileExtension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    
                        if ($fileExtension === 'mp3' && $file['type'] === 'audio/mpeg') {
                            $randomFileName = uniqid() . '.mp3';
                            $uploadDirectory = dirname(__DIR__, 3) . '/public/audio/';
                            $uploadFilePath = $uploadDirectory . $randomFileName;
    
                            //echo "Chemin d'upload : " . $uploadFilePath . "<br>";
    
                            if (!is_dir($uploadDirectory)) {
                                mkdir($uploadDirectory, 0777, true);
                            }
    
                            if (move_uploaded_file($file['tmp_name'], $uploadFilePath)) {
                               // echo "Fichier déplacé avec succès.<br>";
    
                                // Enregistrer la piste avec uniquement le nom de fichier
                                $track = new PodcastTrack($name, $randomFileName); // Stocker seulement le nom de fichier
                                $_SESSION['playlist']->ajdPiste($track);
    
                                $repo = DeefyRepository::getInstance();
                                $repo->saveTrack($track);
                                $repo->playlistLinkTrack($_SESSION['playlist'], $track);
                                
                                // Vérification de l'ID de playlist dans la session
                                if (!isset($_SESSION['playlistId']) || empty($_SESSION['playlistId'])) {
                                    echo "<p>Erreur : L'ID de la playlist en session est introuvable ou vide.</p>";
                                    return "<p>Erreur : Veuillez sélectionner une playlist avant d'ajouter des pistes.</p>";
                                }
                                
                                // Affichage de l'ID pour débogage
                                //echo "<p>ID de playlist en session : " . $_SESSION['playlistId'] . "</p>";
                                
                                // Récupération de la playlist
                                try {
                                    $_SESSION['playlist'] = $repo->findPlaylistTracksById($_SESSION['playlistId']);
                                } catch (\Exception $e) {
                                    echo "<p>Erreur lors de la récupération de la playlist : " . $e->getMessage() . "</p>";
                                    return "<p>Erreur : La playlist spécifiée est introuvable.</p>";
                                }
    
                                $playlistRenderer = new AudioListRenderer($_SESSION['playlist']);
                                $html .= <<<END
                                    <h1>Votre playlist</h1>
                                    {$playlistRenderer->render()}
                                    <a href="?action=add-track">Ajouter encore une piste</a>
                                END;
                            } else {
                                echo "Erreur lors du déplacement du fichier.<br>";
                                $html .= "<p>Erreur lors du téléchargement du fichier.</p>";
                            }
                        } else {
                            $html .= "<p>Le fichier doit être de type MP3.</p>";
                        }
                    }  
                }
            } else {
                $html .= <<<END
                <h1>Erreur</h1>
                <p>Vous devez d'abord avoir une playlist en session. Veuillez d'abord choisir la playlist où vous souhaitez ajouter une piste.</p>
                <a href="?action=display-all-playlist">Choisir une playlist</a>
                END;
            } 
        } else {
            $html .= <<<END
            <p>Veuillez vous connecter pour ajouter une piste.</p>
            <a href="?action=signin">Se connecter</a>
            END;
        }
            
        return $html;
    }
}
