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
/*function outputSongs(){

    echo "<table style='width:100%'>
  <tr>
    <th>Title</th>
    <th>Artist</th>
    <th>Genre</th>
    <th>Year</th>
    <th>Popularity</th>
    <th></th>
    <th></th>
  </tr>";
    
    foreach ($favorites as $fav) {
        $row = findSongs($fav);
        
        echo " <tr> <td> <a href=TheSong.php?song_id=".$row['song_id'].">". $row['title'] . "</a></td>";
        
        echo "<td>".$row['artist_name'] . "</td> ";
        
        echo " <td>".$row['genre_name'] . "<td/> ";
        
        echo " <td>".$row['year']."<td/>";
        
        echo " <td>". $row['popularity']."</td> ";
        
 } 
    echo "</table>";
} */
              
?>
<!DOCTYPE html>
<html lang=en>
<head>
    <title>Favorites Page</title>
    <meta charset=utf-8>
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
    <link href="css/tailwind.css" rel="stylesheet">
	 <link href="css/lab15-ex04.css" rel="stylesheet">
	 <style>

	 </style>
</head>
<body >  

<main class="container px-5 py-24 mx-auto">

   <div class="flex flex-col text-center w-full mb-20">
      <a class="text-xs text-yellow-500 tracking-widest font-medium title-font mb-1" href="BrowsePage.php">Return to list</a>
      <h1 class="sm:text-3xl text-2xl font-medium title-font text-gray-900">Favorites</h1>
    </div>
    <div class="container flex flex-col mx-auto w-full items-center justify-center bg-white dark:bg-gray-800 rounded-lg shadow">
      <ul class="flex flex-col divide divide-y">

<?php
            foreach ($favorites as $fav) { 
 // retrieve the painting for this id
                if ( isset($fav)){
            $songs = findSongs($fav); 
                }
    ?>


            <li class="flex flex-row">
                  <div class="select-none cursor-pointer flex flex-1 items-center p-4">
                     <div class="flex flex-col w-10 h-10 justify-center items-center mr-4">
                        <?php echo $songs['song_id']?>
                       
                     </div>
                  </div>
            </li>

<?php
                
}
?> 
      </ul>
   </div>

   <a class="no-underline text-yellow-700 hover:text-yellow-500 text-xs font-bold uppercase inline-block mt-4 px-3 py-2 bg-gray-800 rounded " href="emptyFavorites.php" 
       >
				Empty Favorites
   </a>


</main>
   
</body>
</html>