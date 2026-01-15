<?php

$host = "localhost" ;           //Datenbank-Host
$user = "root" ;                //Datenbank-Benutzer
$password ="";                  //Datenbank-Passwort
$database = "users_db";         //Datenbank-Name

$conn = new mysqli($host, $user, $password, $database);     //Erstellt DB-Verbindung

if($conn->connect_error)        //Prüft, ob Verbindung fehlgeschlagen ist
    {
        die("Connection failed: ".$conn->connect_error);    //Skript abbrechen bei Fehler
    }
?>