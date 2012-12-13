<?php require 'head.php'; ?>

<body id="Database">
<body class="FullDB">

<?php require 'header.php'; 

$id = $_GET['toon_no']; 
// connect to the database
include("connect-real-db.php");

$recent_cartoon = "SELECT * FROM cartoons WHERE toon_no=" .$id; 

$cartoonist = "SELECT cartoonists.artist_no, cartoonists.l_name, cartoonists.f_name, cartoonists.paper, cartoons.toon_no, cartoons.fk_artist_no "
."FROM cartoonists, cartoons "
."WHERE cartoons.toon_no = " .$id
." HAVING cartoonists.artist_no = cartoons.fk_artist_no";

$recent_char = "SELECT cartoon_characters.fk_toon_no, cartoon_characters.fk_actor_no, characters.actor_no, characters.actor "
."FROM cartoon_characters, characters "
."WHERE cartoon_characters.fk_toon_no = " .$id
." HAVING cartoon_characters.fk_actor_no = characters.actor_no";

/*$recent_event = "SELECT cartoon_events.fk_toon_no, cartoon_events.fk_event_no, events.event_no, events.event "
."FROM cartoon_events, events "
."WHERE cartoon_events.fk_toon_no = " .$id
." HAVING cartoon_events.fk_event_no = events.event_no";
*/
$recent_keyword = "SELECT cartoon_keywords.fk_toon_no, cartoon_keywords.fk_keyw_no, keywords.keyw_no, keywords.keyword "
."FROM cartoon_keywords, keywords "
."WHERE cartoon_keywords.fk_toon_no = " .$id
." HAVING cartoon_keywords.fk_keyw_no = keywords.keyw_no";

?>
<div id="content">
    <h3>Artist:</h3>
        <?php if ($current_cartoonist=mysql_query($cartoonist)) { ?>
            <table>
                <tr>
                    <th>Name</th><th>Paper</th><th></th>
                </tr>
        <?php while ($row=mysql_fetch_array($current_cartoonist)) { ?>
                <tr>
                    <td><?php echo $row['f_name'] ." " .$row['l_name'];?></td>
                    <td><?php echo $row['paper'];?></td>
                    <?php echo "<td><a href='ArtistView.php?artist=" . $row['artist_no'] . "'>View All</a></td>"; ?>
        <?php } ?>
                </tr>
        <?php } ?>
            </table>

    <h3>Cartoon:</h3>
        <?php if ($cartoon_result=mysql_query($recent_cartoon)) { ?>
            <table>
                <tr>
                    <th>Publication Date</th><th>Caption</th><th>Description</th>
                </tr>
        <?php while ($row=mysql_fetch_array($cartoon_result)) { 
            $p_date=$row['p_date'];
            $pub_date=explode('-', $p_date);
            $mysqlPDate = $pub_date[1].'/'.$pub_date[2].'/'.$pub_date[0];?>
                <tr>
                    <td><?php echo $mysqlPDate;?></td>
                    <td><?php echo $row['title'];?></td>
                    <td><?php echo $row['description'];?></td>
        <?php } ?>
                </tr>
        <?php } ?>
            </table>

<div id='leftside'>
<!--    <div class='TableElement'>
    <h3>Event:</h3>
      <?php if ($recent_event_result=mysql_query($recent_event)) { ?>
        <table>
          <tr>
            <th>Event</th><th></th>
          </tr>
          <tr>
            <?php while ($row=mysql_fetch_array($recent_event_result)) { ?>
              <td><?php echo $row['event'];?></td>
              <?php echo "<td><a href='ViewAll.php?events=" . $row['fk_event_no'] . "'>View All</a></td>"; ?>
          </tr>
      <?php } }?>
        </table>
    </div>
-->
    <div class='TableElement'>
    <h3>Characters:</h3>
        <?php if ($recent_char_result=mysql_query($recent_char)) { ?>
            <table>
                <tr>
                    <th>Character</th><th></th>
                </tr>
                <tr>
                    <?php while ($row=mysql_fetch_array($recent_char_result)) { ?>
                        <td><?php echo $row['actor'];?></td>
                        <?php echo "<td><a href='ViewAll.php?actors=" . $row['fk_actor_no'] . "'>View All</a></td>"; ?>
                </tr>
                    <?php } 
        }?>
            </table>
    </div>
</div> <!-- closes .leftside -->

 <div id='rightside'>
    <div class='TableElement'>
    <h3>Keywords:</h3>
        <?php if ($recent_keyword_result=mysql_query($recent_keyword)) { ?>
            <table>
                <tr>
                    <th>Keyword</th><th></th>
                </tr>
                <tr>
                    <?php while ($row=mysql_fetch_array($recent_keyword_result)) { ?>
                        <td><?php echo $row['keyword'];?></td>
                        <?php echo "<td><a href='ViewAll.php?keywords=" . $row['fk_keyw_no'] . "'>View All</a></td>"; ?>
                </tr>
                    <?php } 
        }?>
            </table>
    </div>
</div> <!-- closes .rightside -->

</div> <!-- closes #content -->
<div class='clearfloat'>
</div>
<p>Press Browser Back Button to Return to Search Results</p>
<p><a href="FullDatabase.php">Return to Full Database</a></p>
<?php require 'footer.php'; ?>