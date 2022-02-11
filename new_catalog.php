<?php
$db = mysqli_connect('localhost', '', '','');
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

                $check = false;
                setcookie('err', 'most', time()+3600);
                header('Location: test.php');
                break;

            }           
        }
        fclose($handle);
    }else{
        setcookie('err', 'null', time()+3600);
        header('Location: test.php');
    }
    
    if ($check == true) {
       $a = array('code', 'name', 'error');
       $b = array('Код', 'Название', 'Error');
       $title = array_combine($a, $b);
       setcookie('err', 'ok', time()+3600);

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

?>


