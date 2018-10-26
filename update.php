<?php

	//print_r($_GET);
	
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
$form_var[5] == datum;
$form_var[6] == broj;
$form_var[7] == id;
*/

$servername = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "konekt";

// Create connection
$kon1 = new SimpleDB($servername, $username, $password, $dbname); 

$sql1 = "SELECT id, mesto_FK, kompanija_FK
FROM osoba 
WHERE id='$form_var[7]'";

$result1 = $kon1->execute($sql1);
$myId = "";
$mesto_FK = "";
$kompanija_FK = "";

if($result1->num_rows > 0){
	
	while($row = $result1->fetch_assoc()) {
		$myId = $row["id"];
		$mesto_FK = $row["mesto_FK"];
		$kompanija_FK = $row["kompanija_FK"];
	}
	
}
else if($result1->num_rows == 0){
    echo "0 results";
}

$sql2 = "UPDATE osoba, mesto, kompanija, tel_broj SET osoba.ime='$form_var[0]', osoba.prezime='$form_var[1]', osoba.adresa='$form_var[3]',osoba.datum_rodjenja='$form_var[5]', mesto.mesto='$form_var[4]', tel_broj.broj='$form_var[6]', kompanija.naziv='$form_var[2]', osoba.datum_edita=CURRENT_TIMESTAMP() 
WHERE osoba.id='$myId' AND mesto.id='$mesto_FK' AND kompanija.id='$kompanija_FK ' AND osoba.mesto_FK='$mesto_FK' AND osoba.kompanija_FK='$kompanija_FK' AND tel_broj.osoba_FK=osoba.id";
$result2=$kon1->execute($sql2);

$sql3 = "SELECT osoba.id as osobaId, kompanija.id as kompanijaId, tel_broj.id as brojId, mesto.id as mestoId, ime, prezime, adresa, datum_rodjenja, mesto, broj, naziv
FROM osoba, mesto, kompanija, tel_broj 
WHERE ime LIKE '%%' AND prezime LIKE '%%' AND adresa LIKE '%%' 
AND mesto LIKE '%%' AND datum_rodjenja LIKE '%%' AND broj LIKE '%%' AND naziv LIKE '%%' 
AND osoba.id=tel_broj.osoba_FK AND kompanija.id=osoba.kompanija_FK AND mesto.id=osoba.mesto_FK";

$result3 = $kon1->execute($sql3);

if($result3->num_rows > 0){
	
	while($row = $result3->fetch_assoc()) {
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
else if($result3->num_rows == 0){
    echo "0 results";

}
?>