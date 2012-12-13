<?php
/* This script gets all the individual keywords from the database and writes them into a file in alphabetical order */

include("connect-real-db.php");

	$myFile = "AllKeywords.txt";
	$fh = fopen($myFile, 'w') or die("Can't open file");
		$keyword_query = "SELECT * from keywords order by keyword asc"; 
		$keyword_result = mysql_query($keyword_query);
			while ($row = mysql_fetch_assoc($keyword_result)) {
				$keyword_array[] = $row['keyword'];
			}
		foreach ($keyword_array as $element) {
			fwrite($fh, $element ."\n");
		}
	fclose($fh);
?>
