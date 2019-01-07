<?php

namespace MP3\Model;


interface MP3Storage {

	public function read($id);

	public function readAll();
}

?>
