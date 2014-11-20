<?php

$db = new mysqli('localhost', 'root', '', 'stormBase') 
                or die("Database error: ".$this->db->error);
$db->set_charset("UTF8");
/*$pn = json_decode($_POST['phoneNumber']);
$bi = json_decode($_POST['boardId']);
$pt = json_decode($_POST['portNumber']);
$dr = json_decode($_POST['damageReason']);
$st = json_decode($_POST['startDateTime']);*/

$pn = $_POST['phoneNumber'];
$bi = $_POST['boardId'];
$pt = $_POST['portNumber'];
$dr = $_POST['damageReason'];
$st = $_POST['startDateTime'];
/*$pn = '61381';
$bi = 3;
$pt = 12;
$dr = 'Модем перегружается';
$st = '2014-10-14';*/

//echo "{$pn}, {$bi}, {$pt}, {$dr}, {$st}";

$query = "INSERT INTO `stm_tasks` (`fphoneNumber`,
                                    `fboardId`,
                                    `fport`,
                                    `fdamageReason`,
                                    `fstartDateTime`) 
          VALUES ('{$pn}',
                  '{$bi}',
                  '{$pt}',
                  '{$dr}',
                  '{$st}')";
$result = $db->query($query) or die ('Database error: ' . $db->error);

if (!$db->errno) {
    return $db->affected_rows;
} else {
    return $db->errno;
}
?>