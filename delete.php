<?php

require 'funkcije.php';

$form_var = array();
if(isset($_GET)){
	
	foreach ($_GET as $value) { 
	
		$obj1 = new Validation($value);
		$form_var[] = $obj1 -> test_input($obj1 -> getData());
	
	}
	
	/*Sadrzaj za modal formu:
	$form_var[0]== mesto;
	$form_var[1]== kompanijaId;
	$form_var[2]== osobaId;
	$form_var[3]== brojId;
	*/

	$servername = "127.0.0.1";
	$username = "root";
	$password = "";
	$dbname = "konekt";
	
	$kon1 = new SimpleDB($servername, $username, $password, $dbname);
	
	$sql1 = "SELECT mesto.id as mestoId, kompanija.id as kompanijaId, osoba.id as osobaId, tel_broj.id as brojId FROM mesto, kompanija, osoba, tel_broj WHERE osoba.id=$form_var[0] AND tel_broj.osoba_FK=$form_var[0] AND tel_broj.osoba_FK=osoba.id AND osoba.mesto_FK=mesto.id AND osoba.kompanija_FK=kompanija.id";
	
	$result1 = $kon1->execute($sql1);
	
	$mestoId = "";
	$kompanijaId = "";
	$osobaId = "";
	$brojId = "";
	if($result1->num_rows > 0){
	
		while($row = $result1->fetch_assoc()) {
			$mestoId = $row["mestoId"];
			$kompanijaId = $row["kompanijaId"];
			$osobaId = $row["osobaId"];
			$brojId = $row["brojId"];
		}
	
	}
	else if($result1->num_rows == 0){
		echo "0 results";

	}
	
	$sql2 = "DELETE FROM mesto WHERE id=$mestoId; 
	DELETE FROM kompanija WHERE id=$kompanijaId; 
	DELETE FROM osoba WHERE id=$osobaId AND mesto_FK=$mestoId AND kompanija_FK=$kompanijaId; 
	DELETE FROM tel_broj WHERE id=$brojId AND osoba_FK=$osobaId;";
	
	$result2 = $kon1->multi_execute($sql2);
	
	// Create connection
	$conn = new mysqli($servername, $username, $password, $dbname);
	// Check connection
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	} 

	$sql3 = "SELECT osoba.id as osobaId, kompanija.id as kompanijaId, tel_broj.id as brojId, mesto.id as mestoId, ime, prezime, adresa, datum_rodjenja, mesto, broj, naziv FROM osoba, mesto, kompanija, tel_broj WHERE ime LIKE '%%' AND prezime LIKE '%%' AND adresa LIKE '%%' AND mesto LIKE '%%' AND datum_rodjenja LIKE '%%' AND broj LIKE '%%' AND naziv LIKE '%%' AND osoba.id=tel_broj.osoba_FK AND kompanija.id=osoba.kompanija_FK AND mesto.id=osoba.mesto_FK";
	$result3 = $conn->query($sql3);

	if ($result3->num_rows > 0) {
		// output data of each row
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
		
	} else {
		echo "0 results";
	}
	$conn->close();
	
}
?>