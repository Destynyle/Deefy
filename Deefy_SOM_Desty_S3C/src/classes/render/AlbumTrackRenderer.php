<?php
namespace iutnc\deefy\render;

use \iutnc\deefy\audio\tracks\AlbumTrack;

class AlbumTrackRenderer extends AudioTrackRenderer {

    public function __construct(AlbumTrack $altr) {
        parent::__construct($altr); // Appel du constructeur parent avec l'instance AlbumTrack
    }

    protected function renderLong(): String {
        $audioPath = "http://localhost/Deefy_SOM_Desty_S3C/public/audio/" . rawurlencode($this->at->nomFichierAudio);
        return "Titre: " . $this->at->titre . "<br>Artiste: "
            . $this->at->artiste . "<br>Album: " . $this->at->album
            . "<br>Genre: " . $this->at->genre
            . "<br>Durée: " . $this->at->duree
            . "<br>Année de sortie: " . $this->at->date
            . "<br>Numéro de piste: " . $this->at->numPiste
            . "<br><audio controls src='$audioPath'></audio><br>";
    }

    protected function renderCompact(): String {
        $audioPath = "http://localhost/Deefy_SOM_Desty_S3C/public/audio/" . rawurlencode($this->at->nomFichierAudio);
        return "Titre: " . $this->at->titre . "<br>Artiste: "
            . $this->at->artiste . "<br>Album: " . $this->at->album
            . "<br>Durée: " . $this->at->duree
            . "<br><audio controls src='$audioPath'></audio><br>";
    }
}
