<?php
$ipaddress = $_SERVER["REMOTE_ADDR"];
function ip_details($ip) {
$json = file_get_contents ("http://ipinfo.io/{$ip}/geo");
$details = json_decode ($json);
return $details;
}
$details = ip_details($ipaddress);
$ip=$details -> ip;
$info = get_browser(null,true);
$przegladarka = $info['browser'];
$system = $info['platform'];
$godzina = date("Y-m-d H:i:s", time());
$user=strtolower($_POST['user']);
 $pass=$_POST['pass'];
 $link = mysqli_connect("matdid.pl", "31583454_lab7","pVLAl8Xu", "31583454_lab7");
 if(!$link) { echo"Błąd: ". mysqli_connect_errno()." ".mysqli_connect_error(); }
 mysqli_query($link, "SET NAMES 'utf8'");
 $query ="SELECT * FROM users WHERE login='$user'";
 $result = mysqli_query($link, $query);
 $rekord = mysqli_fetch_array($result);
 $idk=$rekord['id'];
 $query ="SELECT * FROM logs_fail WHERE idu='$idk'";
 $result = mysqli_query($link, $query); 
 $rekord1 = mysqli_fetch_array($result); 
 if(!$rekord)
{
     echo "nie ma takiego uzytkownika<br><br>";
     echo "<a href=\"wyloguj.php\">cofnij</a>";   
 }  
else
 { 
 if($rekord['haslo']==$pass )
 {  
     $spr=substr($rekord1['proba'], 0, 2);
     $pr=$rekord1['proba'];
     if($spr=="b-"){
            $blockedTime = substr($pr, 2);
            if(time() < $blockedTime){
            echo "<font color=\"red\">podano 3 razy bledne haslo...<br>konto zablokowane do : ",date("Y-m-d H:i:s ", $blockedTime),"</font>";
            echo "<a href=\"wyloguj.php\">cofnij</a>"; 
            }else{
 if ((!isset($_COOKIE['user'])) || ($_COOKIE['user']!=$rekord['id'])){
            setcookie("user", $rekord['id'], mktime(23,59,59,date("m"),date("d"),date("Y")));
            setcookie("user_n", $rekord['login'], mktime(23,59,59,date("m"),date("d"),date("Y")));
    }
          $query="INSERT INTO logs_ok VALUES (NULL,$idk,'$ip','$godzina')";
          mysqli_query($link, $query);
          $query="UPDATE logs_fail SET proba='0' WHERE idu='$idk'";
          mysqli_query($link, $query);
          $dalej="pliki.php";
          header("Location: $dalej");
 }}else{
      if ((!isset($_COOKIE['user'])) || ($_COOKIE['user']!=$rekord['id'])){
            setcookie("user", $rekord['id'], mktime(23,59,59,date("m"),date("d"),date("Y")));
            setcookie("user_n", $rekord['login'], mktime(23,59,59,date("m"),date("d"),date("Y")));
    }
          $query="INSERT INTO logs_ok VALUES (NULL,$idk,'$ip','$godzina')";
          mysqli_query($link, $query);
          $query="UPDATE logs_fail SET proba='0' WHERE idu='$idk'";
          mysqli_query($link, $query);
          $dalej="pliki.php";
          header("Location: $dalej");
 }}
 else
 {
      $pr=$rekord1['proba'];
     if ($pr=='2'){
              $pr="b-" . strtotime("+1 minutes", time());
              $query="UPDATE logs_fail SET proba='$pr',datagodzina='$godzina' WHERE idu='$idk'";
              mysqli_query($link, $query);
          }
          if(substr($pr, 0, 2) == "b-"){
            $blockedTime = substr($pr, 2);
            if(time() < $blockedTime){
            echo "<font color=\"red\">podano 3 razy bledne haslo...<br>konto zablokowane do : ",date("Y-m-d H:i:s ", $blockedTime),"</font>";
            }else{
                $query="UPDATE logs_fail SET proba='1',datagodzina='$godzina' WHERE idu='$idk'";
                mysqli_query($link, $query);
                echo "Zle haslo <br><br>";
            }}else{  
            if (IsSet($rekord1)){
                $pr=$rekord1['proba']+1;
                $query="UPDATE logs_fail SET proba='$pr',datagodzina='$godzina' WHERE idu='$idk'";
                mysqli_query($link, $query);
                echo "Zle haslo <br><br>";
            }else{
         $pr=$rekord1['proba']+1;
          $query="INSERT INTO logs_fail VALUES (NULL,$idk,'$ip','$godzina','$pr')";
          mysqli_query($link, $query);
          echo "Zle haslo <br><br>";
            }
            }
 mysqli_close($link);
 echo $rekord['idk'];
 echo "<a href=\"wyloguj.php\">cofnij</a>";
 }
}
?>
