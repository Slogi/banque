<?php

namespace MP3\Model;


class MP3 {

	protected $id;
	protected $title;
	protected $album;
	protected $artist;
	protected $duree;

	public function __construct($id, $title, $album, $artist, $duree) {
		$this->id = $id;
		$this->title = $title;
		$this->album = $album;
		$this->artist = $artist;
		$this->duree = $duree;
		//$this->text = file_get_contents("texts/{$textFile}.frg.html", true);
	}

    public function getId(){
        return $this->id;
    }

	/* Renvoie le titre du poème */
	public function getTitle() {
		return $this->title;
	}

	/* Renvoie le nom du fichier contenant le portrait de l'auteur */
	public function getAlbum() {
		return $this->album;
	}

	/* Renvoie le nom de l'auteur */
	public function getArtist() {
		return $this->artist;
	}
}

?>
