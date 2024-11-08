<?php
namespace iutnc\deefy\render;

use \iutnc\deefy\audio\lists\AudioList;
use \iutnc\deefy\audio\tracks\PodcastTrack;
use \iutnc\deefy\audio\tracks\AlbumTrack;

class AudioListRenderer implements Renderer {
    protected AudioList $audioList;

    public function __construct(AudioList $audioList) {
        $this->audioList = $audioList;
    }

    public function render(String $selector = Renderer::COMPACT): String {
        $str = "<div class='audio-list'>";
        $str .= "<h2>Nom de la liste: " . htmlspecialchars($this->audioList->nom) . "</h2><br>";

        foreach ($this->audioList->listePistes as $piste) {
            if ($piste instanceof PodcastTrack) {
                $audiorender = new PodcastTrackRenderer($piste);
            } else {
                $audiorender = new AlbumTrackRenderer($piste);
            }
            $str .= $audiorender->render($selector) . "<br>";
        }

        $str .= "<p>Durée totale: " . htmlspecialchars($this->audioList->dureeTotale) . "</p>";
        $str .= "<p>Nombre de pistes: " . htmlspecialchars($this->audioList->nbPistes) . "</p>";
        $str .= "</div>";

        return $str;
    }
}
