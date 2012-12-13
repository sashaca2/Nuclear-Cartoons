<?php

/* This script gets all the keywords from the database and counts their total number of occurances and prints to ones that occur in more than 5 cartoons.
The second half of the script is a copy and paste of those results and then returns the dates for each carton that keyword appeared in */

include("connect-real-db.php");

$keyword_query = "SELECT * from keywords order by keyword asc"; 
		$keyword_result = mysql_query($keyword_query);
			while ($row = mysql_fetch_assoc($keyword_result)) {
				$keyword_array[] = $row['keyw_no'];

			}

foreach ($keyword_array as $element) {
	$sql2="SELECT COUNT(*) FROM cartoon_keywords where fk_keyw_no=".$element;
		$result2=mysql_query($sql2);
			$row2=mysql_fetch_row($result2);
				$count=$row2[0];
					if ($count >= 5) {
						$sql="SELECT * from keywords where keyw_no=".$element;
							$result=mysql_query($sql);
								$row=mysql_fetch_array($result);
									echo $row['keyw_no'] .",";	
									echo $row['keyword'] .",";
									echo $count;
									echo "<br />";

					}
}

$string="72,43,81,76,79,169,4,12,69,11,51,1,17,9,23,237,56,62,22,8,177,18,21,147,121,30,48,113,41,179,105,90,170,143,155,86,245,32,63,60,167,156,38,15,73,75,84,34,92,142,133,101,93,89,192,87,10,83,85,45,68,186,37,82,14,19,55,70,225,78,158,154,2,16,66,229,71,20,33,24";
$array = explode(",", $string);
foreach ($array as $keyw_no) {
	$recent_keyword = "SELECT cartoons.p_date, cartoons.toon_no, cartoon_keywords.fk_keyw_no, cartoon_keywords.fk_toon_no "
	."FROM cartoon_keywords, cartoons "
	."WHERE cartoon_keywords.fk_keyw_no =" .$keyw_no 
	." HAVING cartoon_keywords.fk_toon_no=cartoons.toon_no ORDER BY p_date asc";
	$recent_keyword_result=mysql_query($recent_keyword);

	while ($row4=mysql_fetch_array($recent_keyword_result)) {
		echo $row4['fk_keyw_no'] ."\n";
		echo $row4['p_date'];
		echo "<br />";
	}
}

?>