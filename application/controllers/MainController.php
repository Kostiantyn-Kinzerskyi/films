<?php

namespace application\controllers;

use application\core\Controller;

class MainController extends Controller {

	public function indexAction() {
		$vars['init'] = 0;
		$filters = [];
		$sort = 1;
		if (isset($_FILES['filename']) && isset($_FILES['filename']['tmp_name']) && !empty($_FILES['filename']['tmp_name']))
		{
			if (isset($_FILES['filename']['name']) && substr($_FILES['filename']['name'], -4) == ".txt" && isset($_FILES['filename']['type']) && $_FILES['filename']['type'] == "text/plain")
			{
				$res = file_get_contents($_FILES['filename']['tmp_name']);
				$films = explode("\r\n\r\n\r\n", $res);
				$toinsert = [];
				$vars['error'] = 0;
				$vars['success'] = 0;
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
							$title = trim(end($title));
						}
						if (strpos($film[1], "Release Year: ") === 0)
						{
							$year = explode("Release Year: ", $film[1]);
							$year = trim(end($year));
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
					$add = $this->model->addFilm($value) ? $vars['success']++ : $vars['error']++;
				}
			}
			else
				$vars['success'] = 0;
			
		//	debug($vars['success']);
		}
		if ($_POST)
		{
			if (isset($_POST['submit_more']))
				$this->view->redirect("/filminfo?film=".$_POST['submit_more']."");
			if (isset($_POST['submit_del']))
				$this->model->delFilm($_POST['submit_del']);
			if (isset($_POST['submit_add']) && !empty(trim($_POST['film_name'])) && !empty(trim($_POST['actors'])))
				$link = $this->model->addFilm($_POST) ? $this->view->redirect("/?status=success") : $this->view->redirect("/?status=failed");
		}

		if ($_GET)
		{
			if (isset($_GET['find_film']) && $_GET['find_film'] !="")
			{
				$filters['find_film'] = $_GET['find_film'];
			}
			if (isset($_GET['find_film_actor']) && $_GET['find_film_actor'] !="")
			{
				$filters['find_film_actor'] = $_GET['find_film_actor'];
			}
			if (isset($_GET['sort_by']) && $_GET['sort_by'] != "")
				$sort = $_GET['sort_by'];
		}
		
		$vars['films'] = $this->model->getFilms($sort, $filters);
		$vars['pages'] = max(ceil($this->model->countFilms($filters) / 10), 1);

		//debug($vars['pages']);

		$this->view->render('Фильмы',  $vars);
	}

	public function filminfoAction()
	{
		$vars['init'] = 0;
		$vars['film'] = $this->model->getFilmByID($_GET['film']);
		$this->view->render('Описание фильма',  $vars);
	}

}