<?php

namespace MP3\Model;

/* Une classe de démo de l'architecture. Une vraie BD ne contiendrait
 * évidemment pas directement des instances de Poem, il faudrait
 * les construire lors de la lecture en BD. */
class MP3StorageStub implements MP3Storage {

	protected $db;

	/* Construit une instance avec 4 poèmes. */
	public function __construct() {
		$this->db = array(

		);
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

