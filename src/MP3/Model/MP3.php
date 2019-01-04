<?php

namespace MP3\Model;


class MP3 {

	protected $id;
	protected $title;
	protected $album;
	protected $artist;
	protected $duree;

	protected $dataFormat;
	protected $copyright;
	protected $date;
	protected $mimeType;
	protected $channelMode;




	public function __construct($id, $title, $album, $artist, $duree,
								$dataFormat, $copyright,
								$date, $mimeType, $channelMode) {
		$this->id = $id;
		$this->title = $title;
		$this->album = $album;
		$this->artist = $artist;
		$this->duree = $duree;
		$this->dataFormat = $dataFormat;
		//$this->text = file_get_contents("texts/{$textFile}.frg.html", true);
		$this->copyright = $copyright;
		$this->date = $date;
		$this->mimeType = $mimeType;
		$this->channelMode = $channelMode;
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

	public function getDataFormat()
	{
		return $this->dataFormat;
	}

	public function getDuree()
	{
		return $this->duree;
	}

	public function getCopyright()
	{
		return $this->copyright;
	}

	public function getDate()
	{
		return $this->date;
	}

	public function getMimeType()
	{
		return $this->mimeType;
	}

	public function getChannelMode()
	{
		return $this->channelMode;
	}
}

?>
