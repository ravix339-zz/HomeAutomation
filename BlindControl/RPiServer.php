<?php
    if( !$link = mysql_connect( 'localhost', 'root', 'MySQLPassword' ) ) {
        echo 'Could not connect to MySQL';
        exit;
    }

    if( !mysql_select_db( 'HomeAutomation', $link ) ) {
        echo 'Could not select database';
        exit;
    }

    if( $_GET["BlindName"] && $_GET["PercentOpen"] ) {
        $sqlQuery = 'UPDATE BlindControl SET OldPercentOpen = PercentOpen, PercentOpen = ' . $_GET["PercentOpen"] . ' WHERE BlindName LIKE ' . $_GET["BlindName"] . '%';
        $result = mysql_query($sqlQuery, $link);
        if ( !$result ) {
            echo "DB Error, could not query database \n";
            echo "MySQL Error: " . mysql_error();
            exit;
        }
        while ( $row = mysql_fetch_assoc($result) ) {
            echo $row["BlindName"] . " was affected. \n";
        }
        mysql_free_result($result);
    }
    elseif ( $_GET["IPAddress"] && $_GET["BlindName"] ) {
        if ( mysql_num_rows(mysql_query("SELECT * FROM HomeAutomation WHERE IPAddress = " . $GET["IPAddress"])) == 0 ) {
            $sqlQuery = 'INSERT INTO BlindControl VALUES (' .  $_GET["IPAddress"] . ', ' . $_GET["BlindName"] . ', 100, 100)';
            $result = mysql_query($sqlQuery, $link);
            if ( !$result ) {
                echo "DB Error, could not query database \n";
                echo "MySQL Error: " . mysql_error();
                exit;
            }
            while ( $row = mysql_fetch_assoc($result) ) {
                echo $row["BlindName"] . " was affected. \n";
            }
        }
        mysql_free_result($result);
    }
    else{
        echo "Please follow the following format... /?blindName=BLIND_NAME&percentOpen=PERCENTAGE";
    }
?>