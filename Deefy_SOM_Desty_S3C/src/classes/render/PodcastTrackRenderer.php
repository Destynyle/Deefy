<?php
/*EXERCICE 3*/
namespace iutnc\deefy\render;

use \iutnc\deefy\audio\tracks\PodcastTrack;

class PodcastTrackRenderer extends AudioTrackRenderer {

    public function __construct(PodcastTrack $altr) {
        parent::__construct($altr); // Utilise le constructeur parent pour initialiser $at
    }

    protected function renderLong(): String {
        $audioPath = "http://localhost/Deefy_SOM_Desty_S3C/public/audio/" . rawurlencode($this->at->nomFichierAudio);
        //echo "<p>URL audio pour débogage (renderLong) : $audioPath</p>"; // Debugging line
        return "Titre: " . $this->at->titre . "<br>Auteur: "
            . $this->at->auteur
            . "<br>Genre: " . $this->at->genre 
            . "<br>Durée: " . $this->at->duree 
            . "<br>Année de sortie: " . $this->at->date
            . "<br><audio controls src='$audioPath'></audio><br>";
    }
    
    protected function renderCompact(): String {
        $audioPath = "http://localhost/Deefy_SOM_Desty_S3C/public/audio/" . rawurlencode($this->at->nomFichierAudio);
       // echo "<p>URL audio pour débogage (renderCompact) : $audioPath</p>"; // Debugging line
        return "Titre: " . $this->at->titre . "<br>Auteur: "
            . $this->at->auteur 
            . "<br><audio controls src='$audioPath'></audio><br>";
    }
    
}
