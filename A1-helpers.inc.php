<?php 

function outputSongs($results) {
    if($results){
    foreach($results as $row) {
        outputSingleSong($row);
    }
    }
}

function outputSingleSong($row){
    echo $row['title']. '</br>';
    
    
}

?>