<?php

namespace MP3\Model;

use getID3;
/* Une classe de démo de l'architecture. Une vraie BD ne contiendrait
 * évidemment pas directement des instances de Poem, il faudrait
 * les construire lors de la lecture en BD. */
class MP3StorageStub implements MP3Storage {

	protected $db;

	public function __construct() {
	    $this->db = array();
	    $listPathMP3 = $this->readMP3();
        $getID3 = new getID3;
        $cpt = 1;
        for ($i = 0; $i < sizeof($listPathMP3); $i++ ){
            $mp3Metadata = $getID3->analyze('sons/'.$listPathMP3[$i]);
            if ( !key_exists("error",$mp3Metadata)){
                array_push($this->db, new MP3($cpt, $mp3Metadata['tags']['id3v2']['title'][0],
                    $mp3Metadata['tags']['id3v2']['album'][0],
                    $mp3Metadata['tags']['id3v2']['artist'][0],
                    "test"));
                $cpt++;
            }
        }
	}

	public function readMP3(){
        $path    = 'sons/';
        return array_values(array_diff(scandir($path), array('.', '..')));

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

