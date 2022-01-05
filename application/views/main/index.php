<div class="container">

	<center>
		<h3>Добавить новый фильм</h3>
	</center>

	<?php if (isset($_GET['status']) && $_GET['status'] == 'success'): ?>
		<div class="alert alert-success" role="alert">
			Запись успешно добавлена!
		</div>
	<?php endif; ?>
	<?php if (isset($_GET['status']) && $_GET['status'] == 'failed'): ?>
		<div class="alert alert-danger" role="alert">
			Во время записи возникла ошибка!
		</div>
	<?php endif; ?>
	
	<form id="add_film" name="form_film" method="POST" action="/" autocomplete="off">
		<div class="row p-4">
			<div class="col-sm-3">
				<div class="input-group mb-3">
  					<input type="text" class="form-control" placeholder="Введите название фильма" name="film_name" aria-describedby="basic-addon1" required>
				</div>
			</div>
			<div class="col-sm-2">
				<div class="input-group mb-3">
  					<input type="number" step="1" min="1900" max="2030" class="form-control" placeholder="Год выпуска" name="year" aria-describedby="basic-addon1" required>
				</div>
			</div>
			<div class="col-sm-2">
				<select class="form-select" name="format" required>
  					<option value="" selected>Выберите формат</option>
  					<option value="1">DVD</option>
  					<option value="2">VHS</option>
  					<option value="3">Blu-ray</option>
  				</select>
			</div>
			<div class="col-sm-3">
				<div class="input-group mb-3">
  					<input type="text" class="form-control" placeholder="Введите список актеров" name="actors" aria-describedby="basic-addon1" required>
				</div>
			</div>
			<div class="col-sm-2">
				<button name="submit_add" type="submit" class="btn btn-outline-primary">Добавить</button>	
			</div>
		</div>
	</form>

	<center>
		<h3>Сортировка и поиск по названию фильма</h3>
	</center>
	
	<form id="sort_film" name="sort_film" method="GET" action="/<?php echo (isset($_GET['page']) ? "?page=".$_GET['page'] : "") ?>" autocomplete="off">
		<div class="row p-4">
			<div class="col-sm-2">
				<select class="form-select" name="sort_by">
  					<option value="1" <?php if (!isset($_GET['sort_by'])) echo "selected" ?>>Сортировать по</option>
  					<option value="1" <?php if (isset($_GET['sort_by']) && $_GET['sort_by'] == 1) echo "selected" ?>>от а до я</option>
  					<option value="4" <?php if (isset($_GET['sort_by']) && $_GET['sort_by'] == 4) echo "selected" ?>>от я до а</option>
  					<option value="2" <?php if (isset($_GET['sort_by']) && $_GET['sort_by'] == 2) echo "selected" ?>>по году выпуска ↓</option>
  					<option value="3" <?php if (isset($_GET['sort_by']) && $_GET['sort_by'] == 3) echo "selected" ?>>по году выпуска ↑</option>
  				</select>
			</div>
			<div class="col-sm-2">
				<button type="submit_sort" class="btn btn-outline-primary">Выполнить</button>	
			</div>
			<div class="col-sm-3">
				<div class="input-group mb-3">
  					<input type="text" class="form-control" value="<?php echo (isset($_GET['find_film']) ? $_GET['find_film'] : "") ?>" placeholder="Введите название фильма" name="find_film" aria-describedby="basic-addon1">
				</div>
			</div>
			<div class="col-sm-1">
				<button type="submit" class="btn btn-outline-primary">Поиск</button>	
			</div>
			<div class="col-sm-3">
				<div class="input-group mb-3">
  					<input type="text" class="form-control" value="<?php echo (isset($_GET['find_film_actor']) ? $_GET['find_film_actor'] : "") ?>" placeholder="Введите имя актера" name="find_film_actor" aria-describedby="basic-addon1">
				</div>
			</div>
			<div class="col-sm-1">
				<button type="submit" class="btn btn-outline-primary">Поиск</button>	
			</div>
		</div>
	</form>

	<center>
		<h3>Импорт фильмов</h3>
	</center>

	<?php if (isset($vars['success']) && $vars['success'] > 0): ?>
		<div class="alert alert-success" role="alert">
			Импорт фильмов успешно завершен! Добавлено фильмов: <?php echo($vars['success']) ?>. Среди них повторов, или не прошедших валидацию: <?php echo($vars['error']) ?>
		</div>
	<?php endif; ?>
	<?php if (isset($vars['success']) && $vars['success'] == 0): ?>
		<div class="alert alert-danger" role="alert">
			Во время записи возникла ошибка!
		</div>
	<?php endif; ?>
	
	<form method="POST" action="/" enctype="multipart/form-data">
		<label for="filename">ФАЙЛ:</label>
		<input id="filename" type="file" accept=".txt" name="filename">
		<input class="btn btn-outline-primary" type="submit" value="Загрузить" />
	</form>

	<center>
		<h2>Список фильмов</h2>
	</center>

	<table class="table table-hover">
		<thead>
			<tr>
				<th scope="col">id</th>
				<th scope="col">Название</th>
				<th scope="col">Год выпуска</th>
				<th scope="col">Формат</th>
				<th scope="col">Список актеров</th>
			</tr>
		</thead>
		<tbody>
			<form id="del_film" name="form_del" method="POST" action="/" autocomplete="off">

			<?php if(isset($vars['films'])) foreach ($vars['films'] as $val): ?>
			<tr>
				<th scope="row"><?=$val['id']?></th>
				<th scope="row"><?=$val['title']?></th>
				<th scope="row"><?=$val['release_year']?></th>
				<th scope="row"><?=$val['format']?></th>
				<th scope="row"><?=$val['stars']?></th>
				<th scope="row"><button name="submit_more" value="<?=$val['id']?>" type="submit" class="btn btn-outline-success">Подробнее</button></th>
				<th scope="row"><button name="submit_del" onclick="return confirm('Вы уверены, что хотите удалить фильм?')" value="<?=$val['id']?>" type="submit" class="btn btn-outline-danger">Удалить</button></th>
			</tr>
			<?php endforeach; ?>
			</form>
		</tbody>
		
	</table>

	<?php $active_filters = "";
	if (isset($_GET['sort_by']))
		$active_filters .= "&sort_by=".$_GET['sort_by'];
	if (isset($_GET['find_film']))
		$active_filters .= "&find_film=".$_GET['find_film'];
	if (isset($_GET['find_film_actor']))
		$active_filters .= "&find_film_actor=".$_GET['find_film_actor'];

	 ?>

	<nav aria-label="...">
		<ul class="pagination">
			<li class="page-item <?php if ((isset($_GET['page']) && $_GET['page'] <= 1) || !isset($_GET['page']) ) echo "disabled" ?>">
				<a class="page-link" href="/?page=<?php echo (isset($_GET['page']) && $_GET['page'] > 1 ? $_GET['page'] - 1 : "1"); echo ($active_filters) ?>">Предыдущая</a>
			</li>
			<?php for ($i = 1; $i <= $vars['pages']; $i++): ?>
				<?php if ($i == 1 && !isset($_GET['page'])): ?>
					<li class="page-item active">
						<a class="page-link" href="/?page=1<?php echo ($active_filters) ?>"><?php echo ($i) ?></a>
					</li>
				<?php else: ?>
				<li class="page-item <?php echo ((isset($_GET['page']) && ($_GET['page'] == $i)) ? "active" : "" )  ?>">
					<a class="page-link" href="/?page=<?php echo ($i); echo ($active_filters)?>"><?php echo ($i) ?></a>
				</li>
				<?php endif; ?>
				<?php endfor; ?>
			<li class="page-item <?php if ((isset($_GET['page']) && $_GET['page'] == $vars['pages']) || !isset($_GET['page']) && $vars['pages'] == 1 ) echo "disabled" ?>">
				<a class="page-link" href="/?page=<?php echo (isset($_GET['page']) ? $_GET['page'] + 1 : "2"); echo ($active_filters) ?>">Следующая</a>
			</li>
		</ul>
	</nav>
	
</div>