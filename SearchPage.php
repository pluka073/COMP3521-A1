<?php
define('DBHOST', 'localhost');
define('DBNAME', 'music');
define('DBUSER', 'root');
define('DBPASS', '');
//define('DBCONNSTRING',"mysql:host=" . DBHOST . ";dbname=" . DBNAME . ";charset=utf8mb4;");
define('DBCONNSTRING','sqlite:./databases/music.db');

try{

$pdo = new PDO(DBCONNSTRING,DBUSER,DBPASS); 
 $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "SELECT *";
        $sql .= " FROM Genres";
        $sql .= " ORDER BY genre_name";
        
        
    $result = $pdo->query($sql);
        $genres = $result->fetchAll(PDO::FETCH_ASSOC);
        $pdo = null;
    }
    catch (PDOException $e) {
        die( $e->getMessage());
    }
try{

$pdo = new PDO(DBCONNSTRING,DBUSER,DBPASS); 
 $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "SELECT *";
        $sql .= " FROM artists";
        $sql .= " ORDER BY artist_name";
        
        
    $result = $pdo->query($sql);
        $artists = $result->fetchAll(PDO::FETCH_ASSOC);
        $pdo = null;
    }
    catch (PDOException $e) {
        die( $e->getMessage());
    }
    

?>

<!DOCTYPE html>
<html lang="en">
<head>
<title>Search Page</title>
    
    <meta charset=utf-8>
    <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <main >
            <header class=""> <a href="TheSong.php">Spotify Song </a>|<a href='BrowsePage.php?song_id'> Browse </a>|
            <a href="HomePage.php">Home</a><a href="FavoritesPage.php"> | Favorites</a></header>
    <section >
        
        <form  method="GET" action="BrowsePage.php">
          <table >
              <tr><td>
              <input type="radio" id="rdbtn" name="rdbtn">
            <label for="title">Find by title: </label>
            <input type="text" id="title" placeholder="enter search title" name="title" />
                  </td></tr>
              <tr><td>
              <input type="radio" id="rdbtn" name="rdbtn">
              <label for="artist">Find by artist: </label>
              
              <select name="artist">
                  <option value=""></option>
                <?php foreach ($artists as $row)
                    {
                        echo '<option value="' . $row['artist_name'] . '">'; 
                     echo $row['artist_name']; 
                     echo "</option>"; 
                    }
                  ?>
        </select>
                  </td>
              <td>
              
                            <input type="radio" id="rdbtn" name="rdbtn">
              <label for="genre">Find by genre: </label>

              <select name="genre">
                  <option value=""></option>
                <?php foreach ($genres as $row)
                    {
                        echo '<option value="' . $row['genre_name'] . '">'; 
                     echo $row['genre_name']; 
                     echo "</option>"; 
                    }
                  ?>
        </select>
                  </td></tr>
              
              <tr><td>
              <label for="year">Find by Year: </label>
            <input type="text" id="year" placeholder="enter search year" name="year" />
                  </td>
              <td>
              <label for="pop">Find by Popularity: </label>
            <input type="text" id="pop" placeholder="enter search popularity" name="pop" />
                  </td></tr>
            
            
            <tr><td>
          <button class="small ui orange button" type="submit">
              <i class="filter icon"></i> Search 
          </button>   
                </td></tr>
            </table>
        </form>
        
          
    </section>
    

    <section >
      <?php
        if(isset($_GET['search'])){
            if(count($songs) > 0) {
                getSongs($songs);
            }
        }
                ?>
    </section>  
        </main>
        <footer>COMP 3512, &copy; Lukas Priebe, <a href="https://github.com/pluka073/COMP3521-A1.git">GitHub Repo Link</a></footer>
    </body>
</html>

