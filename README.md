# films

Как запустить проект:

1. Написать в терминале git clone https://github.com/Kostiantyn-Kinzerskyi/films.git
2. Необходимо сделать импорт базы данных, которая находится в папке db_file
> mysql -uroot -p films < films.sql
- если возникнет проблема с доступом, необходимо выполнить вход с root правами > sudo -s
- так же если возникнут проблемы с доступом к самой базе через root - необходимо
добавить нового пользователя в mysql. Для этого заходим в mysql
> mysql
> CREATE USER 'newuser'@'localhost' IDENTIFIED BY 'password';
> GRANT ALL PRIVILEGES ON *.* TO 'newuser'@'localhost';
> FLUSH PRIVILEGES;
-newuser имя нового пользователя, password - пароль. Эти данные необходимо будет указать в конфиг файле подключения БД.

- Если отсутствует mysql, для установки необходимо написать команду:
> sudo apt update
> sudo apt install mysql-server
- Настройка
> sudo mysql_secure_installation

3. Настройка конфиг файла  
Файл расположен по пути application/config/db.php
вводим name - имя базы данных, user, password - имя и пароль пользователя mysql

4. Запуск php local server
- Необходимо перейти в папку public_html и запустить сервер
> php -S localhost:8000

- Если отсутствует модуль PDO, возникнет ошибка при подключении к БД, что бы устранить проблему необходимо установить модуль:
> sudo apt-get install php-mysql

