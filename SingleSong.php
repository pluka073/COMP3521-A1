<?php require_once('config.inc.php'); ?>
<!DOCTYPE html>
<html>
<body>
<h1>Database Tester (mysqli)</h1>
Genre: 
<select>
<?php 
 
$connection = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME); 
if ( mysqli_connect_errno() ) { 
 die( mysqli_connect_error() ); 
} 
 
$sql = "select * from genres"; 
 
if ($result = mysqli_query($connection, $sql)) { 
 while($row = mysqli_fetch_assoc($result)) 
 { 
 echo '<option value="' . $row['GenreID'] . '">'; 
 echo $row['GenreName']; 
 echo "</option>"; 
 } 
 // release the memory used by the result set
 mysqli_free_result($result); 
} 
 
// close the database connection
mysqli_close($connection); 
?> 
</select>
</body>
</html>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>  
    <title>Single Song</title>   
    
</head>
<body>
    <header>Header</header>
    <div>Song Information</div>
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