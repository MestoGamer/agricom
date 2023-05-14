<?php
$conn = mysqli_connect("localhost", "root", "", "pfe");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$sql = "SELECT id_four, nom_entre , online FROM fournisseur";
$result = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Chat List</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-Rlcuk5/G5w6JyNIO+5S6P5E3HJhMRLnRDnLc7L1BQf1Q7wDhImluDD7VDTG2Y9fRZAgLzJ0C+fGtTzfpncqHyw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
     /* Set default font styles */
/* Set default font styles */
body {
  font-family: Arial, sans-serif;
  font-size: 14px;
  line-height: 1.5;
  color: #333;
  background-color: #f7f7f7;
}

/* Center the page content */
.container {
  max-width: 1100px;
  margin: 0 auto;
  padding: 20px;
  background-color: #fff;
  box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
  border-radius: 5px;
  display: flex; /* added this property to make the container a flexbox */
  flex-wrap: wrap; /* added this property to allow flex items to wrap to the next line */
  justify-content: space-between; /* added this property to distribute the chat lists along the row */
}

/* Style the chat lists */
.chat-list {
  margin-bottom: 20px;
  padding: 10px;
  border: 1px solid #ccc;
  border-radius: 5px;
  width: calc(50% - 10px); /* added this property to make each chat list occupy 50% of the container width and subtract 10px to account for the margin between them */
  box-sizing: border-box; /* added this property to include padding and border in the element's total width */
}

/* Style the chat list headings */
.chat-list h2 {
  margin: 0;
  font-size: 18px;
  font-weight: bold;
  text-transform: uppercase;
  letter-spacing: 1px;
  color: #333;
}

/* Style the list items */
.chat-list ul {
  list-style-type: none;
  margin: 0;
  padding: 0;
}

.chat-list li {
  border-bottom: 1px solid #ccc;
  padding: 10px;
  display: flex;
  align-items: center;
}

.chat-list li:last-child {
  border-bottom: none;
}

/* Style the links */
.chat-list a {
  color: #333;
  text-decoration: none;
  font-weight: bold;
  margin-left: 10px;
}

/* Hover effect for links */
.chat-list a:hover {
  color: #666;
}
.sidebar {
  width: 18%;
  margin-left: 20px;
  padding: 20px;
  background-color: #fff;
  box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
  border-radius: 5px;
  position: fixed;
  top: 0;
  right: 0;
}
.fa-circle {
  color: #00cc00; /* change the color to a darker green */
  font-size: 10px; /* change the size of the dot */
  margin-right: 10px; /* adjust the margin to your preference */
}



    </style>
  </head>
  <body>
  <h1>Chat List</h1>
  

  <div class="container">
  <div class="chat-list">
    <h2>Fournisseur Chat</h2>
    <ul>
      <?php
      if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
          echo "<li>";
          if ($row["online"] == 'true') {
            echo "<div style='background-color: green; border-radius: 50%; width: 10px; height: 10px; margin-right: 10px;'></div>";
          }
          echo "<a href='fourni/index.php?id=" . $row["id_four"] . "'>" . $row["nom_entre"] . "</a></li>";
        }
        
      } else {
        echo "<li>No users found</li>";
      }
      ?>
    </ul>
  </div>
  <div class="chat-list">
    <h2>Client Chat</h2>
    <ul>
      <?php
      $sql = "SELECT id_client, nom,prenom, online FROM client";
      $result = mysqli_query($conn, $sql);
      if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
          echo "<li>";
          if ($row["online"] == 'true') {
            echo "<div style='background-color: green; border-radius: 50%; width: 10px; height: 10px; margin-right: 10px;'></div>";
          }
          echo "<a href='client/index.php?id=" . $row["id_client"] . "'>" . $row["nom"] . " " . $row["prenom"] . "</a></li>";
        }        
      } else {
        echo "<li>No users found</li>";
      }
      ?>
    </ul>
  </div>
</div>
<div class="sidebar">
  <h2>Nouveau Messages</h2>
  <ul>
    <!-- List of messages will be added here dynamically -->
    <?php
          $sql = "
          SELECT c.typeReseau, c.pointB, c.message
FROM chat c
INNER JOIN (
  SELECT pointB, MAX(date) AS last_date
  FROM chat
  GROUP BY pointB
) l ON c.pointB = l.pointB AND c.date = l.last_date 
WHERE c.from != 'ad'
GROUP BY c.pointB;

          ";
          $result = mysqli_query($conn, $sql);
          if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                if($row['typeReseau']=='1'){
                    $sql = "SELECT nom_entre FROM fournisseur WHERE id_four=".$row['pointB'];
          $resultt = mysqli_query($conn, $sql);
          if (mysqli_num_rows($resultt) > 0) {
            while ($rowt = mysqli_fetch_assoc($resultt)) {
                echo "
            <li>
        <strong>Fourni</strong>   
        <strong>".$rowt['nom_entre']."</strong>
        <span>".$row['message']."</span>
            </li>
              " ;
            }}
                }else{
                    $sql = "SELECT nom,prenom FROM Client WHERE id_client=".$row['pointB'];
          $resultt = mysqli_query($conn, $sql);
          if (mysqli_num_rows($resultt) > 0) {
            while ($rowt = mysqli_fetch_assoc($resultt)) {
                echo "
            <li>
        <strong>Client</strong>   
        <strong>".$rowt['nom']." ".$rowt['prenom']."</strong>
        <span>".$row['message']."</span>
            </li>
              ";
            }}
                }
              
            }
          } else {
            echo "<li>No users found</li>";
          }
          ?>
    
  </ul>
</div>
<!-- Add this script tag to the bottom of the body element -->


</body>
</html>
<!-- Close the database connection -->
<?php
mysqli_close($conn);
?>   