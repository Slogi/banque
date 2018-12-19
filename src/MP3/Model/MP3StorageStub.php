<?php

namespace MP3\Model;

/* Une classe de démo de l'architecture. Une vraie BD ne contiendrait
 * évidemment pas directement des instances de Poem, il faudrait
 * les construire lors de la lecture en BD. */
class MP3StorageStub implements MP3Storage {

	protected $db;

	public function __construct() {
	    $this->db = array();
	    $listPathMP3 = $this->readMP3();
		for ($i = 0; $i < sizeof($listPathMP3); $i++ ){
            $mp3Metadata = id3_get_tag($listPathMP3[$i]);
            array_push($this->db, new MP3($mp3Metadata['title'], $mp3Metadata['album'], $mp3Metadata['artist'],"test"));
        }
	}

	public function readMP3(){
	    //TODO changer le path pour que le dossier sons soit à la racine
        $path    = 'sons/';
        return array_diff(scandir($path), array('.', '..'));

    }

	public function read($id) {
		if (key_exists($id, $this->db)) {
			return $this->db[$id];
		}
		return null;
	}

	public function readAll() {
		return $this->db;
	}
}

