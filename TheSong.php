<?php
define('DBHOST', 'localhost');
define('DBNAME', 'music');
define('DBUSER', 'root');
define('DBPASS', '');
define('DBCONNSTRING',"mysql:host=" . DBHOST . ";dbname=" . DBNAME . ";charset=utf8mb4;");

$conn = mysqli_connect(DBHOST,DBUSER,DBPASS,DBNAME);
if(isset($_GET['song_id']))
{
    $songs = findSongs($_GET['song_id']);
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
        $sql .= " WHERE song_id LIKE ?";  
        
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
function outputSongs($songs){
   /*if ($result->num_rows > 0)
{
    while($row = $result->fetch_assoc()){
        
        echo '<div>'."Title: ".$row["title"]. "Artist: ".$row["artist_name"]. "Genre: ".$row["genre_name"].'</div> </br>';
        }
} */
    foreach ($songs as $row) {
        echo"<table> 
        <tr>
            <th><i class='material-icons'>album</i>Title:</th>
            <th><i class='material-icons'>person</i>Artist: </th>
            <th><i class='material-icons'>title</i>Artist Type: </th>
        </tr>
            <tr>";
            echo "<td>".$row['title'] . "</td>";
            echo "<td>".$row['artist_name'] . "</td>";
            echo "<td>".$row['type_name'] . "</td>";
        echo "</tr>
        
        <tr>
            <th><i class='material-icons'>category</i>Genre: </th>
            <th><i class='material-icons'>event</i>Year Released:</th>
            <th><i class='material-icons'>timer</i>Duration:</th>
            </tr>
            <tr>";
        echo "<td>".$row['genre_name'] . "</td>"; 
        echo "<td>".$row['year']."</td>";
        echo "<td>".$row['duration']."</td></tr>";
        
        
        echo  "<tr>
                    <th><i class='material-icons'>hourglass_top</i>BPM</th>
                    <th><i class='material-icons'>electric_bolt</i>energy</th>
                    <th><i class='material-icons'>nightlife</i>danceability </th>
                    <th><i class='material-icons'>celebration</i>liveness </th>
                </tr>
                </table>
                <table>
                <tr>" ;
        echo "<td>". $row['bpm']." </td>";
        echo "<td>". $row['energy']." </td>";
        echo "<td>". $row['danceability']." </td>";
        echo "<td>". $row['liveness']." </td>
        
                </tr>";
        
        echo "<tr>
                <th><i class='material-icons'>battery_full</i>valence</th>
                <th><i class='material-icons'>lyrics</i>acousticness</th>
                <th><i class='material-icons'>mic</i>speechiness</th>
                <th><i class='material-icons'>star</i> popularity</th>
            </tr>
         
                <tr>";
            
        echo "<td>"    . $row['valence'].", </td>";
        echo "<td>  ". $row['acousticness'].", </td>";
        echo "<td>  ". $row['speechiness'].", </td>";
        echo "<td>  ". $row['popularity'].", </td>";
        echo"<table>";
 } 
} 

$conn->close();

?>

<!DOCTYPE html>
<html lang="en">
<head>
<title>The Song</title>
    
    <meta charset=utf-8>
    <link rel='stylesheet' href="style.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    </head>
    <body>
        <main class="ui segment doubling stackable grid container">
            <header class=""> <a href="TheSong.php">Spotify Song </a><a href='BrowsePage.php?song_id'>Browse</a>
            <a href="HomePage.php">Home</a></header>
    <section class="four wide column">
        <form class="ui form" method="post" >
          <h3 class="ui dividing header">Filters</h3>

          <div class="field">
            <label>Find song: </label>
            
          
            </div> 
        </form>
    </section>
    <section>
        <?php
        if(isset($_GET['song_id'])){
            if(count($songs) > 0) {
                outputSongs($songs);
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

