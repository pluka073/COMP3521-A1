<?php
define('DBHOST', 'localhost');
define('DBNAME', 'music');
define('DBUSER', 'root');
define('DBPASS', '');
//define('DBCONNSTRING',"mysql:host=" . DBHOST . ";dbname=" . DBNAME . ";charset=utf8mb4;");
define('DBCONNSTRING','sqlite:./databases/music.db');

if(isset($_GET['title'], $_GET['artist'], $_GET['genre'], $_GET['year'], $_GET['pop']))
{
    $songs = findSongs($_GET['title'], $_GET['artist'], $_GET['genre'], $_GET['year'], $_GET['pop']);
}

try{
$pdo = new PDO(DBCONNSTRING,DBUSER,DBPASS); 
 $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "SELECT *";
        $sql .= " FROM songs";
        $sql .= " INNER JOIN genres ON songs.genre_id = genres.genre_id";
        $sql .= " INNER JOIN artists ON songs.artist_id = artists.artist_id";
        $sql .= " INNER JOIN types ON artists.artist_type_id = types.type_id";
        
        
    $result = $pdo->query($sql);
        $all_songs = $result->fetchAll(PDO::FETCH_ASSOC);
        $pdo = null;
    }
    catch (PDOException $e) {
        die( $e->getMessage());
    }
function findSongs($title, $artist, $genre, $year, $pop) {
    try{
        $pdo = new PDO(DBCONNSTRING,DBUSER,DBPASS);
        $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        
        $sql = "SELECT *";
        $sql .= " FROM songs";
        $sql .= " INNER JOIN genres ON songs.genre_id = genres.genre_id";
        $sql .= " INNER JOIN artists ON songs.artist_id = artists.artist_id";
        $sql .= " INNER JOIN types ON artists.artist_type_id = types.type_id";
        $sql .= " WHERE title = ? OR "; 
        $sql .= "artists.artist_name = ? OR ";
        $sql .= "genres.genre_name = ? OR ";
        $sql .= "year LIKE ?  OR ";
        $sql .= "popularity LIKE ?";  
        
        $statement = $pdo->prepare($sql);
        $statement->bindValue(1,$title);
        $statement->bindValue(2,$artist);
        $statement->bindValue(3,$genre);
        $statement->bindValue(4,$year);
        $statement->bindValue(5,$pop);
        $statement->execute();
        
        $songs = $statement->fetchAll(PDO::FETCH_ASSOC);
        $pdo = null;
        return $songs;
    }
    catch (PDOException $e) {
        die( $e->getMessage());
    }
}

function outputSongs($songs){

    echo "<table>
  <tr>
    <th>Title</th>
    <th>Artist</th>
    <th>Genre</th>
     <th></th>
    <th>Year</th>
    <th></th>
    <th>Popularity</th>


    

  </tr>";
    foreach ($songs as $row) {
        
        echo " <tr> <td> <a href=TheSong.php?song_id=".$row['song_id'].">". $row['title'] . "</a></td>";
        
        echo "<td>".$row['artist_name'] . "</td> ";
        
        echo "<td>".$row['genre_name'] . "<td/> ";
        
        echo "<td>".$row['year']."<td/>";
        
        
        echo "<td>". $row['popularity']."</td> ";
        
        echo "<td><a href=TheSong.php?song_id=".$row['song_id'].">
            <button>
              <i class='material-icons'>pageview</i> View 
                </button></a></td>";
        
        echo "<td> <a href=addToFavorites.php?song_id=".$row['song_id']."> <button > <i class='material-icons'>star</i>
               Favourite 
          </button></a></td></tr>";
 } 
    echo "</table>";
} 
/*$sql = "SELECT song_id, title, artists.artist_name, genres.genre_name, year FROM songs INNER JOIN artists ON songs.artist_id = artists.artist_id INNER JOIN genres ON songs.genre_id = genres.genre_id WHERE artists.artist_name='Logic'";*/



/*else {
    echo "0 results";
}*/


?>

<!DOCTYPE html>
<html lang="en">
<head>
<title>The Song</title>
    <meta charset=utf-8>
    <link rel=stylesheet href="style.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    </head>
    <body>
        <main>
            <header class=""> <a href="TheSong.php">Spotify Song </a>|<a href='SearchPage.php'> Search </a>|
            <a href="index.php">Home</a> <a href="FavoritesPage.php"> | Favorites</a></header>
    <section>
        <form method="post" >

          <div class="field">
            
          
          </div>   
            <a href="BrowsePage.php">
             <button  type="button" name="search">
               Show All 
          </button>
            </a>
            
            <!--<a href='TheSong.php?song_id='>
            <button class="small ui blue button" type="button">
              <i class="filter icon"></i> View 
                </button></a>-->
             
        </form>
    </section>
    <section>
        <?php
        if(isset($_GET['title'], $_GET['artist'], $_GET['genre'], $_GET['year'], $_GET['pop'])){
            if(count($songs) > 0) {
                outputSongs($songs);
            }
            else {
                echo "Error Not Found ". $_GET['title'];
            }
        }
        else {
            outputSongs($all_songs);;
        }
        ?>
        
        </section>
        </main>
        <footer>COMP 3512, &copy; Lukas Priebe, <a href="https://github.com/pluka073/COMP3521-A1.git">GitHub Repo Link</a></footer>
    </body>
</html>

