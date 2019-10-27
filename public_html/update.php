<?php

// php code to Update data from mysql database Table

if(isset($_POST['update']))
{
    
   $hostname = "localhost";
   $username = "id11299704_root";
   $password = "nikos";
   $databaseName = "id11299704_ehealth";
   
   $connect = mysqli_connect($hostname, $username, $password, $databaseName);
   
   // get values form input text and number
   
   $id = $_POST['id'];
   $note = $_POST['note'];
           
   // mysql query to Update data
   $query = "UPDATE `Note` SET `note` = '".$note."' WHERE `Note`.`noteID` = $id";
			   
   $result = mysqli_query($connect, $query);
   
   if($result)
   {
       echo 'Data Updated';
   }else{
       echo 'Data Not Updated';
   }
   mysqli_close($connect);
}

?>



        <form action="update.php" method="post">
	ID To Update: <select name="id" onchange="reload(this.value)"> <br><br>
                <option value="1">Session ID 1</option>
				<option value="2">Session ID 2</option>
                </select>

            Note:<input type="text" name="note" required><br><br>

            <input type="submit" name="update" value="Update Data">

        </form>
