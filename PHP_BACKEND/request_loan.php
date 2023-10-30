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


   if( $result->level < 2){

     $query_loan = "SELECT * FROM loaners WHERE loan_amount < 20000";
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
}elseif( $result->level <= 2){
  $query_loan = "SELECT * FROM loaners WHERE loan_amount <= 50000";
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
}elseif( $result->level <= 3){
  $query_loan = "SELECT * FROM loaners WHERE loan_amount <= 100000";
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
}elseif( $result->level <= 4){
  $query_loan = "SELECT * FROM loaners WHERE loan_amount <= 200000";
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
}


   if ($_SERVER['REQUEST_METHOD'] == 'POST') :

      $id = @$_POST['id'];
      $requestedat = $_POST['requestedat'] = date("Y-m-d H:i:s");

      $update = "UPDATE loaners SET receiver_id='$user_id', status='Pending', requestedat='$requestedat' WHERE id='$id'";
      $query = $conn->query($update);
      if($query == True){
        $response['status'] = "Ok";
       $response['data'] = 'Your request submited awaiting approval';

      }

   endif;


echo json_encode($response);
?>
