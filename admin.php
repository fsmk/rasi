<?php

       session_start();

  // dbConfig.php is a file that contains your
        // database connection information. This
        // tutorial assumes a connection is made from
        // this existing file.
        include ("dbConfig.php");


        $DB = new DBConfig();
	$DB -> config();
	$dbhandle =$DB -> conn();
         if(isset($_GET["op"]))
	{	$val=$_SESSION['count'];
                if ($_GET["op"] == "save")
		{ 
                    #echo "decision 3 is ".$_POST['decision'][3];
                  $j=0;
                  
                  
	 #echo "decision is".$_POST['decision'][$j];              
                   while($j<$val)
		   { $wordid=$_POST['wordid'][$j];
                  #echo "woed id id ".$wordid;
		  $word=$_POST['word'][$j];
                  $meaning= $_POST['meaning'][$j];
                  $createdby=$_POST['createdby'][$j];
                  $createdon=$_POST['createdon'][$j];
                  $comments=$_POST['comments'][$j];
                  $reference=$_POST['reference'][$j];
                      if($_POST['decision'][$j]=='approve')
                   {   #echo "insert done";
                   $q="INSERT INTO meanings (wordid,meaning,createdby,createdon,comments,reference) VALUES        ('$wordid','$meaning','$createdby','$createdon','$comments','$reference')";
                      $result = mysql_query($q);
                        if (!$result)
				{        echo "wrong insert attempt";
   					 die("Hey,".mysql_error());    // Thanks to Pekka for pointing this out.
				}
                         else
                               {
					$q="DELETE FROM temp_meanings where word_id = '$wordid' and meaning = '$meaning'";
                                        $result = mysql_query($q);
                                        if (!$result)
				{          echo "wrong delete attempt";
   					 die("Hey,".mysql_error());    // Thanks to Pekka for pointing this out.
				}
                               }

                     
                   }
                      else

                       {  #echo "in";
			  $q="UPDATE temp_meanings SET status='R' where word_id= '$wordid'and meaning = '$meaning'";		
			  $result = mysql_query($q); 
 			   if (!$result)
				{          echo "wrong update attempt";
   					 die("Hey,".mysql_error());    // Thanks to Pekka for pointing this out.
				}
                       }

                    $j++;
                 }
        		
        	 
		}

         }
        $q="select w.word,w.id,t.meaning,t.createdby,t.modifiedby,t.comments,t.reference,t.createdon,t.modifiedon,r.rating,r.rated_by,r.reason from words w join  temp_meanings t on w.id=t.word_id left join rating r on t.id=r.temp_meaning_id";
$i=0;        
        $result = mysql_query($q);
echo "<form action=\"?op=save \" method=\"POST\">";
echo "<table border='1'>
<tr>
<th>Word</th>
<th>Meaning</th>
<th>Created by</th>
<th>Comments</th>
<th>Reference</th>
<th>Created on</th>
<th>Rating</th>
<th>Rated by</th>
<th>Reason</th>
<th>Status</th>
<th>Admin's Remarks</th>
</tr>";


        while($row = mysql_fetch_array($result)) 
{ 
  echo "<tr>";
  echo "<input type=\"hidden\" name=\"wordid[]\" value=" . $row['id'] . " />";
  echo "<td>"."<input type=\"text\" name=\"word[]\" value=" . $row['word'] . " /></td>";
  echo "<td>"."<input type=\"text\" name=\"meaning[]\" value=" . $row['meaning'] . " /></td>";
  echo "<td>"."<input type=\"text\" name=\"createdby[]\" value=" . $row['createdby'] . " /></td>";
  echo "<td>"."<input type=\"text\" name=\"comments[]\" value=" . $row['comments'] . " /></td>";
  echo "<td>"."<input type=\"text\" name=\"reference[]\" value=" . $row['reference'] . " /></td>";
  echo "<td>"."<input type=\"text\" name=\"createdon[]\"value=" . $row['createdon'] . " /></td>";
  echo '<td><input type=text name= \'rating[]\' value="'. $row['rating'] .'"/></td>';
  echo '<td><input type=text name= \'rated_by[]\'value="'.$row['rated_by'].'"/></td>';
  echo '<td><input type=text name= \'reason[]\'value="'.$row['reason'].'" /></td>';
  
  echo "<td><select name='decision[]' >
  <option value='approve'>Approve</option>
  <option value='reject'>Reject</option>
  </select></td>";
  echo "<td><input type='text' value=\" \"/></td>";
  
  echo "</tr>";
$i++;
 }
       
        
 echo "</table>";
 echo "<input type=\"submit\" value=\"Submit\">";
 echo "</form>";
  
$_SESSION['count'] = $i;
$DB ->close();
?>
