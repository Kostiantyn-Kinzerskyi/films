<?php

namespace application\models;

use application\core\Model;

class Main extends Model {

	public function getFilms() {
		$result = $this->db->row('SELECT `films`.id, `films`.title, `films`.release_year, `films`.stars, `formats`.name AS format FROM films LEFT JOIN formats ON `films`.format = `formats`.id ORDER BY `films`.title');
		//
		return $result;
	}

	public function sortFilmsByYear() {
		$result = $this->db->row('SELECT `films`.id, `films`.title, `films`.release_year, `films`.stars, `formats`.name AS format FROM films LEFT JOIN formats ON `films`.format = `formats`.id ORDER BY `films`.release_year DESC');
		//
		return $result;
	}

	public function getFilmByName($film_name) 
	{
		$params = [
			'film_name' => $film_name,
		];
		return $this->db->row("SELECT `films`.id, `films`.title, `films`.release_year, `films`.stars, `formats`.name AS format FROM films LEFT JOIN formats ON `films`.format = `formats`.id WHERE `films`.title = :film_name", $params);
	}

	public function getFilmByID($film_id) 
	{
		$params = [
			'film_id' => $film_id,
		];
		return $this->db->row("SELECT `films`.id, `films`.title, `films`.release_year, `films`.stars, `formats`.name AS format FROM films LEFT JOIN formats ON `films`.format = `formats`.id WHERE `films`.id = :film_id", $params);
	}

	public function getFilmByActor($actor_name) 
	{
		$params = [
			'actor_name' => '%'.$actor_name.'%',
		];
		return $this->db->row("SELECT `films`.id, `films`.title, `films`.release_year, `films`.stars, `formats`.name AS format FROM films LEFT JOIN formats ON `films`.format = `formats`.id WHERE `films`.stars LIKE :actor_name", $params);
	}

	public function addFilm($film)
	{
		$params = [
			'title' => $film['film_name'],
			'release_year' => $film['year'],
			'format' => $film['format'],
			'stars' => $film['actors'],
		];
		$sql = "INSERT INTO films (title, release_year, format, stars)
		VALUES (:title, :release_year, :format, :stars)";
		$this->db->query($sql, $params);
	}

	public function delFilm($film_id) 
	{
		$params = [
			'film_id' => $film_id,
		];
		return $this->db->row("DELETE FROM films WHERE id = :film_id", $params);
	}

}