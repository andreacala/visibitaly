<?php
if (base64_decode($_SERVER["HTTP_X_AUTHORIZATION"]) == ("login_di_pippo:password_di_pippo")) { 
	if (move_uploaded_file ($_FILES['file']['tmp_name'], "articoli.xml")){
		echo "OK";
	} else {
		echo "Error";
	}
} else {
	echo "Utente o Password non valida";
}
?>
