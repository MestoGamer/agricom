<?php
$conn = mysqli_connect("localhost", "root", "", "pfe");

if (!$conn) {
    die("Connexion échouée : " . mysqli_connect_error());
}

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $message = $_GET['message'];
    $id = $_GET['id'];
    
    $sql = "INSERT INTO chat (message,typeReseau,`from`, pointB ) VALUES ('$message','1','ad', '$id')";
    if (mysqli_query($conn, $sql)) {
        echo "Message inséré avec succès";
    } else {
        echo "Erreur : " . mysqli_error($conn);
    }
} else {
    echo "Erreur : cette page ne peut être appelée que par une requête POST";
}

mysqli_close($conn);
?>
