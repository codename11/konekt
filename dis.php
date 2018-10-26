<?php
require 'funkcije.php';

$form_var = array();
if(isset($_GET)){
	

	foreach ($_GET as $value) {
		$obj1 = new Validation($value);
		$form_var[] = $obj1 -> test_input($obj1 -> getData());
	}

}

/*
$form_var[0] == ime;
$form_var[1] == prezime;
$form_var[2] == kompanija;
$form_var[3] == adresa;
$form_var[4] == mesto;
$form_var[5] == datum rodjenja;
$form_var[6] == broj;
*/

$servername = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "konekt";

// Create connection
$kon1 = new SimpleDB($servername, $username, $password, $dbname); 

$sql = "SELECT osoba.id as osobaId, kompanija.id as kompanijaId, tel_broj.id as brojId, mesto.id as mestoId, ime, prezime, adresa, datum_rodjenja, mesto, broj, naziv
FROM osoba, mesto, kompanija, tel_broj 
WHERE ime LIKE '%$form_var[0]%' AND prezime LIKE '%$form_var[1]%' AND adresa LIKE '%$form_var[3]%' 
AND mesto LIKE '%$form_var[4]%' AND datum_rodjenja LIKE '%$form_var[5]%' AND broj LIKE '%$form_var[6]%' AND naziv LIKE '%$form_var[2]%' 
AND osoba.id=tel_broj.osoba_FK AND kompanija.id=osoba.kompanija_FK AND mesto.id=osoba.mesto_FK";

$result = $kon1->execute($sql);

if($result->num_rows > 0){
	
	while($row = $result->fetch_assoc()) {
		$myObj->id[] = $row["osobaId"];
		$myObj->ime[] = $row["ime"];
		$myObj->prezime[] = $row["prezime"];
		$myObj->adresa[] = $row["adresa"];
		$myObj->datum_rođenja[] = $row["datum_rodjenja"];
		$myObj->mesto[] = $row["mesto"];
		$myObj->broj[] = $row["broj"];
		$myObj->kompanija[] = $row["naziv"];
	}
	
	$myJSON = json_encode($myObj);
	echo($myJSON);
}
else if($result->num_rows == 0){
    echo "0 results";

}

//print_r($form_var);
?>