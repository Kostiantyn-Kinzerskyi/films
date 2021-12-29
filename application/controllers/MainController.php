<?php

namespace application\controllers;

use application\core\Controller;

class MainController extends Controller {

	public function indexAction() {
		$vars['init'] = 0;
		if (isset($_FILES['filename']))
		{
			$res = file_get_contents($_FILES['filename']['tmp_name']);
			$films = explode("\r\n\r\n\r\n", $res);
			$toinsert = [];
			$formats = [
				'DVD' => 1,
				'VHS' => 2,
				'Blu-ray' => 3,

			];
			foreach ($films as $key=>$val)
			{
				$film = explode("\r\n", $val);
				if (count($film) == 4)
				{
					$title = "";
					$year = "";
					$format = "";
					$actors = "";
					if (strpos($film[0], "Title: ") === 0)
					{
						$title = explode("Title: ", $film[0]);
						$title = end($title);
					}
					if (strpos($film[1], "Release Year: ") === 0)
					{
						$year = explode("Release Year: ", $film[1]);
						$year = end($year);
					}
					if (strpos($film[2], "Format: ") === 0)
					{
						$format = explode("Format: ", $film[2]);
						$format = end($format);
						$format = isset($formats[$format]) ? $formats[$format] : 1;
					}
					if (strpos($film[3], "Stars: ") === 0)
					{
						$actors = explode("Stars: ", $film[3]);
						$actors = end($actors);
					}
					if (!empty($title) && !empty($year) && !empty($format) && !empty($actors))
					{
						$toinsert[] = [
							'film_name' => $title,
							'year' => $year,
							'format' => $format,
							'actors' => $actors,
						];
					}
				}
			}
			foreach ($toinsert as $value) {
				$this->model->addFilm($value);
			}
		}
		if ($_POST)
		{
			//debug($_POST);
			if (isset($_POST['submit_more']))
				$this->view->redirect("/filminfo?film=".$_POST['submit_more']."");
			if (isset($_POST['submit_del']))
				$this->model->delFilm($_POST['submit_del']);
			if (isset($_POST['submit_add']))
				$this->model->addFilm($_POST);
			if (isset($_POST['sort_by']) && $_POST['sort_by'] != "")
			{
				if ($_POST['sort_by'] == 2)
					$vars['films'] = $this->model->sortFilmsByYear();
				if ($_POST['sort_by'] == 1)
					$vars['films'] = $this->model->getFilms();
			}
			if (isset($_POST['find_film']) && $_POST['find_film'] !="")
				$vars['films'] = $this->model->getFilmByName($_POST['find_film']);
			if (isset($_POST['find_film_actor']) && $_POST['find_film_actor'] !="")
				$vars['films'] = $this->model->getFilmByActor($_POST['find_film_actor']);
		}
		if (!isset($vars['films']))
			$vars['films'] = $this->model->getFilms();
		$this->view->render('Фильмы',  $vars);
	}

	public function filminfoAction()
	{
		$vars['init'] = 0;
	//	var_dump($_GET['film']);
		$vars['film'] = $this->model->getFilmByID($_GET['film']);
	//	debug($vars['film']);
		$this->view->render('Описание фильма',  $vars);
	}

}