<?php require 'head.php'; ?>

<body id="Database">
<body class="SearchDB">

<?php require 'header.php'; ?>

<?php require 'databasenav.php'; ?>

<div id="content">

<?php 
include('connect-real-db.php');
                                        
echo "<p>Choose a combination of Character and Keyword or just one to see all the cartoons featuring that element</p>";

echo "<form method='get' action='SearchResults.php'>";

echo "<div id='leftside'>";
echo "<p>Choose Character</p>";
	$characters = mysql_query("SELECT * FROM characters ORDER BY actor asc");
		echo "<select name='actors' class='search'>";
		echo "<option value=0>  --- </option>"; 
			while ($row = mysql_fetch_array($characters)) {
				echo "<option value="; 
					echo $row['actor_no']; 
    			echo ">";
        			echo $row['actor'];
    			echo "</option>";
    		}
		echo "</select>";
echo "</div>";

echo "<div id='rightside'>";
echo "<p>Choose Keyword</p>";
	$keyword = mysql_query("SELECT * FROM keywords ORDER BY keyword asc");
		echo "<select name='keywords'>";
		echo "<option value=0>  --- </option>"; 
			while ($row = mysql_fetch_array($keyword)) {
				echo "<option value="; 
					echo $row['keyw_no']; 
    			echo ">";
        			echo $row['keyword'];
    			echo "</option>";
    		}
		echo "</select>";
echo "</div>";

echo "<div class='clearfloat'></div>";
echo "<br />";
echo "<br /><input type='submit' value='Submit' class='search2'/>"; 
echo "<br />";

echo "</form>";
echo "<br />";

?>
</div> <!-- closes #content -->
<?php require 'footer.php'; ?>