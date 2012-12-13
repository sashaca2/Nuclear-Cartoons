<?php
/* This script writes all the keywords for each cartoon into their own file that is titled the date of the cartoon in question */

include("connect-real-db.php");

$id=1;

while ($id<=109) {

	$keyword_array=array();
		$date_query = "SELECT p_date FROM cartoons WHERE toon_no = " .$id;
			$date_result = mysql_query($date_query);
				$row = mysql_fetch_assoc($date_result);
					$pub_date=$row['p_date'];
						$pub_date=explode('-', $pub_date);
                    		$titleDate = $pub_date[1].'-'.$pub_date[2].'-'.$pub_date[0];

	$myFile = $titleDate .".txt";
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

		foreach ($keyword_array as $element) {
			fwrite($fh, $element ."\n");
		}
	fclose($fh);

	$id++;
}

?>