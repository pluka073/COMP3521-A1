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
 echo $row['title'] . "<br/>";
        echo $row['artist_name'] . "<br/>";
        echo $row['type_name'] . "<br/>";
        echo $row['genre_name'] . "<br/>";
     echo $row['year']."<br/>";
        echo $row['duration']."<br/>"; 
    echo "<div> BPM: ". $row['bpm'].", </div><br/>";
    echo "<div> energy: ". $row['energy'].", </div><br/>";
        echo "<div> danceability: ". $row['danceability'].", </div><br/>";
        echo "<div> liveness: ". $row['liveness'].", </div><br/>";
        echo "<div> valence: ". $row['valence'].", </div><br/>";
        echo "<div> acousticness: ". $row['acousticness'].", </div><br/>";
        echo "<div> speechiness: ". $row['speechiness'].", </div><br/>";
        echo "<div> popularity: ". $row['popularity'].", </div><br/>";
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
<title>The Song</title>
    
    <meta charset=utf-8>
    <link href='http://fonts.googleapis.com/css?family=Merriweather' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.4.1/semantic.min.css" rel="stylesheet">
    </head>
    <body>
        <main class="ui segment doubling stackable grid container">
            <header class=""> <a href="TheSong.php">Spotify Song</a><a href='BrowsePage.php?song_id'>Browse</a></header>
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

