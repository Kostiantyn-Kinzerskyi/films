<div class="container">
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
			<th scope="row"><?=$vars['film'][0]['id']?></th>
			<th scope="row"><?=$vars['film'][0]['title']?></th>
			<th scope="row"><?=$vars['film'][0]['release_year']?></th>
			<th scope="row"><?=$vars['film'][0]['format']?></th>
			<th scope="row"><?=$vars['film'][0]['stars']?></th>
		</tbody>
	
</div>