<?php
$ipaddress = $_SERVER["REMOTE_ADDR"];
function ip_details($ip) {
$json = file_get_contents ("http://ipinfo.io/{$ip}/geo");
$details = json_decode ($json);
return $details;
}
$details = ip_details($ipaddress);
$ip=$details -> ip;
    $dbhost="matdid.pl"; $dbuser="31583454_lab7"; $dbpassword="pVLAl8Xu"; $dbname="31583454_lab7";
    $polaczenie = mysqli_connect($dbhost, $dbuser, $dbpassword, $dbname);
        if (!$polaczenie) {
            echo "Błąd połączenia z MySQL." . PHP_EOL;
            echo "Errno: " . mysqli_connect_errno() . PHP_EOL;
            echo "Error: " . mysqli_connect_error() . PHP_EOL;
            exit;
        }    
        $idk=$_COOKIE['user'];
        if(IsSet($usr)){
      $query ="SELECT * FROM logs_fail WHERE idu=$idk order by datagodzina desc limit 1";
      $result = mysqli_query($polaczenie, $query); 
      $rekord1 = mysqli_fetch_array($result); 
      }
      ?>
<html lang="pl">
<head>
    <meta charset="utf-8"/>  
    <title>Didyk</title>
    <meta name="description" content="Laboratoria"/>
	<meta name="keywords" content = "laboratorium, laboratoria, labki, ćwiczenia, programowanie, php, zajęcia" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
</head>

<body>
<?php
$usr=$_COOKIE['user_n'];
if(IsSet($usr)){
    ?>

<p><a href="wyloguj.php">wyloguj</a></p>
<?php
 echo "Zalogowany : <b>",$_COOKIE['user_n'],"</b>";
 ?>
<p><b><font color="red">
<?php
    if(!empty($rekord1)){
    echo "ostatnie niepoprawne logowanie : ",$rekord1['datagodzina']," <hr>";
   
    }
?>
</font></b></p>
<p> Lista Twoich plików i folderów</p>
<br>
<br>
<br>
<br>
<?php

$dir= "/lab7/users/$usr";
$files = scandir($dir);
$arrlength = count($files);
for($x = 2; $x < $arrlength; $x++) {
    
  if (is_file("/lab7/users/$usr/$files[$x]")){
    echo "<a href='/lab7/users/$usr/$files[$x]' download='$files[$x]'>$files[$x]</a><br>";
  }else{ 
      echo $files[$x],"<br>";
      $dir2= "/lab7/users/$usr/$files[$x]";
      $files2 = scandir($dir2);
      $arrlength2 = count($files2);
        for($y = 2; $y < $arrlength2; $y++) {
        
        if (is_file("/lab7/users/$usr/$files[$x]/$files2[$y]")){
        echo "&#9830<a href='/lab7/users/$usr/$files[$x]/$files2[$y]' download='$files2[$y]'>$files2[$y]</a>";
        }else{ 
            echo "&#9830",$files2[$y];
        }
            echo "<br>";
            }
   }
  }
    echo "<br>";

?>

<p>Przegladaj pliki</p>
<form action="odbierz.php" method="POST" ENCTYPE="multipart/form-data">
<?php
if (is_dir($dir)) {
    if ($dh = opendir($dir)) {
        while (($file = readdir($dh)) !== false) {
            if(is_dir("/lab7/users/$usr/$file") && $file != '.' && $file != '..'){
            echo "<input type=\"radio\" name=\"folder\" value =$file>$file<br>";
            }
        }
        closedir($dh);
    }
}
?>
 <input type="file" name="plik"/>
 <input type="submit" value="wyslij"/>
 </form>
<br>
<p>utworz folder</p>
<form method="POST" action="tworzenie.php">
        nazwa folderu : <input type="text" name="n_kat">
        <input type="submit" value="utworz"/>
    </form>
    <?php
}else{
echo "najpierw sie zaloguj";}
?>
</body>
</html>