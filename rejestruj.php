<html lang="pl">
<head>
    <meta charset="utf-8"/>  
    <title>Didyk</title>
    <meta name="description" content="Laboratoria"/>
	<meta name="keywords" content = "laboratorium, laboratoria, labki, ćwiczenia, programowanie, php, zajęcia" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
</head>

<body>

<p><a href="index.php">powrót</a></p>


<form method="POST">
login :
<input type="text" name="nick" maxlength="25" size="25"><br>
<br>
hasło    :      
<input type="password" name="haslo" maxlength="25" size="25"><br>
<br>
powtórz hasło :     
<input type="password" name="haslo1" maxlength="25" size="25"><br>
<br>
<input type="submit" value="Rejestruj"/>
</form>
<?php
    $dbhost="matdid.pl"; $dbuser="31583454_lab7"; $dbpassword="pVLAl8Xu"; $dbname="31583454_lab7";
    $polaczenie = mysqli_connect($dbhost, $dbuser, $dbpassword, $dbname);
        if (!$polaczenie) {
            echo "Błąd połączenia z MySQL." . PHP_EOL;
            echo "Errno: " . mysqli_connect_errno() . PHP_EOL;
            echo "Error: " . mysqli_connect_error() . PHP_EOL;
            exit;
        }    
if (IsSet($_POST['nick'])) {
    if($_POST['haslo'] == $_POST['haslo1']){
    $n=$_POST['nick'];
    $h=$_POST['haslo'];
    $dodaj="INSERT INTO users VALUES (NULL,'$n', '$h')";
    mysqli_query($polaczenie, $dodaj);
    mysqli_close($polaczenie);
    mkdir ("users/$n", 0777);
    echo "<script>alert('Dodano')</script>";
    }else {
         echo "<script>alert('Hasla nie sa takie same')</script>";
        }
}
?>
</body>
</html>
</html>




