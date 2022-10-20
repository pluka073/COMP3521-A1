<?php require_once('config.inc.php'); 
require_once('A1-db-classes.inc.php');
require_once('A1-helpers.inc.php');

try { 
 $conn = DatabaseHelper::createConnection(array(DBCONNSTRING, 
 DBUSER, DBPASS)); 
if (isset($_GET['id']) && $_GET['id'] > 0){
 $songGateway = new SongDB($conn); 
 $songs = $songGateway->getAllForSong($_GET['id']);
}
else{
    $songs = null;
}
} catch (Exception $e) { 
 die( $e->getMessage() ) ;
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Single Song</title>
    </head>
<body>

    
    <?php 
 
$connection = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME); 
if ( mysqli_connect_errno() ) { 
 die( mysqli_connect_error() ); 
} 
$sql = "select song_id, title 
        from songs";
    
 // release the memory used by the result set
 
 
 
// close the database connection
mysqli_close($connection); 
?> 
    
    <?php outputSingleSong($songs)?>
    <br>
    <h2>Analysis Data:</h2>
    <ul>
    <li>bpm,</li>
    <li>energy,</li>
    <li>danceability,</li>
    <li>liveness,</li>
    <li>valence,</li>
   <li>acousticness,</li> 
    <li>speechiness,</li>
   <li>popularity</li>
    </ul>
    <footer></footer>
    </body>
</html>