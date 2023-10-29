<?php
include("inc/database.php");
include("core/functions.php");
$response = false;
  
/////Get authenticated users token data
$token = $POST['token'] = $token;
$query = "SELECT * FROM token WHERE token='$token'";
$result = $conn->query($query);
if(!empty($result->num_rows)){
   $data = $result->fetch_object();
   $email = $data->email;

}

/////Get authenticated users token data ends

/////Get users data
   $query = "SELECT * FROM users WHERE email='$email'";
   $result = $conn->query($query);
   if(!empty($result->num_rows)){
      $result = $result->fetch_object();
      $response['message'] = $result;
   }
/////Get users data ends
  // $response['status'] = "success";
   //$response['message'] = $data->email;



   if ($_SERVER['REQUEST_METHOD'] == 'POST') :
     $amount = @$_POST['amount'];
     $interest = @$_POST['interest'];

     if(empty(@$_POST['amount']) || !preg_match('/^[0-9.]+$/', @$_POST['amount'])){
         $response['status'] = false;
         $response['message'] = "Invalide amount figure";
     }elseif(@$_POST['amount'] < 1000 ){
       $response['status'] = false;
       $response['message'] = "You can't give Loan below N1000";
     }elseif(@$_POST['amount'] > $result->balance ){
       $response['status'] = false;
       $response['message'] = "Insufcient balance";
     }elseif(empty(@$_POST['interest']) || !preg_match('/^[0-9.]+$/', @$_POST['amount'])){
       $response['status'] = false;
       $response['message'] = "Please submit the right interest rate";
     }else{
          $balance = balance_minus($result->balance, $amount);
       $duration = $_POST['duration'] = duration(@$_POST['amount']);
       $createdat = $_POST['createdat'] = date("Y-m-d H:i:s");
       $is_approved = $_POST['is_approved'] = "No";
       $is_terms = $_POST['is_terms'] = "No";
       $is_sent = $_POST['is_sent'] = "No";
       $is_dispute = $_POST['is_dispute'] = "No";
       $balance = $_POST['balance'] = $balance;

       $sql = "INSERT INTO loaners (user_id, loan_amount, interest, duration, createdat, is_approved, is_terms, is_sent, is_dispute)
       VALUES ('$result->user_id', '$amount', '$interest', '$duration', '$createdat', '$is_approved', '$is_terms', ' $is_sent', '$is_dispute')";
        if($query = $conn->query($sql)){

          $update = "UPDATE users SET balance='$balance' WHERE user_id='$result->user_id'";
          $query = $conn->query($update);
          if($query == True){
            $response['status'] = "Ok";
           $response['data'] = $_POST;

          }
        }



     }

   endif;


echo json_encode($response);
?>
