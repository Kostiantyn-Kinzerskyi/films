<div class="container">
	<center>
		<h3>Добавить новый фильм</h3>
	</center>
	
	<form id="add_film" name="form_film" method="POST" action="/films" autocomplete="off">
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
	
	<form id="sort_film" name="sort_film" method="POST" action="/films" autocomplete="off">
		<div class="row p-4">
			<div class="col-sm-2">
				<select class="form-select" name="sort_by">
  					<option value="" selected>Сортировать по</option>
  					<option value="1">по названию</option>
  					<option value="2">по году выпуска</option>
  				</select>
			</div>
			<div class="col-sm-2">
				<button name="submit_sort" type="submit_sort" class="btn btn-outline-primary">Выполнить</button>	
			</div>
			<div class="col-sm-3">
				<div class="input-group mb-3">
  					<input type="text" class="form-control" placeholder="Введите название фильма" name="find_film" aria-describedby="basic-addon1">
				</div>
			</div>
			<div class="col-sm-1">
				<button name="submit_search" type="submit" class="btn btn-outline-primary">Поиск</button>	
			</div>
			<div class="col-sm-3">
				<div class="input-group mb-3">
  					<input type="text" class="form-control" placeholder="Введите имя актера" name="find_film_actor" aria-describedby="basic-addon1">
				</div>
			</div>
			<div class="col-sm-1">
				<button name="submit_search" type="submit" class="btn btn-outline-primary">Поиск</button>	
			</div>
		</div>
	</form>

	<center>
		<h3>Импорт фильмов</h3>
	</center>
	
	<form method="POST" action="/films" enctype="multipart/form-data">
		<label for="filename">ФАЙЛ:</label>
		<input id="filename" type="file" name="filename">
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
			<form id="del_film" name="form_del" method="POST" action="/films" autocomplete="off">

			<?php if(isset($vars['films'])) foreach ($vars['films'] as $val): ?>
			<tr>
				<th scope="row"><?=$val['id']?></th>
				<th scope="row"><?=$val['title']?></th>
				<th scope="row"><?=$val['release_year']?></th>
				<th scope="row"><?=$val['format']?></th>
				<th scope="row"><?=$val['stars']?></th>
				<th scope="row"><button name="submit_more" value="<?=$val['id']?>" type="submit" class="btn btn-outline-success">Подробнее</button></th>
				<th scope="row"><button name="submit_del" value="<?=$val['id']?>" type="submit" class="btn btn-outline-danger">Удалить</button></th>
			</tr>
			<?php endforeach; ?>
			</form>
		</tbody>
		
	</table>
	
</div>