<?php require_once('config.inc.php'); ?>

<!DOCTYPE html>
<html>
<body>
<h1>Database Tester (mysqli)</h1>
Genre: 
<?php 
 
$connection = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME); 
if ( mysqli_connect_errno() ) { 
 die( mysqli_connect_error() ); 
} 
$sql = "select Title, artists.artist_name, types.type_name, genres.genres_name, year, duration 
        from songs INNER JOIN songs ON genres = songs.genre_id 
                    INNER JOIN songs ON artists.artist_id = songs.artist_id 
                    INNER JOIN artists ON types.type_id = artists.artist_type_id
        where song_id = $song_id";
    
if ($result = mysqli_query($connection, $sql)) { 
 foreach ($result as $row) { 
 echo $row[0] . " - " . $row['LastName'] . "<br/>"; 
}
 // release the memory used by the result set
 mysqli_free_result($result); 
} 
 
// close the database connection
mysqli_close($connection); 
?> 
    
    <p>title, name, artist, genre, year, duration</p>
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