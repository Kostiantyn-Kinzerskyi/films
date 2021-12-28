<!DOCTYPE html>
<html>
<head>
    <title>Films</title>
    <link rel="stylesheet" type="text/css" href="/css/style.css">
    <link rel="stylesheet" type="text/css" href="/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
       <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <div class="col-sm-4">
                <?php if ($path == APPATH.'/views/main/index.php'): ?>
                    <a href="/" class="btn btn-outline-primary active" role="button">Главная</a>
                <?php else: ?>
                    <a href="/" class="btn btn-outline-primary" role="button">Главная</a>
                <?php endif; ?>
                <?php if ($path == APPATH.'/views/main/films.php'): ?>
                    <a href="/films" class="btn btn-outline-primary active" role="button">Фильмы</a>
                <?php else: ?>
                    <a href="/films" class="btn btn-outline-primary" role="button">Фильмы</a>
                <?php endif; ?>
            </div>

            <div class="col-sm-5">
            </div>

       </div>
       </nav>
        
    </div>

    <?php echo $content; ?>
</body>
</html>