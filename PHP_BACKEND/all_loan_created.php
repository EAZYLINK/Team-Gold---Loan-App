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



     $query_loan = "SELECT * FROM loaners WHERE user_id='$user_id'";
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

     $id = @$_POST['id'];
     $approvedat = $_POST['requestedat'] = date("Y-m-d H:i:s");

     $approv_loan = "SELECT * FROM loaners WHERE user_id='$user_id' and id='$id' ";
     $approve = $conn->query($approv_loan);

     if ($approve->num_rows > 0) {
       $rows = $approve->fetch_object();
       $is_approved = $rows->is_approved;
       $receiver_id = $rows->receiver_id;
        $amount = $rows->loan_amount;
        $interest = $rows->interest;
        $refund_amount = $amount+$interest;
     }
     if($is_approved == "No"){
     $update = "UPDATE loaners SET refund_amount='$refund_amount', status='Approved', is_approved='Yes', is_sent='Yes', approvedat='$approvedat' WHERE id='$id' and user_id='$user_id' ";
     $query = $conn->query($update);
     if($query == True){


       $receiver_query = "SELECT * FROM users WHERE user_id='$receiver_id' ";
       $receiver = $conn->query($receiver_query);

       if ($receiver->num_rows > 0) {
         $receiver_rows = $receiver->fetch_object();
         $receiver_bal = $receiver_rows->balance;
       }
        $balance = balance_plus($receiver_bal, $amount);
      $updates = "UPDATE users SET balance='$balance' WHERE user_id='$receiver_id'";
      $querys = $conn->query($updates);
      if($querys == True){
        $response['status'] = "Ok";
       $response['data'] = 'You approved this loan request';

      }

     }
   }else{
     $response['status'] = "400";
    $response['data'] = 'Invalide action, Trying to be smart right?';
   }

   endif;


echo json_encode($response);
?>
