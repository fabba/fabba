<?php

session_start();
if(isset($_SESSION['voornaam'])){
        $ingelogd = true ;
	$voornaam = $_SESSION['voornaam'];
	$achternaam = $_SESSION['achternaam'];
        $accountnummer = $_SESSION['accountnummer'] ;
} else {
    $ingelogd = false ;
}
if( !isset($doorschrijven) || !$doorschrijven )
    session_write_close();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
	<title>FABBA.nl</title> 
	</head>
	<body>            