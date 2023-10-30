<?php
include("inc/database.php");
include("core/functions.php");

   $query_loan = "SELECT * FROM loaners";
   $result_loan = $conn->query($query_loan);
   while ($row = $result_loan->fetch_object()) {
      // Access data from the current row
      $id = $row->id;
      // You can access other columns in a similar way

      // Do something with the data, such as displaying it
      echo "ID: $id- <br>";
   }





echo json_encode($response);
?>
