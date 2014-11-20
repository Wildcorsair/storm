<?php
define ("ROOT", $_SERVER['DOCUMENT_ROOT']);

function __autoload ($className) {
    $fullPath = ROOT."/core/".$className.".class.php";
    if (file_exists($fullPath)) {
        include_once ($fullPath);
    }
}

class CommonModel extends BDatabase {
    
    public function getBoardsList() {
        $items = null;
        $query = "SELECT * FROM `stm_boards` LIMIT 0, 30";
        $data = $this->selectBySql($query);
        if (!empty($data)) {
            foreach ($data as $value) {
                $items .= "<li data-value='{$value->fid}'>{$value->fboardName}</li>";
            }
        }
        echo $items;
    }
}

?>