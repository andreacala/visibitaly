<?php
if (base64_decode($_SERVER["HTTP_X_AUTHORIZATION"]) == "login_di_pippo:password_di_pippo") {
	$filestring = file_get_contents("ordini.xml");
	echo $filestring;
} else {
	header ("HTTP/1.1 400 Bad request");
	echo "Utente o password non validi";
	exit;
}
?>
