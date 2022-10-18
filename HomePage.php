<?php require_once('config.inc.php'); ?>
<!DOCTYPE html>

<html>
   
<head>
    <meta charset="utf-8"/>  
    <title>Home Page</title>   
    
</head>
<body>
        <header>Header</header>
    <div></div>
    <br>
    <select>
<?php  
$connection = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME); 
if ( mysqli_connect_errno() ) { 
 die( mysqli_connect_error() ); 
} 
 
$sql = "select * from songs order by popularity"; 
 
if ($result = mysqli_query($connection, $sql)) { 
 while($row = mysqli_fetch_assoc($result)) 
 { 
 echo '<option value="' . $row['genre_id'] . '">'; 
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
   
    </body>
</html>
    