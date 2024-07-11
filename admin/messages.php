<?php

include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:admin_login.php');
};
// Check if 'delete' parameter is set in the URL
if(isset($_GET['delete'])){
   // Get the ID of the message to be deleted from the URL parameter
   $delete_id = $_GET['delete'];
   // Prepare SQL statement to delete the message with the specified ID
   $delete_message = $conn->prepare("DELETE FROM `messages` WHERE id = ?");
   // Execute the SQL statement with the ID as parameter to delete the message
   $delete_message->execute([$delete_id]);
   // Redirect back to the messages.php page after deletion
   header('location:messages.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Messages</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <link rel="stylesheet" href="../css/admin_style.css">

</head>
<body>

<?php include '../components/admin_header.php'; ?>

<section class="contacts">

<h1 class="heading">Messages</h1>

<div class="box-container">

   <?php
      $select_messages = $conn->prepare("SELECT * FROM `messages`");
      $select_messages->execute();
      if($select_messages->rowCount() > 0){
          // Loop through each message
         while($fetch_message = $select_messages->fetch(PDO::FETCH_ASSOC)){
   ?>
   <div class="box">
   <p> User id : <span><?= $fetch_message['user_id']; ?></span></p>
   <p> Name : <span><?= $fetch_message['name']; ?></span></p>
   <p> Email : <span><?= $fetch_message['email']; ?></span></p>
   <p> Number : <span><?= $fetch_message['number']; ?></span></p>
   <p> Message : <span><?= $fetch_message['message']; ?></span></p>
   <a href="messages.php??delete=<?= $fetch_message['id']; ?>" onclick="return confirm('delete this message?');" class="delete-btn">Delete</a>
   </div>
   <?php
         }
      }else{
          // If there are no messages, display a message indicating so
         echo '<p class="empty">you have no messages</p>';
      }
   ?>

</div>

</section>












<script src="../js/admin_script.js"></script>
   
</body>
</html>