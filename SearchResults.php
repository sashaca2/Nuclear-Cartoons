<?php require 'head.php'; ?>

<body id="Database">
<body class="SearchDB">

<?php require 'header.php'; ?>

<div id="content">
<?php 
include('connect-real-db.php');
echo "";

$actors=$_GET['actors'];
$keywords=$_GET['keywords'];

if ($keywords >=1 && $actors >=1) {
	$headerq1= "SELECT * FROM characters WHERE actor_no=".$actors;
		$q1_result=mysql_query($headerq1);
		$row=mysql_fetch_array($q1_result);
			$header_actor=$row['actor'];
	$headerq2="SELECT * FROM keywords WHERE keyw_no=".$keywords;
		$q2_result=mysql_query($headerq2);
		$row2=mysql_fetch_array($q2_result);
			$header_keyword=$row2['keyword'];
	echo "<h2>All Cartoons With <br /> <span style='font-size: 30px;'>Character: ".$header_actor ." and Keyword: ".$header_keyword ."</span></h2>";
} elseif ($actors >= 1) {
	$headerq1= "SELECT * FROM characters WHERE actor_no=".$actors;
		$q1_result=mysql_query($headerq1);
		$row=mysql_fetch_array($q1_result);
			$header_actor=$row['actor'];
	echo "<h2>All Cartoons With <br /> <span style='font-size: 30px;''>Character: ".$header_actor ."</span></h2>";
} elseif ($keywords >=1) {
	$headerq2="SELECT * FROM keywords WHERE keyw_no=".$keywords;
		$q2_result=mysql_query($headerq2);
		$row=mysql_fetch_array($q2_result);
			$header_keyword=$row['keyword'];
	echo "<h2>All Cartoons With <br /> <span style='font-size: 30px;''>Keyword: ".$header_keyword ."</span></h2>";
} else {
	echo "<p>You Must Pick At Least One Search Term<p>";
} 

if ($actors >=1 && $keywords >=1) {
	$query = "SELECT cartoon_characters.fk_toon_no, cartoon_characters.fk_actor_no, cartoon_keywords.fk_toon_no, cartoon_keywords.fk_keyw_no "
	."FROM cartoon_characters, cartoon_keywords "
	."WHERE cartoon_characters.fk_actor_no=" .$actors
	." AND cartoon_keywords.fk_keyw_no=" .$keywords
	." HAVING cartoon_characters.fk_toon_no=cartoon_keywords.fk_toon_no";
} elseif ($keywords == 0) {
	$query = "SELECT * FROM cartoon_characters "
	."WHERE fk_actor_no=" .$actors;
} else {
	$query = "SELECT * FROM cartoon_keywords "
	."WHERE fk_keyw_no=" .$keywords;
}

$result=mysql_query($query);
while($q1=  mysql_fetch_assoc($result)){    
	$array2[]= $q1['fk_toon_no'];
}


if (empty($array2)) {
	echo "<br />";
	echo "Sorry. No Cartoons Contain That Combination";
} else {
	$query2 = "SELECT * FROM cartoons WHERE toon_no in (".implode($array2, ',') .") ORDER BY p_date asc";
    echo "<br />";
    echo "<table id='Search' class='tablesorter {sortlist: [[1,0]]}''>";  
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
				echo "<td><a href='SingleCartoon.php?toon_no=" . $row['toon_no'] . "'>View Toon Meta</a></td>";
				echo "</tr>";	
			}
	echo "</tbody>";
	echo "</table>";
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
<?php } ?>
</div> <!-- closes #content -->
<br />
<p><a href='SearchDatabase.php'>Back to Search Page</a></p>

<?php require 'footer.php'; ?>