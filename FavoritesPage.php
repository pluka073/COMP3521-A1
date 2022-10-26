<?php
define('DBHOST', 'localhost');
define('DBNAME', 'music');
define('DBUSER', 'root');
define('DBPASS', '');
define('DBCONNSTRING',"mysql:host=" . DBHOST . ";dbname=" . DBNAME . ";charset=utf8mb4;");

$conn = mysqli_connect(DBHOST,DBUSER,DBPASS,DBNAME);

if ($conn->connect_error) {
    die("Connection failed: ". $conn-> connect_error);
}

session_start();

if ( !isset($_SESSION["Favorites"]) ) { 
 $_SESSION["Favorites"] = []; 
} 
    $favorites = $_SESSION["Favorites"];

function findSongs($search) {
    try{
        
        $pdo = new PDO(DBCONNSTRING,DBUSER,DBPASS);
        $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        
        $sql = "SELECT *";
        $sql .= " FROM songs";
        $sql .= " INNER JOIN genres ON songs.genre_id = genres.genre_id";
        $sql .= " INNER JOIN artists ON songs.artist_id = artists.artist_id";
        $sql .= " INNER JOIN types ON artists.artist_type_id = types.type_id";
        $sql .= " WHERE song_id LIKE ?";  
        
        $statement = $pdo->prepare($sql);
        $statement->bindValue(1, $search);
        $statement->execute();
        
        $songs = $statement->fetchAll(PDO::FETCH_ASSOC);
        $pdo = null;
        return $songs;
    }
    catch (PDOException $e) {
        die( $e->getMessage());
    }
}

              
?>
<!DOCTYPE html>
<html lang=en>
<head>
    <title>Favorites Page</title>
    <meta charset=utf-8>
    <link rel=stylesheet href="style.css">
    </head>
    <body>
        <main class="ui segment doubling stackable grid container">
            <header class=""> <a href="TheSong.php">Spotify Song </a>|<a href='SearchPage.php'> Search </a>|
            <a href="HomePage.php">Home</a></header>

   
      <h1 class="sm:text-3xl text-2xl font-medium title-font text-gray-900">Favorites</h1>
      <ul class="flex flex-col divide divide-y">
          
          <a href=emptyFavorites.php?song_id=.<?php$row['song_id']? > <button class='rm' type='button'>
              <i class='filter icon'></i> Remove All 
          </button></a>

<?php
            foreach ($favorites as $fav) { 
 // retrieve the painting for this id
                if ( isset($fav)){
            $songs = findSongs($fav);
                }
            foreach($songs as $row){
    ?>

                        <?php echo "<table style='width:100%'>
              <tr>
                <th>Title</th>
                <th>Artist</th>
                <th>Genre</th>
                <th>Year</th>
                <th>Popularity</th>
                <th></th>
                <th></th>
              </tr>";
    
        
        echo " <tr> <td> <a href=TheSong.php?song_id=".$row['song_id'].">". $row['title'] . "</a></td>";
        
        echo "<td>".$row['artist_name'] . "</td> ";
        
        echo " <td>".$row['genre_name'] . "<td/> ";
        
        echo " <td>".$row['year']."<td/>";
        
        echo " <td>". $row['popularity']."</td> ";
        
        
        echo "<td><a href=TheSong.php?song_id=".$row['song_id'].">
            <button class='small ui blue button' type='button'>
              <i class='filter icon'></i> View 
                </button></a></td>";
        
        echo "<td> <a href=emptyFavorites.php?song_id=".$row['song_id']."> <button class='small ui blue button' type='button'>
              <i class='filter icon'></i> Remove 
          </button></a></td></tr>";
                
    echo "</table>"; 
            }
}
?> 
      </ul>
   



</main>
   
</body>
</html>