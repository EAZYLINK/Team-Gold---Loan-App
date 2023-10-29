<?php
include("inc/database.php");
include("core/functions.php");
$response = false;

/////Get authenticated users token data
$token = $_GET['token'] = 'f2454894-6aca-4ea3-93b6-75d63ce21c7b';
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
   }
   $result->level;
   if( $result->level < 2){
      $query_loan = "SELECT * FROM loaners WHERE id='2' ";
      $result_loan = $conn->query($query_loan);

     $result_loan = $result_loan->fetch_object();
     echo "<pre>";
var_dump($result_loan);

     /*$query_loan = "SELECT * FROM loaner";
$result_loan = $conn->query($query_loan);

if ($result_loan->num_rows > 0) {
    while ($row = $result_loan->fetch_object()) {
        // Access data from the current row
        $id = $row->id;
        $name = $row->name;
        // You can access other columns in a similar way

        // Do something with the data, such as displaying it
        echo "ID: $id - Name: $name<br>";
    }
} else {
    echo "No rows found in the 'users' table.";
}



     echo "<pre>";
     print_r($result_loan);

    /*  if(!empty($result_loan->num_rows)){

         while($result_loan = $result_loan->fetch_object()){
           echo "<pre>";
           //print_r($result_loan);
           var_dump($result_loan);
         }

        //print_r($result_loan);
         //$response['datas'] = $result_loan;

      }*/
   }
/////Get users data ends
  // $response['status'] = "success";
   //$response['message'] = $data->email;



   if ($_SERVER['REQUEST_METHOD'] == 'POST') :



   endif;


echo json_encode($response);
?>
