<?php

/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	 * Easy set variables
	 */
	
	/* Array of database columns which should be read and sent back to DataTables. Use a space where
	 * you want to insert a non-database field (for example a counter or static image)
	 */
	//$aColumns = array( 'word' );
      /* DB table to use */
	
    /* include ("dbConfig.php");


        $DB = new DBConfig();
	$DB -> config();
	$dbhandle =$DB -> conn();
        //$word="da%";
        $word=$_GET['more_data'];
        
       $squery="select w.word,w.id,t.meaning,t.createdby,t.modifiedby,t.comments,t.reference,t.createdon,t.modifiedon from words w join  temp_meanings t on (w.id=t.word_id and w.word like '$word%' )";
       $result=mysql_query( $squery ) or fatal_error( 'MySQL Error: ' . mysql_errno() );
       $test[]=array();
        $i=0;
       while($aRow=mysql_fetch_array($result))
         {
           $test[$i++]="<input type=\"text\" name=\"wordid[]\" value=" . $aRow['id'] . " />";
            //echo json_encode("<input type=\"text\" name=\"wordid[]\" value=" . $aRow['id'] . " />");
  
         }
        echo json_encode($test);
       //echo json_encode( "Hello");*/
 $aColumns = array( 'temp_meanings.word_id','words.word','temp_meanings.meaning','temp_meanings.createdby','temp_meanings.comments'
,'temp_meanings.reference','temp_meanings.createdon','temp_meanings.status','temp_meanings.remarks', );
$cols=array('word_id','word','meaning','createdby','comments'
,'reference','createdon','status','modifiedon');
 $names=array('wordid[]','word[]','meaning[]','createdby[]','comments[]','reference[]','createdon[]','remarks[]');    
    /* Indexed column (used for fast and accurate table cardinality) */
    $sIndexColumn = "words.id";
     
    /* DB table to use */
    $sTable = array("words","temp_meanings");
     
    /* Database connection information */
    $gaSql['user']       = "root";
    $gaSql['password']   = "redlotus";
    $gaSql['db']         = "rasi";
    $gaSql['server']     = "localhost";
     
     
    /* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
     * If you just want to use the basic configuration for DataTables with PHP server-side, there is
     * no need to edit below this line
     */
     
    /*
     * Local functions
     */
    function fatal_error ( $sErrorMessage = '' )
    {
        header( $_SERVER['SERVER_PROTOCOL'] .' 500 Internal Server Error' );
        die( $sErrorMessage );
    }
 
     
    /*
     * MySQL connection
     */
    if ( ! $gaSql['link'] = mysql_pconnect( $gaSql['server'], $gaSql['user'], $gaSql['password']  ) )
    {
        fatal_error( 'Could not open connection to server' );
    }
 
    if ( ! mysql_select_db( $gaSql['db'], $gaSql['link'] ) )
    {
        fatal_error( 'Could not select database ' );
    }
     
     
    /*
     * Paging
     */
    $sLimit = "";
    if ( isset( $_GET['iDisplayStart'] ) && $_GET['iDisplayLength'] != '-1' )
    {
        $sLimit = " LIMIT ".intval( $_GET['iDisplayStart'] ).", ".
            intval( $_GET['iDisplayLength'] );
         // $sLimit = " LIMIT 0,1";
      // $_SESSION['count']=$_GET['iDisplayLength'];
    }
     
     
    /*
     * Ordering
     */
    $sOrder = "";
    if ( isset( $_GET['iSortCol_0'] ) )
    {
        $sOrder = "ORDER BY  ";
        for ( $i=0 ; $i<intval( $_GET['iSortingCols'] ) ; $i++ )
        {
            if ( $_GET[ 'bSortable_'.intval($_GET['iSortCol_'.$i]) ] == "true" )
            {
                $sOrder .= $aColumns[ intval( $_GET['iSortCol_'.$i] ) ]."
                    ".($_GET['sSortDir_'.$i]==='asc' ? 'asc' : 'desc') .", ";
            }
        }
         
        $sOrder = substr_replace( $sOrder, "", -2 );
        if ( $sOrder == "ORDER BY" )
        {
            $sOrder = "";
        }
    }
     
     
    /*
     * Filtering
     * NOTE this does not match the built-in DataTables filtering which does it
     * word by word on any field. It's possible to do here, but concerned about efficiency
     * on very large tables, and MySQL's regex functionality is very limited
     */
    $sWhere = "";
    if ( isset($_GET['sSearch']) && $_GET['sSearch'] != "" )
    {
        $sWhere = "WHERE (";
        for ( $i=0 ; $i<(count($aColumns)-2) ; $i++ )
        {
            if ( isset($_GET['bSearchable_'.$i]) && $_GET['bSearchable_'.$i] == "true" )
            {
                $sWhere .= $aColumns[$i]." LIKE '%".mysql_real_escape_string( $_GET['sSearch'] )."%' OR ";
            }
        }
        $sWhere = substr_replace( $sWhere, "", -3 );
        $sWhere .= ')';
        
    }
     
    /* Individual column filtering */
    for ( $i=0 ; $i<count($aColumns)-1 ; $i++ )
    {
        if ( isset($_GET['bSearchable_'.$i]) && $_GET['bSearchable_'.$i] == "true" && $_GET['sSearch_'.$i] != '' )
        {
            if ( $sWhere == "" )
            {
                $sWhere = "WHERE ";
            }
            else
            {
                $sWhere .= " AND ";
            }
            //$sWhere .= $aColumns[$i]." LIKE '%".mysql_real_escape_string($_GET['sSearch_'.$i])."%' ";
            $sWhere .$aColumns[0]." LIKE '%".mysql_real_escape_string("da")."%' ";
        }
    }
     
     
    /*
     * SQL queries
     * Get data to display
     */
    /*$sQuery = "
        SELECT SQL_CALC_FOUND_ROWS ".str_replace(" , ", " ", implode(", ", $aColumns))."
        FROM   $sTable[0] join $sTable[1] on $sTable[0].id=$sTable[1].id
        $sWhere
        $sOrder
        $sLimit
    ";*/
      $sQuery = "
        SELECT SQL_CALC_FOUND_ROWS ".str_replace(" , ", " ", implode(", ", $aColumns))."
        FROM   $sTable[0] join $sTable[1] on $sTable[0].id=$sTable[1].word_id  ".
        $sWhere. $sLimit;
     // echo $sQuery;
    $rResult = mysql_query( $sQuery, $gaSql['link'] ) or fatal_error( 'MySQL Error: ' . mysql_error() );
    
     
    /* Data set length after filtering */
    $sQuery = "
        SELECT FOUND_ROWS()
    ";
    $rResultFilterTotal = mysql_query( $sQuery, $gaSql['link'] ) or fatal_error( 'MySQL Error: ' . mysql_errno() );
    $aResultFilterTotal = mysql_fetch_array($rResultFilterTotal);
    $iFilteredTotal = $aResultFilterTotal[0];
    
    /* Total data set length */
    $sQuery = "
        SELECT COUNT(".$sIndexColumn.")
        FROM   $sTable[0] join temp_meanings on words.id=temp_meanings.word_id;
    ";
    $rResultTotal = mysql_query( $sQuery, $gaSql['link'] ) or fatal_error( 'MySQL Error: ' . mysql_error() );
    $aResultTotal = mysql_fetch_array($rResultTotal);
    $iTotal = $aResultTotal[0];
     
     
    /*
     * Output
     */
    $output = array(
        "sEcho" => intval($_GET['sEcho']),
        "iTotalRecords" => $iTotal,
        "iTotalDisplayRecords" => $iFilteredTotal,
        "aaData" => array(),
        
    );

   /*$output = array(
        "sEcho" => intval($_GET['sEcho']),
        "aaData" => array()
    );*/
     
     $j=1;
    while ( $aRow = mysql_fetch_array( $rResult ) )
    {    
        $row = array();
        
        for ( $i=0 ; $i<count($cols) ; $i++ )
        {
            if ( $aColumns[$i] == "temp_meanings.status" )
            {
                /* Special output formatting for 'version' column */
                $row[] = "<select name='decision[]' >
  <option value='approve'>Approve</option>
  <option value='reject'>Reject</option>
  </select>";
            }
            else if ( $aColumns[$i] == "temp_meanings.word_id" )
            {
                /* General output */
                
                $row[] = '<input type=hidden name= "'.$names[$i].'" value="'.$aRow[ $cols[$i] ].'" />';
                
               // $row[]=$aRow[ $cols[$i] ];
            }
            
            else if ( $aColumns[$i] != ' ' )
            {
                /* General output */
                
                $row[] = '<input type=text name= "'.$names[$i].'" value="'.$aRow[ $cols[$i] ].'" />';
                
               // $row[]=$aRow[ $cols[$i] ];
            }
           
                
        }
        $output['aaData'][] = $row;
        $j++;
    }
   //$output['submit']=stripslashes("<input type=\"submit\" value=\"Submit\"/>");
  
     
    echo json_encode(($output));

?>
