<?php 
// ensure sessions works on this page
session_start(); 
 
// resave empty array to session state
$_SESSION["Favorites"] = []; 
 
// redirect to favorites page
header("Location: FavoritesPage.php"); 
 
?>