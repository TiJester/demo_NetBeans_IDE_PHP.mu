<?php
    session_start();
    if (array_key_exists("user", $_SESSION)) 
        {
        echo "Привет " . $_SESSION['user'];
        }
    else 
        { 
        header('Location: index.php'); 
        exit;         
        }
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//RU">
<html>
    <head>
       <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    </head>
    <body>
        <table border="black">
        <tr><th>Пункт</th><th>Срок</th><th>Редактировать</th><th>Удалить</th></tr>
        <?php
        require_once("Includes/db.php");
        $wisherID = WishDB::getInstance()->get_wisher_id_by_name($_SESSION["user"]);
        $result = WishDB::getInstance()->get_wishes_by_wisher_id($wisherID);
        
        while($row = mysqli_fetch_array($result)): 
            echo "<tr><td>" . htmlentities($row['description']) . "</td>";
            echo "<td>" . htmlentities($row['due_date']) . "</td>";
            $wishID = $row["id"];

        ?>
        <td>
            <form name="editWish" action="editWish.php" method="GET">
                <input type="hidden" name="wishID" value="<?php echo $wishID; ?>">
                <input type="submit" name="editWish" value="Редактировать">
            </form>
        </td>
        <td>
            <form name="deleteWish" action="deleteWish.php" method="POST">
                <input type="hidden" name="wishID" value="<?php echo $wishID; ?>"/>
                <input type="submit" name="deleteWish" value="Удалить"/>
            </form>
        </td>
    
        <?php
            echo "</tr>\n";
            endwhile;
            mysqli_free_result($result);
        ?>
        </table>
        <form name="addNewWish" action="editWish.php">            
            <input type="submit" value="Добавить желание">
        </form>
        <form name="backToMainPage" action="index.php">
            <input type="submit" value="На главную"/>
        </form>
    </body>
</html>