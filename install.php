<?php

require 'funkcije.php';
$servername = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "";

// Create connection
$conn = new SimpleDB($servername, $username, $password, $dbname); 

// Create database
$sql1 = "CREATE DATABASE Konekt";

if ($conn->execute($sql1) === TRUE) {
    echo "Uspesno napravljena baza";
} else {
    echo "Neuspešno napravljena baza: " . $conn->error;
}

$sql2 = "CREATE TABLE Konekt.mesto (
		id INT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
		mesto VARCHAR(20) NOT NULL
		);";

$sql3 = "CREATE TABLE Konekt.kompanija (
		id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
		naziv VARCHAR(255) NOT NULL
		);";
		
$sql4  = "CREATE TABLE Konekt.osoba (
		id INT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
		ime VARCHAR(255) NOT NULL, 
		prezime VARCHAR(255) NOT NULL,
		adresa VARCHAR(255) NOT NULL,
		datum_rodjenja DATE NOT NULL,
		datum_unosa DATETIME NOT NULL,
		datum_edita TIMESTAMP NOT NULL,
		mesto_FK INT(10) UNSIGNED,
		FOREIGN KEY (mesto_FK) REFERENCES Konekt.mesto(id) ON UPDATE CASCADE ON DELETE CASCADE,
		kompanija_FK INT(10) UNSIGNED,
		FOREIGN KEY (kompanija_FK) REFERENCES Konekt.kompanija(id) ON UPDATE CASCADE ON DELETE CASCADE
		);";
	
$sql5 = "CREATE TABLE Konekt.tel_broj (
		id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
		broj VARCHAR(10) NOT NULL,
		osoba_FK INT(10) UNSIGNED,
		FOREIGN KEY (osoba_FK) REFERENCES Konekt.osoba(id) ON UPDATE CASCADE ON DELETE CASCADE
		);";

$sql6 = "INSERT INTO Konekt.mesto (mesto) 
	VALUES('Smederevo'),('Požarevac'),('Beograd');";

$sql7 = "INSERT INTO Konekt.kompanija (naziv) 
	VALUES('HBIS'),('Konekt'),('Milan Blagojević');";
	
$sql8 = "INSERT INTO Konekt.osoba (ime, prezime, adresa, datum_rodjenja, datum_unosa, datum_edita, mesto_FK, kompanija_FK)
	VALUES ('Veljko', 'Stefanović', 'Branka Radičevića 3', '1982-11-20', '2018-05-21', '2018-05-23', 1, 1);";

$sql9 = "INSERT INTO Konekt.tel_broj (broj, osoba_FK)
	VALUES ('0649082984', 1);";

$sql = 	$sql2.$sql3.$sql4.$sql5.$sql6.$sql7.$sql8.$sql9;

if ($conn->multi_execute($sql) === TRUE) {
    echo "Uspesno napravljene tabele";
} else {
    echo "Neuspešno napravljene tabele: " . $conn->error;
}

?>