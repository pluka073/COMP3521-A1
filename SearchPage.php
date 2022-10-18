<?php require_once('config.inc.php'); ?>
<!DOCTYPE html>

<html>
   
<head>
    <meta charset="utf-8"/>  
    <title>Single Song</title>   
    
</head>
<body>
        <header>Header</header>
    <input type="radio" id="title" name="Title">
    <label for="title">Title</label>
    <select>
<?php 
 
$connection = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME); 
if ( mysqli_connect_errno() ) { 
 die( mysqli_connect_error() ); 
} 
 
$sql = "select * from songs order by artist_id"; 
 
if ($result = mysqli_query($connection, $sql)) { 
 while($row = mysqli_fetch_assoc($result)) 
 { 
 echo '<option value="' . $row['title'] . '">'; 
 echo $row['title']; 
 echo "</option>"; 
 } 
    
 // release the memory used by the result set
 mysqli_free_result($result); 
}
 
// close the database connection
mysqli_close($connection); 

?> 
</select>
    <br>
    <input type="radio" id="artist" name="Artist">
    <label for="artist">Artist</label>
    <select>
<?php 
 
$connection = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME); 
if ( mysqli_connect_errno() ) { 
 die( mysqli_connect_error() ); 
} 
 
$sql = "select * from artists order by artist_id"; 
 
if ($result = mysqli_query($connection, $sql)) { 
 while($row = mysqli_fetch_assoc($result)) 
 { 
 echo '<option value="' . $row['artist_id'] . '">'; 
 echo $row['artist_name']; 
 echo "</option>"; 
 } 
    
 // release the memory used by the result set
 mysqli_free_result($result); 
}
 
// close the database connection
mysqli_close($connection); 

?> 
</select>

    <input type="radio" id="genre" name="Genre">
    <label for="genre">Genres</label>
     <select>
<?php 
 
$connection = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME); 
if ( mysqli_connect_errno() ) { 
 die( mysqli_connect_error() ); 
} 
 
$sql = "select * from genres order by genre_name"; 
 
if ($result = mysqli_query($connection, $sql)) { 
 while($row = mysqli_fetch_assoc($result)) 
 { 
 echo '<option value="' . $row['genre_id'] . '">'; 
 echo $row['genre_name']; 
 echo "</option>"; 
 } 
    
 // release the memory used by the result set
 mysqli_free_result($result); 
}
 
// close the database connection
mysqli_close($connection); 

?> 
</select>
<br>
    <input type="radio" id="year" name="Year">
    <label for="year">Year</label>
    <input type="radio" id="pop" name="popularity">
    <label for="pop">Popularity</label>
    <br>
    <button>Search
    </button>
       
    </body>
</html>
    