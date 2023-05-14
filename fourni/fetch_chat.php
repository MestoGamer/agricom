<?php
$conn = mysqli_connect("localhost", "root", "", "pfe");
$id = $_GET['id'];
$numMes = isset($_GET['numMes']) ? $_GET['numMes'] : 0;

// Vérification de la connexion à la base de données
if (!$conn) {
    die("Connexion échouée : " . mysqli_connect_error());
}

// Select messages from the database
$sql = "SELECT * FROM chat WHERE typeReseau='1' AND pointB='$id'";
$sql .= " ORDER BY date";

$result = mysqli_query($conn, $sql);
$numOfNewMessages = mysqli_num_rows($result);
if($numOfNewMessages>$numMes){
    // Create an empty array to store the messages
    $messages = array();
    $counter=0;
    // Loop through each message and add it to the array
    while ($row = mysqli_fetch_assoc($result)) {
        
        $counter++;
        if($counter>$numMes){
            $messages[] = $row;
            if($row['vue']=="false"){
                
                //update vue row to true instead of false
                $update_sql = "UPDATE chat SET vue='true' WHERE id_mess='".$row['id_mess']."';";
                mysqli_query($conn, $update_sql);
            }
        }
        
    }
    
    // Convert the array to JSON format and return it
    echo json_encode($messages);
}


?>