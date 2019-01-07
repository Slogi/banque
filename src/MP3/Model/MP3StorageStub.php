<?php

namespace MP3\Model;

use getID3;

class MP3StorageStub implements MP3Storage {

    protected $db;

    public function __construct()
    {
        $this->db = array();
        $listPathMP3 = $this->readMP3();
        $getID3 = new getID3;
        $cpt = 0;
        $title = null;
        $album = null;
        $artist = null;
        $duree = null;
        $dataFormat = null;
        $copyright = null;
        $date = null;
        $mimeType = null;
        $channelMode = null;
        $path = "";

        for ($i = 0; $i < sizeof($listPathMP3); $i++ ){
            $path = "sons/$listPathMP3[$i]";
            $mp3Metadata = $getID3->analyze('sons/'.$listPathMP3[$i]);
            if (!key_exists("error", $mp3Metadata)) {

                if(array_key_exists('title', $mp3Metadata['tags']['id3v2']) && $mp3Metadata['tags']['id3v2']['title'][0] != null) {
                    $title = $mp3Metadata['tags']['id3v2']['title'][0];
                }
                if(array_key_exists('album', $mp3Metadata['tags']['id3v2']) && $mp3Metadata['tags']['id3v2']['album'][0] != null) {
                    $album =  $mp3Metadata['tags']['id3v2']['album'][0];
                }
                if(array_key_exists('artist', $mp3Metadata['tags']['id3v2']) && $mp3Metadata['tags']['id3v2']['artist'][0] != null) {
                    $artist =  $mp3Metadata['tags']['id3v2']['artist'][0];
                }
                if(array_key_exists('playtime_string', $mp3Metadata) && $mp3Metadata['playtime_string'] != null) {
                    $duree =  $mp3Metadata['playtime_string'];
                }
                if(array_key_exists('dataformat', $mp3Metadata['audio']) && $mp3Metadata['audio']['dataformat'] != null) {
                    $dataFormat =  $mp3Metadata['audio']['dataformat'];
                }
                if(array_key_exists('copyright_message', $mp3Metadata['tags']['id3v2']) && $mp3Metadata['tags']['id3v2']['copyright_message'][0] != null) {
                    $copyright =  $mp3Metadata['tags']['id3v2']['copyright_message'][0];
                }
                if(array_key_exists('date', $mp3Metadata['tags']['id3v2']) && $mp3Metadata['tags']['id3v2']['date'][0] != null) {
                    $date =  $mp3Metadata['tags']['id3v2']['date'][0];
                }
                if(array_key_exists('mime_type', $mp3Metadata) && $mp3Metadata['mime_type'] != null) {
                    $mimeType =  $mp3Metadata['mime_type'];
                }
                if(array_key_exists('channelmode', $mp3Metadata['audio']) && $mp3Metadata['audio']['channelmode'] != null) {
                    $channelMode =  $mp3Metadata['audio']['channelmode'];
                }
                array_push(
                    $this->db,
                    new MP3(
                        $cpt, $title, $album, $artist, $duree,
                        $dataFormat, $copyright, $date, $mimeType, $channelMode, $path
                    )
                );
                $cpt++;
            }
        }
	}

    public function readMP3()
    {
        $path    = 'sons/';
        return array_values(array_diff(scandir($path), array('.', '..')));

    }

    public function read($id)
    {
        if (key_exists($id, $this->db)) {
            return $this->db[$id];
        }
        return null;
    }

    public function readAll()
    {
        return $this->db;
    }
}

