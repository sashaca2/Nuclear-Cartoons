<? ob_start(); ?>
<?php require 'head.php'; ?>
<body id="Database">
<?php require 'header.php'; ?>

<?php
// Allows the user to both create new records and edit existing records

// connect to the database
include("connect-real-db.php");

function renderForm($artist_id = '', $pub_date ='', $caption = '', $description = '', $id = '', $error = '', $actor_id = '', $events_id ='', $themes_id = '', $keywords_id = '') {                

    echo "<div class='heading'><h2>"; if ($id != '') { echo "Edit Cartoon"; } else { echo "New Cartoon"; } echo "</h2></div>";
         if ($error != '') {
            echo "<div style='padding:4px; border:1px solid red; color:red'>" . $error. "</div>";} 

    echo "<form action='' method='post'>";
        if ($id != '') { 
            echo "<input type='hidden' name='toon_no' value='" . $id . "' />";
                echo "<p>Cartoon ID: "; 
                    echo $id; 
                    echo "</p>"; 
        }

        echo "<div class='middle'>";
            echo "<div class='middle-left'>";        
                echo "<div class='formElementSmall'>";
                    echo "<p>Select Cartoonist: * ";
                    $artists = mysql_query("SELECT * FROM cartoonists");
                        echo "<select name='fk_artist_no'>";
                            while ($row = mysql_fetch_array($artists)) {
                                echo "<option value="; echo $row['artist_no']; 
                                    if ($artist_id == $row['artist_no']) { echo ' selected '; } echo ">";
                                echo $row['f_name'] ." " .$row['l_name'] .": " ,$row['paper'];
                                echo "</option>";
                            } 
                        echo "</select>";
                    echo "</p>";
                echo "</div>";        
            echo "</div>";

            echo "<div class='middle-rightI'>";
                echo "<div class='formElementSmall'>";        
                    echo "<p>Enter Cartoon Publication Date: <em>(mm/dd/yyyy)</em> * <input type='text' name='p_date' size='10' value='" . $pub_date ."' /></p>";
                echo "</div>";
            echo "</div>";
        echo "</div>";
        
        echo "<div class='middle'>";
            echo "<div class='middle-left'>";
                echo "<div class='formElementLarge'>";
                    echo "<p>Enter Caption for Cartoon: *</p>";
                        echo "<textarea name='title' cols=50 rows=4>";
                            echo $caption; 
                        echo "</textarea>";
                echo "</div>";
            echo "</div>";
        
            echo "<div class='middle-right'>";
                echo "<div class='formElementLarge'>";
                    echo "<p>Enter Description for Cartoon: *</p>";
                        echo "<textarea name='description' cols=50 rows=4>";
                            echo $description; 
                        echo "</textarea>";
                echo "</div>";
            echo "</div>";
        echo "</div>";

        echo "<div id='leftside'>";
            echo "<div class='formElementSmall'>";        
                echo "<p>Add Event:";
                    echo "<input type='text' name='new_event' size='50'/></p>";
            echo "</div>";
            
            echo "<div class='formElementSmallI'>";
                echo "<p>or Choose an Event:";
                    $events = mysql_query("SELECT * FROM events ORDER BY event asc");
                        echo "<select name='events'>";
                    option_select($events, 'event_no', $events_id, 'event', $id);
                echo "</p>";
            echo "</div>";

            echo "<div class='formElementMedium'>";        
                echo "<p>Add New Character(s): <em>use comma ', ' for multiple entries</em></p>";
                    echo "<input type='text' name='new_actors' size='50'/>";
            echo "</div>";

            echo "<div class='formElementXLarge'>";
                echo "<p>and/or Choose Character(s): <em>command for multiple entries</em></p>";
                        $characters = mysql_query("SELECT * FROM characters ORDER BY actor asc");
                    echo "<select name='actors[]' multiple='yes' size='30' id='select_id'>";
                        option_select($characters, 'actor_no', $actor_id, 'actor', $id);
            echo "</div>";
        echo "</div>";

        echo "<div id='rightside'>";
            echo "<div class='formElementSmall'>";
                echo "<p>Add Theme:";
                    echo "<input type='text' name='new_theme' size='50'/></p>";
            echo "</div>";
            
            echo "<div class='formElementSmallI'>";
                echo "<p>or Choose a Theme:";
                    $themes = mysql_query("SELECT * FROM themes ORDER BY theme asc");
                        echo "<select name='themes'>";
                            option_select($themes, 'theme_no', $themes_id, 'theme', $id);
                echo "</p>";
            echo "</div>";

            echo "<div class='formElementMedium'>";
                echo "<p>Add New Keyword(s): <em>use comma ', ' for multiple entries</em></p>";
                    echo "<input type='text' name='new_keywords' size='50'/>";
            echo "</div>";

            echo "<div class='formElementXLarge'>";
                echo "<p>and/or Choose Keyword(s): <em>command for multiple entries</em></p>";
                    $keywords = mysql_query("SELECT * FROM keywords ORDER BY keyword asc");
                        echo "<select name='keywords[]' multiple='yes' size='30'>";
                    option_select($keywords, 'keyw_no', $keywords_id, 'keyword', $id);
            echo "</div>";

        echo "</div>";
echo "<div class='clearfloat'></div>";
    echo "<br /><input type='submit' name='submit' value='Submit' />"; 
echo "<br />";
    echo "</form>"; 

echo "<div class='clearfloat'></div>";
echo "<br />";
    echo "</body>";
    echo "</html>";
} // ends function renderForm

function option_select ($query, $pk_field, $array, $category_name, $id) {
    echo "<option value=''>  --- </option>"; 
    while ($row = mysql_fetch_array($query)) {
        echo "<option value ='$row[$pk_field]'" ;
            if ($id != '') {
                if ($array != '') {
                    foreach ($array as $element) {
                        if ($element == $row[$pk_field]) {
                            echo " selected "; }}}}
        echo ">";
        echo $row[$category_name];
        echo "</option>";
    }
    echo "</select>";
} // ends function

function delete_meta($delete_table_name, $id) {
    $delete_meta="DELETE FROM " .$delete_table_name ." WHERE fk_toon_no=".$id;
        mysql_query($delete_meta) or die('Error deleting joiner table');
} // end function delete_meta

function new_char_table($char_to_add, $new_toon_id){
    $new_char_arr = explode(', ', $char_to_add);
        foreach ($new_char_arr as $new_char_add) {
            if (!empty($new_char_add)) {
                $new_char = "INSERT INTO characters (actor_no, actor) VALUES ('NULL', '".$new_char_add."')";
                        mysql_query($new_char) or die('Error adding new character');
                $new_char_id = mysql_insert_id();
                $new_cartoon_actor = "INSERT INTO cartoon_characters (fk_toon_no, fk_actor_no) VALUES 
                            ('".$new_toon_id."', '".$new_char_id."')"; 
                        mysql_query($new_cartoon_actor) or die('Error updating cartoon_characters table with new actor');
            }
        }
} // end function new_char_table

function join_table($join_table_name, $FK_field_name, $array_element, $new_toon_id) {
    if ($array_element != 0) {
    $existing_entry = "INSERT INTO " .$join_table_name ." (fk_toon_no, " .$FK_field_name .") VALUES
                  ('".$new_toon_id."', '".$array_element."')";
                          mysql_query($existing_entry) or die('Error updating joiner table'); }
} //ends function join_table

function all_event_tables($new_event, $cartoon_event, $new_toon_id) {
    if (!empty($new_event)) {
        $new_eventq = "INSERT INTO events (event_no, event) VALUES ('NULL', '".$new_event."')";
            mysql_query($new_eventq) or die('Error adding new event');
        $new_event_id = mysql_insert_id();
        $new_cartoon_event = "INSERT INTO cartoon_events (fk_toon_no, fk_event_no) VALUES ('".$new_toon_id."', '".$new_event_id."')"; 
            mysql_query($new_cartoon_event) or die('Error updating cartoon_events table with new event');
    } else {
        join_table('cartoon_events', 'fk_event_no', $cartoon_event, $new_toon_id);
    }
} //ends all_event_tables function

function all_theme_tables($new_theme, $cartoon_theme, $new_toon_id) {
    if (!empty($new_theme)){
        $new_themeq = "INSERT INTO themes (theme_no, theme) VALUES ('NULL', '".$new_theme."')";
            mysql_query($new_themeq) or die('Error adding new theme');
        $new_theme_id = mysql_insert_id();
        $new_cartoon_theme = "INSERT INTO cartoon_themes (fk_toon_no, fk_theme_no) VALUES ('".$new_toon_id."', '".$new_theme_id."')"; 
            mysql_query($new_cartoon_theme) or die('Error updating cartoon_themes table with new theme');
    } else {
        join_table('cartoon_themes', 'fk_theme_no', $cartoon_theme, $new_toon_id);
    }
} //ends all_theme_tables function

function new_keyword_table($keyword_to_add, $new_toon_id){
    $new_keyword_arr = explode(', ', $keyword_to_add);
        foreach ($new_keyword_arr as $new_keyword_add) {
            if (!empty($new_keyword_add)) {
                $new_keyword = "INSERT INTO keywords (keyw_no, keyword) VALUES ('NULL', '".$new_keyword_add."')";
                        mysql_query($new_keyword) or die('Error adding new keyword');
                $new_keyword_id = mysql_insert_id();
                $new_cartoon_keyword = "INSERT INTO cartoon_keywords (fk_toon_no, fk_keyw_no) VALUES 
                            ('".$new_toon_id."', '".$new_keyword_id."')"; 
                        mysql_query($new_cartoon_keyword) or die('Error updating cartoon_keywords table with new keyword');
            }
        }
} // ends new_keyword_table function


// EDIT RECORD
// if the 'id' variable is set in the URL, we know that we need to edit a record
if (isset($_GET['toon_no'])) {
    // if the form's submit button is clicked, we need to process the form
    if (isset($_POST['submit'])) {
        // make sure the 'id' in the URL is valid
        if (is_numeric($_POST['toon_no'])) {
            // get variables from the URL/form
            $id = $_POST['toon_no'];
            $artist_id = $_POST['fk_artist_no'];
            $pub_date =$_POST['p_date'];
            $caption = htmlentities($_POST['title'], ENT_QUOTES);
            $new_actors = htmlentities($_POST['new_actors'], ENT_QUOTES);
            $cartoon_actors=$_POST['actors'];
            $new_event = htmlentities($_POST['new_event'], ENT_QUOTES);
            $cartoon_event=$_POST['events'];
            $new_theme = htmlentities($_POST['new_theme'], ENT_QUOTES);
            $cartoon_theme=$_POST['themes'];
            $new_keywords = htmlentities($_POST['new_keywords'], ENT_QUOTES);
            $cartoon_keywords=$_POST['keywords'];
            $description=htmlentities($_POST['description'], ENT_QUOTES);
                // check that required fields are not empty
                if ($artist_id == '' || $pub_date == '' || $caption == '' || $description == '') {
                    // if they are empty, show an error message and display the form
                    $error = 'ERROR: Please fill in all required fields!';
                    renderForm($artist_id, $pub_date, $caption, $description, $error, $id);
                } else {
                        // explode date and reformat in MySQL order 
                        $pub_date=explode('/', $pub_date);
                        $mysqlPDate = $pub_date[2].'-'.$pub_date[0].'-'.$pub_date[1];          
                    // if everything is fine, update the record in the database
                    if ($stmt = $mysqli->prepare("UPDATE cartoons SET fk_artist_no = ?, p_date = ?, title = ?, description = ? WHERE toon_no=?")) {
                        $stmt->bind_param("isssi", $artist_id, $mysqlPDate, $caption, $description, $id);
                        $stmt->execute();
                        $stmt->close();
                    } else {
                        // show an error message if the query has an error
                        echo "ERROR: could not prepare SQL statement.";
                    }
                    delete_meta('cartoon_characters', $id);
                    foreach($cartoon_actors as $cartoon_actor) {
                        if ($cartoon_actor>= 1) {
                            join_table('cartoon_characters', 'fk_actor_no', $cartoon_actor, $id); } }
                    new_char_table ($new_actors, $id);
                    delete_meta('cartoon_events', $id);
                    all_event_tables($new_event, $cartoon_event, $id);
                    delete_meta('cartoon_themes', $id);
                    all_theme_tables($new_theme, $cartoon_theme, $id);
                    delete_meta('cartoon_keywords', $id);
                    foreach($cartoon_keywords as $cartoon_keyword) {
                        if ($cartoon_keyword >= 1) {
                            join_table('cartoon_keywords', 'fk_keyw_no', $cartoon_keyword, $id); } }
                    new_keyword_table ($new_keywords, $id);
                }
                // redirect the user once the form is updated
            header("Location: FullDatabase.php");
        } else {
            // if the 'id' variable is not valid, show an error message
            echo "Error!";
        }
    }
    
    // if the form hasn't been submitted yet, get the info from the database and show the form
    else {
        // make sure the 'id' value is valid
        if (is_numeric($_GET['toon_no']) && $_GET['toon_no'] > 0) {
            // get 'id' from URL
            $id = $_GET['toon_no'];
                // get the record from the database
                if($stmt = $mysqli->prepare("SELECT * FROM cartoons WHERE toon_no=?")) {               
                    $stmt->bind_param("i", $id);
                    $stmt->execute();
                    $stmt->bind_result($id, $artist_id, $pub_date, $caption, $description);
                    $stmt->fetch();
                        $pub_date=explode('-', $pub_date);
                        $p_date = $pub_date[1].'/'.$pub_date[2].'/'.$pub_date[0];                 
                    $stmt->close();
                }
                // queries below create an arrays of all the selected categories to pass to the form in a variable
                $actor_query = "SELECT * FROM cartoon_characters WHERE fk_toon_no=".$id;
                    $actor_array = mysql_query($actor_query);
                        while ($row = mysql_fetch_assoc($actor_array)) {
                            $actor_id[] = $row['fk_actor_no']; }
                $event_query = "SELECT * FROM cartoon_events WHERE fk_toon_no=".$id;
                    $event_array = mysql_query($event_query);
                        while ($row = mysql_fetch_assoc($event_array)) {
                            $events_id[] = $row['fk_event_no']; }
                $theme_query = "SELECT * FROM cartoon_themes WHERE fk_toon_no=".$id;
                    $theme_array = mysql_query($theme_query);
                        while ($row = mysql_fetch_assoc($theme_array)) {
                            $themes_id[] = $row['fk_theme_no']; }
                $keyword_query = "SELECT * FROM cartoon_keywords WHERE fk_toon_no=".$id;
                    $keyword_array = mysql_query($keyword_query);
                        while ($row = mysql_fetch_assoc($keyword_array)) {
                            $keywords_id[] = $row['fk_keyw_no']; }     
                // show the form
                renderForm($artist_id, $p_date, $caption, $description, $id, NULL, $actor_id, $events_id, $themes_id, $keywords_id);        
        // if the 'id' value is not valid, redirect the user back to the viewcartoons.php page
        } else {
            header("Location: FullDatabase.php");
        }
    }
}

// NEW RECORD 
// if the 'id' variable is not set in the URL, we must be creating a new record
else {
    // if the form's submit button is clicked, we need to process the form
    if (isset($_POST['submit'])){
        // get the form data
        $artist_id = $_POST['fk_artist_no'];
        $pub_date =$_POST['p_date'];
        $caption = htmlentities($_POST['title'], ENT_QUOTES);
        $new_actors = htmlentities($_POST['new_actors'], ENT_QUOTES);
        $cartoon_actors=$_POST['actors'];
        $new_event = htmlentities($_POST['new_event'], ENT_QUOTES);
        $cartoon_event=$_POST['events'];
        $new_theme=htmlentities($_POST['new_theme'], ENT_QUOTES);
        $cartoon_theme=$_POST['themes'];
        $new_keywords=htmlentities($_POST['new_keywords'], ENT_QUOTES);
        $cartoon_keywords=$_POST['keywords'];
        $description=htmlentities($_POST['description'], ENT_QUOTES);
            // check that required fields are not empty
            if ($artist_id == '' || $caption == '' || $pub_date == '' || $description == '') {
                // if they are empty, show an error message and display the form
                $error = 'ERROR: Please fill in all required fields!';
                renderForm($artist_id, $pub_date, $caption, $description, $error);    
            } else {
                    // explode date and reformat in MySQL order 
                    $pub_date=explode('/', $pub_date);
                        $mysqlPDate = $pub_date[2].'-'.$pub_date[0].'-'.$pub_date[1];               
                // insert the new cartoon into the database
                $new_toon = "INSERT INTO cartoons (toon_no, fk_artist_no, p_date, title, description) 
                            VALUES ('NULL', '".$artist_id."', '".$mysqlPDate."', '".$caption."', '".$description."')";
                        mysql_query($new_toon) or die('Error adding new cartoon ');
                    $new_toon_id = mysql_insert_id();
                    
                // adds new and/or existing categories into database and joiner tables
                new_char_table($new_actors, $new_toon_id);
                foreach($cartoon_actors as $cartoon_actor) {
                        join_table('cartoon_characters', 'fk_actor_no', $cartoon_actor, $new_toon_id); }
                all_event_tables($new_event, $cartoon_event, $new_toon_id);
                all_theme_tables($new_theme, $cartoon_theme, $new_toon_id);
                new_keyword_table($new_keywords, $new_toon_id);
                foreach($cartoon_keywords as $cartoon_keyword) {
                        join_table('cartoon_keywords', 'fk_keyw_no', $cartoon_keyword, $new_toon_id); }
            }
            // redirect the user
            header("Location: FullDatabase.php");
    // if the form hasn't been submitted yet, show the form
    } else {
        renderForm();
    }
}
        
        // close the mysqli connection
        $mysqli->close();
?> 
<p><a href="database.php">Return to Database Home</a></p>
<?php require 'footer.php'; ?>
<? ob_flush(); ?>