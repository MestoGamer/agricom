<?php
// Replace this with your own code to fetch the list of messages from the database
$messages = [
  ['sender' => 'John Doe', 'text' => 'Hello, how are you?'],
  ['sender' => 'Jane Smith', 'text' => 'I\'m fine, thanks!'],
  ['sender' => 'John Doe', 'text' => 'What are you up to today?'],
  ['sender' => 'Jane Smith', 'text' => 'Not much, just working on some code.'],
  ['sender' => 'John Doe', 'text' => 'Cool, let me know if you need any help.'],
];

header('Content-Type: application/json');
echo json_encode($messages);

?>