<?php

namespace application\models;

use application\core\Model;

class Main extends Model {

	public function getFilms($param, $filter) {
		$where = "";
		$sort = "";
		if ($param == 1 || $param == 2)
			$sort = "";
		if ($param == 4 || $param == 3)
			$sort = "DESC";
		$params = [];
		if (isset($filter['find_film']))
		{
			$where .= " AND `films`.title LIKE :film_name";
			$params['film_name'] = '%'.$filter['find_film'].'%';
		}
		if (isset($filter['find_film_actor']))
		{
			$where .= " AND `films`.stars LIKE :actor_name";
			$params['actor_name'] = '%'.$filter['find_film_actor'].'%';
		}

		$order = ($param == 1 || $param == 4) ? "`films`.title COLLATE utf8_unicode_ci" : "`films`.release_year";

		$limit = 10;
		$offset = 0;

		if (isset($_GET['page']))
		{
			$pages = $this->countFilms($filter);
			if ($_GET['page'] < 1)
				$_GET['page'] = 1;
			if ($_GET['page'] > ceil($pages / $limit))
				$_GET['page'] = ceil($pages / $limit);
			$offset = ($limit * $_GET['page']) - $limit;
		}

		$result = $this->db->row('SELECT `films`.id, `films`.title, `films`.release_year, `films`.stars, `formats`.name AS format FROM films LEFT JOIN formats ON `films`.format = `formats`.id WHERE 1 = 1 '.$where.' ORDER BY '.$order.' '.$sort.' LIMIT '.$limit.' OFFSET '.$offset.'', $params);
		//
		return $result;
	}

	public function countFilms($filter) 
	{
		$where = "";
		$params = [];
		if (isset($filter['find_film']))
		{
			$where .= " AND `films`.title LIKE :film_name";
			$params['film_name'] = '%'.$filter['find_film'].'%';
		}
		if (isset($filter['find_film_actor']))
		{
			$where .= " AND `films`.stars LIKE :actor_name";
			$params['actor_name'] = '%'.$filter['find_film_actor'].'%';
		}

		return $this->db->column('SELECT COUNT(1) FROM films WHERE 1 = 1 '.$where, $params);
	}

	public function getFilmByName($film_name) 
	{
		$params = [
			'film_name' => '%'.$film_name.'%',
		];
		return $this->db->row("SELECT `films`.id, `films`.title, `films`.release_year, `films`.stars, `formats`.name AS format FROM films LEFT JOIN formats ON `films`.format = `formats`.id WHERE `films`.title LIKE :film_name", $params);
	}

	public function getFilmByID($film_id) 
	{
		$params = [
			'film_id' => $film_id,
		];
		return $this->db->row("SELECT `films`.id, `films`.title, `films`.release_year, `films`.stars, `formats`.name AS format FROM films LEFT JOIN formats ON `films`.format = `formats`.id WHERE `films`.id = :film_id", $params);
	}

	public function addFilm($film)
	{
		$checkfilm = $this->getFilmByName($film['film_name']);
		
		if (!empty($checkfilm))
			foreach ($checkfilm as $val)
				if ($val['release_year'] == $film['year'] && $val['stars'] == $film['actors'])
					return 0;
		
		if (!preg_match("/^[а-яА-ЯёЁіІїЇєЄ'a-zA-Z0-9\-, ]+$/u", $film['actors']))
			return 0;
		$params = [
			'title' => $film['film_name'],
			'release_year' => $film['year'],
			'format' => $film['format'],
			'stars' => $film['actors'],
		];
		$sql = "INSERT INTO films (title, release_year, format, stars)
		VALUES (:title, :release_year, :format, :stars)";
		$this->db->query($sql, $params);
		return 1;
	}

	public function delFilm($film_id) 
	{
		$params = [
			'film_id' => $film_id,
		];
		return $this->db->row("DELETE FROM films WHERE id = :film_id", $params);
	}

}