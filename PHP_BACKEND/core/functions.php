<?php

function guidv4($data = null) {
// Generate 16 bytes (128 bits) of random data or use the data passed into the function.
$data = $data ?? random_bytes(16);
assert(strlen($data) == 16);

// Set version to 0100
$data[6] = chr(ord($data[6]) & 0x0f | 0x40);
// Set bits 6-7 to 10
$data[8] = chr(ord($data[8]) & 0x3f | 0x80);

// Output the 36 character UUID.
return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
}

function random_string($length){
    $array = array(0,1,2,3,4,5,6,7,8,9,'a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','x','y','z','A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','Q','R','S','T','U','V','W','X','Y','Z');
    $text1 = "";

    for($x = 0; $x < $length; $x++){
        $random = rand(0, 40);
        $text1 .= $array[$random];
    }

    $array = array(0,1,2,3,4,5,6,7,8,9,'a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','x','y','z','A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','Q','R','S','T','U','V','W','X','Y','Z');
    $text2 = "";

    for($x = 0; $x < $length; $x++){
        $random = rand(0, 50);
        $text2 .= $array[$random];
    }
    $data = $text1.'-'.$text2;
    return $data;
}




function user_session($data){
    //code...
   if(isset($_SESSION['USER_ID'])){
      return $_SESSION['USER_ID']->firstname;
   }

     return false;

}

function duration($duration){
          $durations = "";
          if($duration <= 20000 && $duration > 1000){
            $durations = "2 Weeks ";
          }elseif($duration <= 50000 && $duration > 20000){
            $durations = "1 Month";
          }elseif($duration <= 100000 && $duration > 50000){
            $durations = "3 Months";
          }elseif($duration <= 200000 && $duration > 100000){
            $durations = "6 Months";
          }
          return $durations;
}

function balance_plus($balance, $value){
          $bal = "";
          $bal = $balance+$value;
          return $bal;
}
function balance_minus($balance, $value){
          $bal = "";
          $bal = $balance-$value;
          return $bal;
}


function loan_request_level($result_level, $conn){

  if( $result_level < 2){

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
}elseif( $result_level <= 2){
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
}elseif( $result_level <= 3){
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
}elseif( $result_level <= 4){
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


}
 ?>
