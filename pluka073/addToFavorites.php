<?php 
// ensure sessions works on this page
session_start(); 
 
// does session already exist?
if ( !isset($_SESSION["Favorites"]) ) { 
 // initialize an empty array that will contain the favorites
 $_SESSION["Favorites"] = []; 
} 
 
// retrieve favorites array for this user session
$favorites = $_SESSION["Favorites"]; 
 
// now add passed painting id to our favorites array
$favorites[] = $_GET["song_id"]; 
 
// then resave modified array to session state
$_SESSION["Favorites"] = $favorites; 
 
// finally redirect to favorites page
header("Location: FavoritesPage.php"); 
 
?> 