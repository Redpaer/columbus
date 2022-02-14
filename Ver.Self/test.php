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
				<form method='POST' action='<?php echo $_SERVER['PHP_SELF']; ?>' enctype='multipart/form-data' style='margin-left: 100px;'>
					<input type='file' class='fSEJdr' name='user_files' accept='.csv'>
					<input type='hidden' name='action' value='true'>
					<input type='submit'>
					<?php


					if (isset($_POST['action']) && 
						$_POST['action']){


						$db = mysqli_connect('localhost', 'shops', 'PEw30-QTpx2','shop');
						if (!$db){die('Ошибка соединения: ' . $db->connect_error);}
						$db->set_charset("utf8");

						$result = $db->query("SELECT * FROM `catalog` WHERE 1 ");

						if($result == FALSE){
							$db->query("CREATE TABLE IF NOT EXISTS catalog (code VARCHAR(15) NOT NULL PRIMARY KEY, name VARCHAR(255) NOT NULL)");
						}

						$filename = $_FILES['user_files']['tmp_name'];
						$data = [];


						if (($handle = fopen($filename, "r")) !== FALSE) {
							fgetcsv($handle, 0, ',');   
							while (($row = fgetcsv($handle, 0, ";")) !== FALSE) {
								$num = count($row);
								  if($num == 2){
								  	$chr_ru_en = "A-Za-zА-Яа-яЁё0-9-.\s";
					                if (preg_match("/^[$chr_ru_en]+$/iu", $row[1])) {
					                    $row_code = str_replace(" ", '', $row[0]);
					                    $db->query("INSERT INTO `catalog` (`code`,`name`) VALUES ('".$row_code."','".$row[1]."') ");
					                  
					                }
					                $text = mb_ereg_replace("[A-Za-zА-Яа-яЁё0-9-.\s]",  '', $row[1]);
					                list($code, $name, $error) = $row;
					                $data[] = [
					                    'code' => $code,
					                    'name' => $name,
					                    'error' =>$text
					                ];
					                $check = true; 
									}else{
										echo '<script type="text/javascript">alert("Количество столбцов в файле не совпадает с нужным кол-ом. Пожалуйста проверте файл и попробуйте снова.")</script>';
										break;
									}
							}	
						fclose($handle);	
						}else{
							echo '<script type="text/javascript">alert("Вы не выбрали файл для загрузки в базу данных!")</script>';
						}

						if ($check == true) {
					       $a = array('code', 'name', 'error');
					       $b = array('Код', 'Название', 'Error');
					       $title = array_combine($a, $b);	
					       ob_clean();	
					       array_unshift($data, $title);
					       header("Content-type: text/csv"); 
					       header("Content-Disposition: attachment; filename=file.csv"); 
					       header("Pragma: no-cache"); 
					       header("Expires: 0"); 

					        $buffer = fopen("php://output", 'w');
					        fputs($buffer, chr(0xEF) . chr(0xBB) . chr(0xBF));


					        foreach ($data as $val) {

					            fputcsv($buffer, $val, ';');
					        }
					        fclose($buffer);
					    }

						exit;
					}

					
					?>
				</form>
			</div>
		</header>
		
	</div>

</body>
</html>