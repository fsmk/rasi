<?php

       	session_start();
       	// dBase file
        include "dbConfig.php";

		
	// Create query

	$DB = new DBConfig();
	$DB -> config();
	$dbhandle =$DB -> conn();


	$q = "SELECT * FROM `users` "
		."WHERE `username`='".$_POST["username"]."' "
		."AND `password`='".$_POST["password"]."' "
		."LIMIT 1";

	
	//execute the SQL query and return records
	$result = mysql_query($q);

	

 	 if ($row = mysql_fetch_array($result))
        {
        // Login good, create session variables

        $_SESSION["username"] = $row{'username'};
        $_SESSION["role"]=$row{'role'};
        // Redirect to member page
        
	

	if($_SESSION["role"]==1)
         echo "words.php?role=1";
        else
	 echo "words.php?role=2";
        }
	else
	 echo "login.php?err_val=1"


?>

