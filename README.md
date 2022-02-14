# Тестовое задание

## Файл new_catalog.php

```php
$db = mysqli_connect('localhost', '', '','');
```
$db - переменная для подключения к базе данных. В пустых полях нужно указать ваш логин, пароль и название базы.

```php
$result = $db->query("SELECT * FROM `catalog` WHERE 1 ");

if($result == FALSE){
	$db->query("CREATE TABLE IF NOT EXISTS catalog (code VARCHAR(15) NOT NULL PRIMARY KEY, name VARCHAR(255) NOT NULL)");
}
```
Этот фрагмент кода - проверка на существование таблицы каталога. Если данной таблицы нет в базе, то код создаст ее.

В папке ver.Self лежит второй вариант выполнения задания. Там форма уже ссылается на себя и работает без контроллера. 

