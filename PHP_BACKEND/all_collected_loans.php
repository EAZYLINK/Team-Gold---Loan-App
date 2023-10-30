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
      $balance =   $result->balance;
   }



     $query_loan = "SELECT * FROM loaners WHERE receiver_id='$user_id' and is_approved='Yes' ";
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
          $refund_date = $_POST['refund_date'] = date("Y-m-d H:i:s");

          $approv_loan = "SELECT * FROM loaners WHERE receiver_id='$user_id' and id='$id' ";
          $approve = $conn->query($approv_loan);

          if ($approve->num_rows > 0) {
            $rows = $approve->fetch_object();
            $is_approved = $rows->is_approved;
            $is_refunded = $rows->is_refunded;
            $receiver_id = $rows->user_id;
             $amount = $rows->loan_amount;
             $interest = $rows->interest;
             $refund_amount = $amount+$interest;

          if($is_refunded == "Yes"){
            $response['status'] = "400";
           $response['data'] = 'Invalide action, Trying to be smart right?';
        }else{

         $update = "UPDATE loaners SET refund_date='$refund_date', status='Refunded', is_refunded='Yes' WHERE id='$id' and receiver_id='$user_id' ";
         $query = $conn->query($update);
         if($query == True){

           $user_balance = balance_minus($balance, $refund_amount);
           $updates = "UPDATE users SET balance='$user_balance' WHERE user_id='$user_id'";
           $querys = $conn->query($updates);

           $receiver_query = "SELECT * FROM users WHERE user_id='$receiver_id' ";
           $receiver = $conn->query($receiver_query);

           if ($receiver->num_rows > 0) {
             $receiver_rows = $receiver->fetch_object();
             $receiver_bal = $receiver_rows->balance;
           }
            $balance = balance_plus($receiver_bal, $refund_amount);
          $updates = "UPDATE users SET balance='$balance' WHERE user_id='$receiver_id'";
          $querys = $conn->query($updates);
          if($querys == True){
            $response['status'] = "Ok";
           $response['data'] = 'Your loan has been refunded';

          }

         }



        }
}
   endif;


echo json_encode($response);
?>
