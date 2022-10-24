<?php
define('DBHOST', 'localhost');
define('DBNAME', 'music');
define('DBUSER', 'root');
define('DBPASS', '');
define('DBCONNSTRING',"mysql:host=" . DBHOST . ";dbname=" . DBNAME . ";charset=utf8mb4;");

$conn = mysqli_connect(DBHOST,DBUSER,DBPASS,DBNAME);
if(isset($_GET['search']))
{
    $songs = findSongs($_GET['search']);
}
if ($conn->connect_error) {
    die("Connection failed: ". $conn-> connect_error);
}
function findSongs($search) {
    try{
        
        $pdo = new PDO(DBCONNSTRING,DBUSER,DBPASS);
        $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        /*$sql = "song_id, title, artists.artist_name, genres.genre_name, year FROM songs INNER JOIN artists ON songs.artist_id = artists.artist_id INNER JOIN genres ON songs.genre_id = genres.genre_id WHERE song_id=?";*/
        
        $sql = "SELECT *";
        $sql .= " FROM songs";
        $sql .= " INNER JOIN genres ON songs.genre_id = genres.genre_id";
        $sql .= " INNER JOIN artists ON songs.artist_id = artists.artist_id";
        $sql .= " INNER JOIN types ON artists.artist_type_id = types.type_id";
        $sql .= " WHERE search LIKE ?";  
        
        $statement = $pdo->prepare($sql);
        $statement->bindValue(1, '%' . $search.'%');
        $statement->execute();
        
        $songs = $statement->fetchAll(PDO::FETCH_ASSOC);
        $pdo = null;
        return $songs;
    }
    catch (PDOException $e) {
        die( $e->getMessage());
    }
}
function getSong_id($songs){
    foreach ($songs as $row) { 
    return $row['search'] ;
    }
    
       
} 
/*$sql = "SELECT song_id, title, artists.artist_name, genres.genre_name, year FROM songs INNER JOIN artists ON songs.artist_id = artists.artist_id INNER JOIN genres ON songs.genre_id = genres.genre_id WHERE artists.artist_name='Logic'";*/



/*else {
    echo "0 results";
}*/

$conn->close();

?>

<!DOCTYPE html>
<html lang="en">
<head>
<title>Search Page</title>
    
    <meta charset=utf-8>
    <link href='http://fonts.googleapis.com/css?family=Merriweather' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.4.1/semantic.min.css" rel="stylesheet">
    </head>
    <body>
        <main class="ui segment doubling stackable grid container">
            <header class=""> <a href="TheSong.php">Spotify Song</a><a href='BrowsePage.php?song_id'>Browse</a></header>
    <section class="four wide column">
        
        <form class="ui form" method="GET" action="BrowsePage.php">
          <h3 class="ui dividing header">Filters</h3>

          <div class="field">
              <input type="radio" id="rdbtn" name="rdbtn">
            <label for="title">Find by title: </label>
            <input type="text" id="title" placeholder="enter search title" name="search" />
              <input type="radio" id="rdbtn" name="rdbtn">
              <label for="artist">Find by artist: </label>
              
            
          </div> 
          <button class="small ui orange button" type="submit">
              <i class="filter icon"></i> Filter 
          </button>   
                
        </form>
        
        <select>
<?php 
  
if ($result = mysqli_query($connection, $sql)) { 
 while($row = mysqli_fetch_assoc($result)) 
 { 
 echo '<option value="' . $row['artists.artist_name'] . '">'; 
 echo $row['artists.artist_name']; 
 echo "</option>"; 
 } 
 // release the memory used by the result set
 mysqli_free_result($result); 
} 
 
// close the database connection
mysqli_close($connection); 
?> 
</select>
    </section>
    

    <section class="twelve wide column">
      <?php
        if(isset($_GET['search'])){
            if(count($songs) > 0) {
                getSongs($songs);
            }
            else {
                echo "naurrrrrrr". $_POST['search'];
            }
        }
        else {
            echo "Yar";
        }
        ?>
    </section>  
        </main>
    </body>
</html>

