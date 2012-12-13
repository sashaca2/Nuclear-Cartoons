<?php require 'head.php'; ?>

<body id="Database">
<body class="FullDB">

<?php require 'header.php'; ?>

<div id ="content">

<?php
include('connect-real-db.php');  
$array2=array();

if (isset($_GET['events'])) {
	$events = $_GET['events'];
		$heading = "SELECT * FROM events WHERE event_no=".$events;
		$results2 = mysql_query($heading);
			$row = mysql_fetch_array($results2);
				echo "<div class='heading'><h2>All Cartoons With: ".$row['event']."</h2></div>";
	$query = "SELECT * FROM cartoon_events WHERE fk_event_no=" .$events;
}

if (isset($_GET['keywords'])) {
	$keywords = $_GET['keywords'];
		$heading = "SELECT * FROM keywords WHERE keyw_no=".$keywords;
		$results2 = mysql_query($heading);
			$row = mysql_fetch_array($results2);
				echo "<div class='heading'><h2>All Cartoons With: ".$row['keyword']."</h2></div>";
	$query = "SELECT * FROM cartoon_keywords WHERE fk_keyw_no=" .$keywords;	
}

if (isset($_GET['actors'])) {
	$actors = $_GET['actors'];
		$heading = "SELECT * FROM characters WHERE actor_no=".$actors;
		$results2 = mysql_query($heading);
			$row = mysql_fetch_array($results2);
				echo "<div class='heading'><h2>All Cartoons With: ".$row['actor']."</h2></div>";
	$query = "SELECT * FROM cartoon_characters WHERE fk_actor_no=" .$actors;	
}

$result=mysql_query($query);
while($q1=  mysql_fetch_array($result)){    
	$array2[]= $q1['fk_toon_no'];
}

if (!empty($array2)) {
echo "<br />";
$query2 = "SELECT * FROM cartoons WHERE toon_no in (".implode($array2, ',') .") ORDER BY p_date asc";
    echo "<table id='ViewAll' class='tablesorter {sortlist: [[1,0]]}''>";  
    echo "<thead>"; 
	echo "<tr><th>Artist</th><th>Publication Date</th><th>Caption</th><th>Description</th><th></th></tr>";
	echo "</thead>";
	echo "<tbody>"; 
		$result2 = mysql_query($query2);
			while ($row=mysql_fetch_array($result2)) {
					$p_date=$row['p_date'];
						$pub_date=explode('-', $p_date);
						$mysqlPDate = $pub_date[1].'/'.$pub_date[2].'/'.$pub_date[0];
				if ($row['fk_artist_no'] == 1) {
                	$artist = "Herblock";
            	} elseif ($row['fk_artist_no'] == 2) {
                	$artist = "Conrad @ Post";
            	} elseif ($row['fk_artist_no'] == 3) {
                	$artist = "Conrad @ Times";
            	} else {
                	$artist = "Miller";
            	}
				echo "<tr>";
				echo "<td>" . $artist . "</td>";
				echo "<td>" . $mysqlPDate . "</td>";
				echo "<td>" . $row['title'] . "</td>";
				echo "<td>" . $row['description'] . "</td>";
				echo "<td><a href='SingleCartoon.php?toon_no=" . $row['toon_no'] . "'>View Cartoon Meta</a></td>";
				echo "</tr>";	
			}
	echo "</tbody>";
	echo "</table>";
}
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
    		</select> 
  	</form> 
</div>

<br />
<p>Press Browser Back Button to Return to Search Results</p>
<p><a href='FullDatabase.php'>Return to Full Database</a><p>
</div> <!-- closes #content -->
<?php require 'footer.php'; ?>