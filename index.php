<!DOCTYPE html>
<html lang="en">
<head>
	<title>Konekt</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.0/animate.css">
	<link rel="stylesheet" type="text/css" href="styles.css">
	<script src="skripta.js"></script>
</head>
<body>
<div class="container" id="c1">

	<ul class="nav nav-tabs tabovi">
	  <li class="active"><a href="index.php">Enter record</a></li>
	  <li class=""><a href="display.php">Show/Delete record</a></li>
	</ul>
	<div class="container animated bounceInDown" id="c2">
		
	<form id="forma1" class="form-horizontal text-center">
		<div class="form-group">
		  <label for="ime">Ime:</label>
		  <input type="text" class="form-control inp" id="ime" placeholder="Unesi ime" name="ime" maxlength="255" required>
		</div>
		
		<div class="form-group">
		  <label for="prezime">Prezime:</label>
		  <input type="text" class="form-control inp" id="prezime" placeholder="Unesi prezime" name="prezime" maxlength="255" required>
		</div>
		
		<div class="form-group">
		  <label for="kompanija">Kompanija:</label>
		  <input type="text" class="form-control inp" id="kompanija" placeholder="Unesi kompaniju" name="kompanija" maxlength="255" required>
		</div>
		
		<div class="form-group">
		  <label for="adresa">Adresa:</label>
		  <input type="text" class="form-control inp" id="adresa" placeholder="Unesi adresu" name="adresa" maxlength="255" required>
		</div>
		
		<div class="form-group">
		  <label for="mesto">Mesto:</label>
		  <input type="text" class="form-control inp" id="mesto" placeholder="Unesi mesto rođenja" name="mesto" maxlength="255" required>
		</div>
		
		<div class="form-group">
		  <label for="datum">Datum rođenja:</label>
		  <input type="date" class="form-control inp" id="datum" placeholder="Unesi datum rođenja" name="datum" required>
		</div>
		
		<div class="form-group">
		  <label for="broj">Telefonski broj:</label>
		  <input type="number" class="form-control inp" id="broj" placeholder="Enter Phone Number" name="broj" maxlength="10" required>
		</div>
		
		<button id="btn1" class="btn btn-default">Submit</button>
	</form>
	
	</div>
</div>

<div class="container text-center" id="raport"></div>

</body>
</html>