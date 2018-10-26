<?php
require 'funkcije.php';

$form_var = array();
if(isset($_GET)){
	
	foreach ($_GET as $value) { 
	
		$obj1 = new Validation($value);
		$form_var[] = $obj1 -> test_input($obj1 -> getData());
	
	}
	
	/*Sadrzaj za modal formu:
	$form_var[0]== ime;
	$form_var[1]== prezime;
	$form_var[2]== kompanija;
	$form_var[3]== adresa;
	$form_var[4]== mesto;
	$form_var[5]== datum;
	$form_var[6]== broj;
	$form_var[7]== timestamp;
	*/
	
	$servername = "127.0.0.1";
	$username = "root";
	$password = "";
	$dbname = "konekt";
	
	$kon1 = new SimpleDB($servername, $username, $password, $dbname);
	
	$sql1 = "INSERT INTO  mesto(mesto)
			VALUES ('$form_var[4]');";
	$result1 = $kon1->execute($sql1);
	
	$sql1x1 = "SELECT MAX(id) as mestoId FROM mesto;";
	$result1x1 = $kon1->execute($sql1x1);
	$mestoId = "";
	
	if($result1x1->num_rows > 0){//Get an id from db.
			
		while($row = $result1x1->fetch_assoc()) {
			
			$mestoId = $row["mestoId"];
		}
			
	}
	else if($result1x1->num_rows == 0){
			echo "0 results";
	}

	$sql2 = "INSERT INTO  kompanija(naziv)
			VALUES ('$form_var[2]');";
	$result2 = $kon1->execute($sql2);
	
	$sql2x1 = "SELECT MAX(id) as kompanijaId FROM kompanija;";
	$result2x1 = $kon1->execute($sql2x1);
	$kompanijaId = "";	
	
	if($result2x1->num_rows > 0){//Get an id from db.
			
		while($row = $result2x1->fetch_assoc()) {
			
			$kompanijaId = $row["kompanijaId"];
		}
			
	}
	else if($result2x1->num_rows == 0){
			echo "0 results";
	}
	
	$sql3 = "INSERT INTO  osoba(ime, prezime, adresa, datum_rodjenja, datum_unosa, mesto_FK, kompanija_FK)
			VALUES ('$form_var[0]', '$form_var[1]', '$form_var[3]', '$form_var[5]', CURRENT_TIMESTAMP(), $mestoId, $kompanijaId);";
	$result3 = $kon1->execute($sql3);
	
	$sql3x1 = "SELECT MAX(id) as osobaId FROM osoba;";
	$result3x1 = $kon1->execute($sql3x1);
	$osobaId = "";	
	
	if($result3x1->num_rows > 0){//Get an id from db.
			
		while($row = $result3x1->fetch_assoc()) {
			
			$osobaId = $row["osobaId"];
		}
			
	}
	else if($result3x1->num_rows == 0){
			echo "0 results";
	}
	
	$sql4 = "INSERT INTO tel_broj (broj, osoba_FK)
	VALUES ('$form_var[6]', $osobaId);";
	$result4 = $kon1->execute($sql4);
	
}



?>