<?php
// Include file to establish database connection
include '../components/connect.php';

session_start();
// Get admin ID from session
$admin_id = $_SESSION['admin_id'];
// If admin ID is not set, redirect to admin login page
if(!isset($admin_id)){
   header('location:admin_login.php');
}
// If 'delete' parameter is set in the URL
if(isset($_GET['delete'])){
   // Get the ID of the admin to be deleted from the URL parameter
   $delete_id = $_GET['delete'];
   // Prepare SQL statement to delete admin from database
   $delete_admins = $conn->prepare("DELETE FROM `admins` WHERE id = ?");
   // Execute the SQL statement with admin ID as parameter
   $delete_admins->execute([$delete_id]);
   // Redirect back to admin_accounts.php after deletion
   header('location:admin_accounts.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Admin Accounts</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <link rel="stylesheet" href="../css/admin_style.css">

</head>
<body>

<?php include '../components/admin_header.php'; ?>

<section class="accounts">

   <h1 class="heading">Admin Accounts</h1>

   <div class="box-container">

   <div class="box">
      <p>Add New Admin</p>
      <a href="register_admin.php" class="option-btn">Register Admin</a>
   </div>

   <?php
      $select_accounts = $conn->prepare("SELECT * FROM `admins`");
      $select_accounts->execute();
      if($select_accounts->rowCount() > 0){
         // Loop through each admin account
         while($fetch_accounts = $select_accounts->fetch(PDO::FETCH_ASSOC)){   
   ?>
   <div class="box">
      <p> Admin Id : <span><?= $fetch_accounts['id']; ?></span> </p>
      <p> Admin name : <span><?= $fetch_accounts['name']; ?></span> </p>
      <div class="flex-btn">
         <a href="admin_accounts.php?delete=<?= $fetch_accounts['id']; ?>" onclick="return confirm('delete this account?')" class="delete-btn">delete</a>
         <?php
            if($fetch_accounts['id'] == $admin_id){
               echo '<a href="update_profile.php" class="option-btn">update</a>';
            }
         ?>
      </div>
   </div>
   <?php
         }
      }else{
          // If no admin accounts found, display message
         echo '<p class="empty">no accounts available!</p>';
      }
   ?>

   </div>

</section>












<script src="../js/admin_script.js"></script>
   
</body>
</html>