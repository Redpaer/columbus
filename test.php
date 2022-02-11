<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Test</title>
	<link rel='stylesheet' href='/lib/fonts/Acrom/stylesheet.css'>
	<link rel='stylesheet' href='/lib/fonts/Geometria/stylesheet.css'>
	<link rel='stylesheet' href='/engine/styles/main.css'>
	<title></title>
</head>

<body class='body_test'>
	<div class='wrapper'>
		<header class='header_new'>
			<div class='header_new__container _container'>
				<div class='_text'>Вставьте ваш файл формата csv.</div>
				<form method='POST' action='new_catalog.php' enctype='multipart/form-data' style='margin-left: 100px;'>
					<input type='file' class='fSEJdr' name='user_files' accept='.csv'>
					<input type='submit'>
					<?php

						if($_COOKIE['err'] == 'most'){
							echo" <div style='color:red;'>Количество столбцов в csv файле не совпадает с нужныс кол-вом. Пожалуйста проверте файл и попробуйте загрузить его еще раз.</div>";
						}elseif($_COOKIE['err'] =='null'){
							echo" <div style='color:red;'>Вы не выбрали файл для добавления в базу данных. Пожалуйста попробуйте еще раз.</div>";
						}
					 ?>
				</form>
			</div>
		</header>
		
	</div>

</body>
</html>