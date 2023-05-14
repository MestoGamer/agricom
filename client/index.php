<!DOCTYPE html>
<html>
<head>
	<title>Chat</title>
	<style>
       * {
	        box-sizing: border-box;
	        margin: 0;
	        padding: 0;
        }

        .chat-container {
	        display: flex;
	        flex-direction: column;
	        height: 100vh;
        }

        .header {
	        background-color: #1a1a1a;
	        color: #fff;
	        padding: 20px;
        }

        .header h1 {
	        margin: 0;
        }

        .chat-area {
	        flex-grow: 1;
	        overflow-y: auto;
	        padding: 20px;
        }

        .chat-area ul {
	        list-style: none;
        }

        .admin-message {
	        background-color: #d1ecf1;
	        color: #0c5460;
	        margin-bottom: 10px;
	        padding: 10px;
	        border-radius: 10px;
        }

        .supplier-message {
	        background-color: #f8d7da;
	        color: #721c24;
	        margin-bottom: 10px;
	        padding: 10px;
	        border-radius: 10px;
        }

        .input-area {
	        display: flex;
	        background-color: #f2f2f2;
	        padding: 20px;
        }

        .input-area textarea {
	        flex-grow: 1;
	        resize: none;
	        padding: 10px;
	        margin-right: 10px;
	        border: none;
        }

        .input-area button {
	        background-color: #1a1a1a;
	        color: #fff;
	        border: none;
	        padding: 10px 20px;
	        cursor: pointer;
        }
    </style>
</head>
<body>

	<div class="chat-container">
		<div class="header">
			<h1>Chater avec vos Client</h1>
		</div>
		<div class="chat-area">
			<ul id="message-list">
				<?php
				$conn = mysqli_connect("localhost", "root", "", "pfe");
				$id=$_GET['id'];
				// Vérification de la connexion à la base de données
				if (!$conn) {
					die("Connexion échouée : " . mysqli_connect_error());
				}
				

				
				
				
				
				
				?>
			
			</ul>
		</div>
		<div class="input-area">
			<textarea id="message-input" placeholder="Type your message here"></textarea>
			<button id="send-button">Envoyer</button>
		</div>
	</div>

	<script>
   let id = '<?php echo $id ?>';
let messageList = document.getElementById("message-list");
let numMes = 0;
let messageInput = document.getElementById("message-input");
let sendButton = document.getElementById("send-button");

function fetchNewMessages() {
  let request = new XMLHttpRequest();
  let url = `fetch_chat.php?id=${id}`;
  if (numMes !== 0) {
    url += `&numMes=${numMes}`;
  }
  request.open('GET', url, true);
  request.onreadystatechange = function() {
    if (this.readyState === 4 && this.status === 200) {
      let messages = JSON.parse(this.responseText);
      // Add the fetched messages to the chat area
      messages.forEach(message => {
        let li = document.createElement("li");
        li.classList.add(message.from === 'ad' ? "admin-message" : "supplier-message");
        li.textContent = message.message;
        messageList.appendChild(li);
        numMes++;
      });
    }
  };
  request.send();
}
function sendMessage() {
  let message = messageInput.value.trim();
  if (message !== "") {
    let request = new XMLHttpRequest();
    let url = `insert_message.php?id=${id}&message=${message}`;
    request.open('GET', url, true);
    request.onreadystatechange = function() {
      if (this.readyState === 4) {
        if (this.status === 200) {
          // Clear the message input field
          messageInput.value = "";
          // Fetch new messages to update the chat area
          fetchNewMessages();
        } else {
          // Display an error message
          alert("Error: Could not send message");
        }
      }
    };
    request.send(null); // or request.send(body)
  } else {
    // Display an error message
    alert("Error: Message cannot be empty");
  }
}


// Fetch messages initially
fetchNewMessages();

// Fetch messages every 5 seconds
setInterval(fetchNewMessages, 5000);

// Send a message when the send button is clicked
sendButton.addEventListener("click", sendMessage);


</script>
</body>
</html>
