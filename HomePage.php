<?php
define('DBHOST', 'localhost');
define('DBNAME', 'music');
define('DBUSER', 'root');
define('DBPASS', '');
define('DBCONNSTRING',"mysql:host=" . DBHOST . ";dbname=" . DBNAME . ";charset=utf8mb4;");
//Top Genres
try{

$pdo = new PDO(DBCONNSTRING,DBUSER,DBPASS); 
 $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "SELECT SUM(song_id), genre_name, song_id";
        $sql .= " FROM songs";
        $sql .= " INNER JOIN genres ON songs.genre_id = genres.genre_id";
        $sql .= " GROUP BY genre_name";
        $sql .= " ORDER BY SUM(song_id) DESC";
        $sql .= " LIMIT 10";
        
        
    $result = $pdo->query($sql);
        $top_genres = $result->fetchAll(PDO::FETCH_ASSOC);
        $pdo = null;
    }
    catch (PDOException $e) {
        die( $e->getMessage());
    }
//Top Artist
try{

$pdo = new PDO(DBCONNSTRING,DBUSER,DBPASS); 
 $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "SELECT SUM(song_id), artist_name";
        $sql .= " FROM songs";
        $sql .= " INNER JOIN artists ON songs.artist_id = artists.artist_id";
        $sql .= " GROUP BY artist_name";
        $sql .= " ORDER BY SUM(song_id) DESC";
        $sql .= " LIMIT 10";
        
        
    $result = $pdo->query($sql);
        $top_artists = $result->fetchAll(PDO::FETCH_ASSOC);
        $pdo = null;
    }
    catch (PDOException $e) {
        die( $e->getMessage());
    }
//Most Popular Songs
try{

$pdo = new PDO(DBCONNSTRING,DBUSER,DBPASS); 
 $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "SELECT song_id, title, popularity, artist_name";
        $sql .= " FROM songs";
    $sql .= " INNER JOIN artists ON songs.artist_id = artists.artist_id";
        $sql .= " GROUP BY title";
        $sql .= " ORDER BY popularity DESC";
        $sql .= " LIMIT 10";
        
        
    $result = $pdo->query($sql);
        $MPS = $result->fetchAll(PDO::FETCH_ASSOC);
        $pdo = null;
    }
    catch (PDOException $e) {
        die( $e->getMessage());
    }
//One-hit Wonders
try{

$pdo = new PDO(DBCONNSTRING,DBUSER,DBPASS); 
 $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "SELECT COUNT(artist_id), artist_id, title, song_id";
        $sql .= " FROM songs";
        $sql .= " GROUP BY artist_id";
        $sql .= " HAVING COUNT(artist_id) > 1";
        $sql .= " LIMIT 10";
        
        
    $result = $pdo->query($sql);
        $OHW = $result->fetchAll(PDO::FETCH_ASSOC);
        $pdo = null;
    }
    catch (PDOException $e) {
        die( $e->getMessage());
    }
//Longest Acoustic Song
try{

$pdo = new PDO(DBCONNSTRING,DBUSER,DBPASS); 
 $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "SELECT title, acousticness, song_id";
        $sql .= " FROM songs";
        $sql .= " GROUP BY title";
        $sql .= " ORDER BY acousticness DESC";
        $sql .= " LIMIT 10";
        
        
    $result = $pdo->query($sql);
        $LAS = $result->fetchAll(PDO::FETCH_ASSOC);
        $pdo = null;
    }
    catch (PDOException $e) {
        die( $e->getMessage());
    }

//At the Club
try{

$pdo = new PDO(DBCONNSTRING,DBUSER,DBPASS); 
 $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "SELECT title, song_id, danceability, (danceability*1.6 + energy*1.4) AS DA";
        $sql .= " FROM songs";
        $sql .= " GROUP BY title";
        $sql .= " HAVING danceability > 80";
        $sql .= " ORDER BY DA DESC";
        $sql .= " LIMIT 10";
        
        
    $result = $pdo->query($sql);
        $ATC = $result->fetchAll(PDO::FETCH_ASSOC);
        $pdo = null;
    }
    catch (PDOException $e) {
        die( $e->getMessage());
    }
//Running Songs
try{

$pdo = new PDO(DBCONNSTRING,DBUSER,DBPASS); 
 $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "SELECT title, song_id, bpm, (energy*1.3 + valence*1.6) AS suitability";
        $sql .= " FROM songs";
        $sql .= " GROUP BY title";
        $sql .= " HAVING bpm > 120 AND bpm < 125";
        $sql .= " ORDER BY suitability DESC";
        $sql .= " LIMIT 10";
        
        
    $result = $pdo->query($sql);
        $RS = $result->fetchAll(PDO::FETCH_ASSOC);
        $pdo = null;
    }
    catch (PDOException $e) {
        die( $e->getMessage());
    }
//Studying
try{

$pdo = new PDO(DBCONNSTRING,DBUSER,DBPASS); 
 $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "SELECT title, song_id, bpm, speechiness,  ( (acousticness*0.8)+(100-speechiness)+(100-valence)) AS suitability";
        $sql .= " FROM songs";
        $sql .= " GROUP BY title";
        $sql .= " HAVING bpm > 100 AND bpm < 125 AND speechiness > 1 AND speechiness < 20";
        $sql .= " ORDER BY suitability DESC";
        $sql .= " LIMIT 10";
        
        
    $result = $pdo->query($sql);
        $studying = $result->fetchAll(PDO::FETCH_ASSOC);
        $pdo = null;
    }
    catch (PDOException $e) {
        die( $e->getMessage());
    }

function outputList($top_genres, $top_artists, $MPS, $OHW, $LAS, $ATC, $RS, $studying){
    echo "<table> <tr> 
    <th>Top Genres</th>
    <th>Top Artists</th>
    <th>Most Popular Songs</th>
    <th>One Hit Wonders</th>
    </tr>
    <tr>
    <td>";
    echo "<ul>";
    foreach ($top_genres as $row) {
      
        echo "<li>". $row['genre_name'] ."</li>";
    }
    echo "</ul>";
    echo "</td> 
    
    <td>";
    echo "<ul>";
    foreach ($top_artists as $row) {
        
        echo "<li>". $row['artist_name'] ."</li>";

    }
    echo "</ul>";
    echo "</td> 
    
    <td>";
    echo "<ul>";    
    foreach ($MPS as $row) {
        echo "<a href=TheSong.php?song_id=".$row['song_id'].">";  
        echo "<li>". $row['title']." Artist: ". $row['artist_name'] ."</li></a>";

    }
    echo "</ul>";
    echo "</td> 
    
    <td>";
    echo "<ul>";
    foreach ($OHW as $row) {
        echo "<a href=TheSong.php?song_id=".$row['song_id'].">";
        echo "<li>". $row['title'] ."</li></a>";

    }
    echo "<ul>";
    
    echo"</td>
  </tr>
  <tr> 
    <th>Longest Acoustic Songs</th>
    <th>At The Club</th>
    <th>Running Songs</th>
    <th>Studying</th>
    </tr>
    <tr>";
    echo "<tr><td><ul>";
    foreach ($LAS as $row) {
       echo "<a href=TheSong.php?song_id=".$row['song_id'].">"; 
        echo "<li>". $row['title'] ."</li></a>";
    }
    echo "</ul></td><td><ul>";
    foreach ($ATC as $row) {
        echo "<a href=TheSong.php?song_id=".$row['song_id'].">";
        echo "<li>". $row['title']."</li></a>";
    }
    echo "</ul></td><td></ul>";
    foreach ($RS as $row) {
        echo "<a href=TheSong.php?song_id=".$row['song_id'].">";
        echo "<li>". $row['title']."</li></a>";
    }
        echo "</ul></td><td><ul>";

     foreach ($studying as $row) {
        echo "<a href=TheSong.php?song_id=".$row['song_id'].">";
        echo "<li>". $row['title']."</li></a>";
    }
    echo"</ul></td>

  </tr></table";
    
    
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    
<title>COMP 3512 Assign1</title>
    
    <meta charset=utf-8>
    <link href='http://fonts.googleapis.com/css?family=Merriweather' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="style.css">
    
    </head>
    <body>

            <header> 
                <h1>COMP 3512 Assign1</h1>
                <h2>Lukas Priebe</h2>
        
                <a href="SearchPage.php">Search |</a>
                <a href="TheSong.php">Spotify Song </a>|<a href='BrowsePage.php?song_id'> Browse </a>|
        
            <a href="HomePage.php">Home</a></header>
            
        <form method="post" >
            <div><?php outputList($top_genres, $top_artists, $MPS, $OHW, $LAS, $ATC, $RS, $studying) ?></div><br/>    
        </form>
        
        <footer>COMP 3512, &copy; Lukas Priebe, <a href="https://github.com/pluka073/COMP3521-A1.git">GitHub Repo Link</a></footer>
        
    </body>
    
</html>
