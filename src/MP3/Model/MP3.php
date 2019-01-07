<?php

namespace MP3\Model;


class MP3
{

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
    protected $path;




	public function __construct($id, $title, $album, $artist, $duree,
								$dataFormat, $copyright,
								$date, $mimeType, $channelMode, $path) {
		$this->id = $id;
		$this->title = $title;
		$this->album = $album;
		$this->artist = $artist;
		$this->duree = $duree;
		$this->dataFormat = $dataFormat;
		$this->copyright = $copyright;
		$this->date = $date;
		$this->mimeType = $mimeType;
		$this->channelMode = $channelMode;
		$this->path = $path;

    }


    public function getPath()
    {
        return $this->path;
    }

    public function getId()
    {
        return $this->id;
    }


	public function getTitle() {
		return $this->title;
	}


	public function getAlbum() {
		return $this->album;
	}


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
