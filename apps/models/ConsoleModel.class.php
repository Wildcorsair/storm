<?php

class ConsoleModel extends BDatabase {
    public $tableName = 'stm_tasks';
    public $primaryKey = 'fid';
    private $_recsPerPage = 5;
    private $_offset = 0;
    public $currentPage;
    public $pageCount;

    public function avtiveTasksList($currentPage) {
        $this->_offset = ($currentPage - 1) * $this->_recsPerPage;
        $this->pageCount = $this->getPageCount($this->tableName, null);
        $this->currentPage = $currentPage;
        $query = 'SELECT `stm_tasks`.`fid`,
                         `fphoneNumber`,
                         `fboardId`,
                         `fport`,
                         `stm_boards`.`fboardName`,
                         `fdamageReason`,
                         `frepairNote`,
                         `fstartDateTime`,
                         `fendDateTime`
                  FROM `stm_tasks` LEFT JOIN `stm_boards` 
                  ON `stm_tasks`.`fboardId` = `stm_boards`.`fid`
                  LIMIT :i, :i;';
        $cond = array($this->_offset, $this->_recsPerPage);
        $data = $this->selectBySql($query, $cond);
        return $data;
    }

    public function taskAdd() {
        $this->fphoneNumber = $_POST['phoneNumber'];
        $this->fboardId = $_POST['boardId'];
        $this->fport = $_POST['portNumber'];
        $this->fdamageReason = $_POST['damageReason'];
        if (!empty($_POST['startDateTime'])) {
            $convDate = $this->dateTimeConvert($_POST['startDateTime']);
        }
        $this->fstartDateTime = $convDate;
        $this->insert();
    }

    public function taskUpdate() {
        $convDate = '0000-00-00 00:00:00';
        $taskId = $_POST['taskId'];
        $this->fphoneNumber = $_POST['phoneNumber'];
        $this->fboardId = $_POST['boardId'];
        $this->fport = $_POST['portNumber'];
        $this->fdamageReason = $_POST['damageReason'];
        $this->frepairNote = $_POST['repairNote'];
        if (!empty($_POST['startDateTime'])) {
            $convDate = $this->dateTimeConvert($_POST['startDateTime']);
        }
        $this->fstartDateTime = $convDate;
        $convDate = '0000-00-00 00:00:00';
        if (!empty($_POST['endDateTime'])) {
            $convDate = $this->dateTimeConvert($_POST['endDateTime']);
        }
        $this->fendDateTime = $convDate;
        $this->updateById($taskId);
    }

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

    public function dataGrid($dataSet, $fieldsList, $route, $title, $colspan) {
        $startRec = $this->_offset + 1;
        $recCount = count($dataSet);
        $endRec = $this->_offset + $recCount;
        echo "<table class='grey-table'><thead>
                <tr><th class='title' colspan='{$colspan}'>{$title}</th></tr>
                <tr>";
        foreach ($fieldsList as $fieldName => $fieldCaption) {
            echo "<th>".$fieldCaption."</th>";
        }
        echo "<th></th><th></th></tr></thead><tbody>";
        foreach ($dataSet as $record) {
            echo "<tr>";
                foreach ($fieldsList as $fieldName => $fieldCaption) {
                    if (($fieldName == 'fstartDateTime') || ($fieldName == 'fendDateTime')) {
                        echo "<td>".$this->dateTimeConvert($record->$fieldName)."</td>";
                    } else {
                        echo "<td>".htmlspecialchars($record->$fieldName)."</td>";
                    }
                }
            echo "<td class='btn-cont'>

                        <button class='btn-tb ico-edit' data-value='{$record->fid}'></button>
                    </td>
                    <td class='btn-cont'>
                        <a class='btn-tb ico-delete'
                            href='/{$route}Delete?id={$record->fid}'></a>
                    </td>
                    </tr>";
        }
        echo "</tbody>
                <tfoot>
                    <tr>
                        <td colspan='{$colspan}'>
                            <div class='pagination'>";
                            echo $this->pagination($this->currentPage, $route);
        echo                "</div>
                            <div class='counter'>
                                {$startRec} - {$endRec} из {$this->rc} записей
                            </div>
                        </td>
                    </tr>
                </tfoot></table>";
    }

    public function pagination( $currentPage,
                                    $route,
                                    $linkCount=5,
                                    $paramStr=null ) {
        $pageStr = null;
        $pageCount = $this->pageCount;
        if (!isset($currentPage) && !is_numeric($currentPage)) {
            $currentPage = 1;
        }
    
        if ($currentPage <= 0) {
            $currentPage = 1;
        } elseif ($currentPage > $pageCount) {
            $currentPage = $pageCount;
        }
        
        $prevPage = $currentPage - 1;
        $nextPage = $currentPage + 1;
        
        if ($pageCount <= $linkCount) {
            for ($pageNum = 1; $pageNum <= $pageCount; $pageNum++) { 
                $this->linkageNavString($pageStr, $pageNum, $currentPage, $route, $paramStr);
            }
        } else {
            $leftOffset = $currentPage - 2;
            $rightOffset = $currentPage + 2;

            if ($leftOffset <= 2) {
                $leftOffset = 1;
                /*
                    Если количество страниц будет всего на 1-ну больше чем значение в
                    $linkCount, то добавляем еще одну ссылку на страницу, для того 
                    чтобы не вставлялось многоточие между предпоследней и последней ссылкой
                    вот так: 1 2 3 4 5 ... 6
                */
                if ($pageCount == ($linkCount + 1)) {
                    for ($pageNum = $leftOffset; $pageNum <= $linkCount + 1; $pageNum++) {
                        $this->linkageNavString($pageStr, $pageNum, $currentPage, $route, $paramStr);
                    }
                } else {
                    for ($pageNum = $leftOffset; $pageNum <= $linkCount; $pageNum++) {
                        $this->linkageNavString($pageStr, $pageNum, $currentPage, $route);
                    }
                    $pageStr .= "<a class='btn f-left ico-next' href='/{$route}/{$nextPage}'></a>";
                    $pageStr .= "<a class='btn f-left ico-last' href='/".$route."/{$pageCount}{$paramStr}'></a>";
                }
            } else if ($rightOffset >= $pageCount - 1) {
                $leftOffset = $pageCount - $linkCount;
                /*
                    Тоже что и выше, если правый сдвиг вышел за диапазон страниц, но при этом
                    ссылки начинаюся с 1-й страницы, то выводим строку ссылок без многоточий,
                    чтобы не было вот так 1 ... 2 3 4 5 6 
                */
            if ($leftOffset == 1) {
                    for ($pageNum = $leftOffset; $pageNum <= $linkCount + 1; $pageNum++) {
                        $this->linkageNavString($pageStr, $pageNum, $currentPage, $route, $paramStr);
                    }
                } else {
                    $pageStr .= "<a class='btn f-left ico-first' href='/".$route."/1{$paramStr}'></a>";
                    $pageStr .= "<a class='btn f-left ico-prev' href='/{$route}/{$prevPage}'></a>";
                    $leftOffset++;
                    for ($pageNum = $leftOffset; $pageNum <= $pageCount; $pageNum++) {
                        $this->linkageNavString($pageStr, $pageNum, $currentPage, $route, $paramStr);
                    }
                }

            } else {
                /*
                    Блок вывода средней части пагинации с кнопками "first" и
                    "last" по краям
                */
                $pageStr .= "<a class='btn f-left ico-first' href='/".$route."/1?{$paramStr}'></a>";
                $pageStr .= "<a class='btn f-left ico-prev' href='/{$route}/{$prevPage}'></a>";
                for ($pageNum = $leftOffset; $pageNum <= $rightOffset; $pageNum++) {
                    $this->linkageNavString($pageStr, $pageNum, $currentPage, $route, $paramStr);
                }
                $pageStr .= "<a class='btn f-left ico-next' href='/{$route}/{$nextPage}'></a>";
                $pageStr .= "<a class='btn f-left ico-last' href='/".$route."/{$pageCount}{$paramStr}'></a>";
            }
        }
        return $pageStr;
    }
    
    private function linkageNavString(&$linkStr, $pageNum, $currentPage, $route, $paramStr=null) {
        if ($pageNum == $currentPage) {
            $linkStr .= "<span class='btn f-left active' href='/".$route."/{$pageNum}{$paramStr}' class='curr-page'>{$pageNum}</span>\n";
            //$linkStr .= "<a class='btn f-left active' href='/".$route."/{$pageNum}{$paramStr}' class='curr-page'>{$pageNum}</a>\n";
        } else {
            $linkStr .= "<a class='btn f-left' href='/".$route."/{$pageNum}{$paramStr}'>{$pageNum}</a>\n";
        }
    }
    public function getPageCount($tableName, $cond) {
        $pageCount = 1;
        $recordsCount = $this->recCountCond($tableName, $cond);
        $this->rc = $recordsCount;
        if ($recordsCount > 0) {
            $pageCount = ceil($recordsCount / $this->_recsPerPage);
        }
        return $pageCount;
    }

    /*
        $cond = string ('`fcategory` = 1 AND `fauthor_id` = 15');
    */
    
    public function recCountCond($tableName, $cond = null) {
        $count = 0;
        $condStr = 'WHERE ';
        $query = "SELECT COUNT(`{$this->primaryKey}`) AS `count`
                    FROM `{$tableName}` ";
        if (isset($cond)) {
            $query .= "WHERE {$cond} ";
        }
        $query .= 'LIMIT 0, 1';
        $result = $this->db->query($query) 
                    or die("Database Error: " . $this->db->error);
            if ($result->num_rows > 0) {
                $count = $result->fetch_assoc();
            }
        $result->close();
        return $count['count']; //Returns INTEGER value
    }

    public function diff() {
        $query = 'SELECT 
                        `fid`,
                        `fphoneNumber`,
                        `fstartDateTime`
                  FROM `stm_tasks`
                  WHERE `fid` = :i
                  LIMIT :i, :i';
        $cond = array(22, 0, 30);
        $dataSet = $this->selectBySql($query, $cond);
        echo $dataSet[0]->fphoneNumber.'<br />';
        echo $dataSet[0]->fstartDateTime.'<br />';
        echo date('Y-m-d H:i:s').'<br />';
        $diff = strtotime(date('Y-m-d H:i:s')) - strtotime($dataSet[0]->fstartDateTime);
        
        echo 'Секунд: '.$diff.'<br />';
        
        $days = floor((($diff/60)/60)/24);
        $hours = floor(($diff - (60*60*24)*$days)/60/60);
        //$minutes = ($diff - ((60*60*24)*$days)+((60*60)*$hours))/60;
        $minutes = $diff - ((86400*$days)+(3600*$hours));
        echo 'Cекунд в минутах: '.$minutes.'<br />';
        $minutes = $minutes / 60;
        echo 'Дней: '.$days.'<br />';
        echo 'Часов: '.$hours.'<br />';
        echo 'Минут: '.floor($minutes).'<br />';
    }
}

?>