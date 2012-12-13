<?php

/* This script writes all the keywords for each cartoon into one file */

include("connect-real-db.php");

$id=1;

while ($id<=470) {

	$keyword_array=array();

		$myFile = "AllKW46-79.txt";
		$fh = fopen($myFile, 'w') or die("Can't open file");
			$keyword_query = "SELECT cartoon_keywords.fk_toon_no, cartoon_keywords.fk_keyw_no, keywords.keyw_no, keywords.keyword "
				."FROM cartoon_keywords, keywords "
				."WHERE cartoon_keywords.fk_toon_no = " .$id
				." HAVING cartoon_keywords.fk_keyw_no = keywords.keyw_no
				ORDER BY keyword asc";
			$keyword_result = mysql_query($keyword_query);
				while ($row = mysql_fetch_assoc($keyword_result)) {
					$keyword_array[] = $row['keyword'];
				}

/*	foreach ($keyword_array as $element) {
		print_r($element);
		echo "<br />";
	}
*/
	foreach ($keyword_array as $element) {
		fwrite($fh, $element ."\n");
	}

	fclose($fh);

	$id++;
}

?>