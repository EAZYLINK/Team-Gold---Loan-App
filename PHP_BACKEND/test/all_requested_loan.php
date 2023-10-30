<?php
include("inc/database.php");
include("core/functions.php");
$response = false;

/////Get authenticated users token data
$token = $_GET['token'] =  $token;
$query = "SELECT * FROM token WHERE token='$token'";
$result = $conn->query($query);
if(!empty($result->num_rows)){
   $data = $result->fetch_object();
   $email = $data->email;
  // $user_id = $data->user_id;

}

/////Get authenticated users token data ends

/////Get users data
   $query = "SELECT * FROM users WHERE email='$email'";
   $result = $conn->query($query);
   if(!empty($result->num_rows)){
      $result = $result->fetch_object();
      $result->level;
      $user_id =   $result->user_id;
   }



     $query_loan = "SELECT * FROM loaners WHERE receiver_id='$user_id'";
     $result_loan = $conn->query($query_loan);

     if ($result_loan->num_rows > 0) {
       while ($row = $result_loan->fetch_object()) {
     // Access data from the current row
     $response['status'] = 'Ok';
     $response[] = $row;
 }
} else {
  $response['status'] = 400;
 $response['message'] = "No record found.";
}


   if ($_SERVER['REQUEST_METHOD'] == 'POST') :



   endif;


echo json_encode($response);
?>
