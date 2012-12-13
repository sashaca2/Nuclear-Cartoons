<?php require 'head.php'; ?>

<body id="Database">
<body class="FullDB">

<?php require 'header.php'; ?>

<div id ="content">

<?php require 'databasenav.php'; ?>
               
<?php
// connect to the database
include('connect-real-db.php');  
                     
// get the records from the database
if ($result = $mysqli->query("SELECT * FROM cartoons ORDER BY p_date desc")) {
    // display records if there are records to display
    if ($result->num_rows > 0) { 
        // display records in a table
        echo "<table id='myTable' class='tablesorter {sortlist: [[1,0]]}''>";  
        echo "<thead>";                              
        // set table headers
        echo "<tr><th>Artist</th><th>Publication Date</th><th>Caption</th><th></th></tr>";
        echo "</thead>"; 
        echo "<tbody>";                               
            while ($row = $result->fetch_object()) {
                $p_date=$row->p_date;
                $pub_date=explode('-', $p_date);
                    $mysqlPDate = $pub_date[1].'/'.$pub_date[2].'/'.$pub_date[0];
            if ($row->fk_artist_no == 1) {
                $artist = "Herblock";
            } elseif ($row->fk_artist_no == 2) {
                $artist = "Conrad @ Post";
            } elseif ($row->fk_artist_no == 3) {
                $artist = "Conrad @ Times";
            } else {
                $artist = "Miller";
            }
            // set up a row for each record
            echo "<tr>";
            echo "<td>" . $artist . "</td>";
            echo "<td>" . $mysqlPDate . "</td>";
            echo "<td>" . $row->title . "</td>";
            echo "<td><a href='SingleCartoon.php?toon_no=" . $row->toon_no . "'>View Cartoon Meta</a></td>";
            echo "</tr>";
            }
        echo "</tbody>";                            
        echo "</table>"; 
    } // if there are no records in the database, display an alert message
    else {
        echo "No results to display!";
    }
} // show an error if there is an issue with the database query
else {
    echo "Error: " . $mysqli->error;
}                        
// close database connection
$mysqli->close();
                
?>
<div class='clearfloat'>
</div>
<div id="pager" class="pager"> 

  <form> 
    <img src="Images/first.png" class="first"/> 
    <img src="Images/prev.png" class="prev"/> 
        <input type="text" class="pagedisplay"/> <!-- this can be any element, including an input --> 
    <img src="Images/next.png" class="next"/> 
    <img src="Images/last.png" class="last"/> 
    <select class="pagesize"> 
      <option selected="selected" value="10">10 per page</option> 
      <option value="20">20 per page</option> 
      <option value="50">50 per page</option> 
      <option value="100">100 per page</option> 
    </select> 
  </form> 
</div>
<br />
</div>

<?php require 'footer.php'; ?>