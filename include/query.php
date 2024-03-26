<?php

  //Insert function
  function insert($field,$table) {

   $columns = "";
   $values = "";

	   foreach($field as $column => $value) {
		$columns.= "$column,";
		$values.= "'$value',";
	   }

			$columns.= "createdBy,createdDate";
			$now     = date("Y-m-d");

			$values.= "'".USER."','$now'";
		       echo $results = "INSERT INTO $table ($columns) VALUES ($values)";
                        mysqli_query($GLOBALS['mysqlConnect'],$results);
                        return mysqli_insert_id();
  }




  //Select Function
  function select($argument,$return="") {

     //Gathering All Argumnetns with their appropiate field and index
      $field     = $argument['field'];
      $table     = $argument['table'];
      $condition = $argument['condition'];
      $limit     = $argument['limit'];
      $distinct  = $argument['distinct'];
      $order     = $argument['order'];

      //Seperating field and column
      $values = "";
      foreach($field as  $value) { $values .= "$value,";  }
      $values = rtrim($values,","); //Triming in last Right

      //Validating Condition
      if(!empty($condition)) { $condition = "where $condition"; }

      //Validating limit
      if(!empty($limit)) { $limit = "limit $limit"; }

      //Validating Order
      if(!empty($order)) { $order = "order by $order"; }

      //Select query
      $query  = "select $distinct $values from $table $condition  $order $limit";
      $result = mysqli_query($GLOBALS['mysqlConnect'],$query);


      /**
       *  if return is count
       *  1ly returning count to the function
       */

      if($return == "count") {

        return  $results = mysql_num_rows($result);

      }

      /**
       *  if return is one
       *  1ly returning single row to the function
       */

      elseif ($return == "one") {

        return  $results = mysqli_fetch_array($result);

      }

       /**
       *  if return is many
       *  1ly returning multiple row to the function
       */

      elseif ($return == "many") {

          while($row = mysqli_fetch_assoc($result)) {
              $results[] = $row;
          }

          return $results;
      }

      /**
       *  if return is other
       *  1ly returning multiple row to the function
       */

      else {
          return $result;
      }


  }


  //Update Query
  function update($argument) {

     //Gathering All Argumnetns with their appropiate field and index
      $field     = $argument['field'];
      $table     = $argument['table'];
      $condition = $argument['condition'];


       //Seperating field and column
      $values = "";
      foreach($field as $key => $value) { $values .= "$key='$value',";  }
      $values = rtrim($values,","); //Triming in last Right

      //Validating Condition
      if(!empty($condition)) { $condition = "where $condition"; }

      //Update query
      $query  = "update $table set $values $condition";
      $result = mysqli_query($GLOBALS['mysqlConnect'],$query);

      return $result;

  }

?>
