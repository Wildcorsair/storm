<?php
    $data = null;
    if (isset($_GET['id'])) {
        $id = intval($_GET['id']);
        $query = 'SELECT `stm_tasks`.`fid`,
                         `stm_tasks`.`fphoneNumber`,
                         `stm_tasks`.`fboardId`,
                         `stm_boards`.`fboardName`,
                         `stm_tasks`.`fport`,
                         `stm_tasks`.`fdamageReason`,
                         `stm_tasks`.`frepairNote`,
                         `stm_tasks`.`fstartDateTime`,
                         `stm_tasks`.`fendDateTime`
                  FROM `stm_tasks`
                  LEFT JOIN `stm_boards` ON `stm_tasks`.`fboardId` = `stm_boards`.`fid`
                  WHERE `stm_tasks`.`fid` = :i
                  LIMIT 0, 1';
        $cond = array($id);
        $data = $this->model->selectBySql($query, $cond);
        $data = $data[0];
    }
?>
<div id='taskAddFrm' class='window-frame grey taskEdit'>
    <div class='caption'>
        Изменить задание
        <button class='btn-tb f-right ico-close' name='win-close'></button>
    </div>
    <div class='workspace'>
        <fieldset id='subscriberInfo'>
            <legend>Технические данные</legend>
            <table class='form-controls-grid'>
                <tr>
                    <td width='120'>Номер телефона</td>
                    <td>
                        <input type='hidden' name='taskId' value='<?php echo $data->fid; ?>'>
                        <input class='text-field' type='text' name='phoneNumber'
                            size='5' maxlength='5' value='<?php echo $data->fphoneNumber; ?>'>
                    </td>
                    <td>Наименование платы</td>
                    <td>
                        <div id='4' class='dropdown'>
                            <input class='' type='text' 
                                    name='boardVal' value='<?php echo $data->fboardName; ?>'>
                            <input type='hidden' name='boardId' 
                                   value='<?php echo $data->fboardId; ?>'>
                            <div class='dd-btn ico-down'></div>                     
                            <div class='items' id='4'>
                                <ul>
                                    <?php
                                        $this->model->getBoardsList();
                                    ?>
                                </ul>
                            </div>
                        </div>
                    </td>
                    <td>Номер порта</td>
                    <td>
                        <input class='text-field' type='text' name='portNumber'
                               size='2' maxlength='3' 
                               value='<?php echo $data->fport; ?>'>
                    </td>
                </tr>
            </table>
        </fieldset>
        <fieldset id='taskInfo'>
            <legend>Информация о наряде</legend>
            <table class='form-controls-grid'>
                <tr>
                    <td colspan='2'>
                        Причина обращения<br />
                        <textarea name='damageReason'><?php echo $data->fdamageReason; ?></textarea>
                    </td>
                </tr>
                <tr>
                    <td>Наряд создан</td>
                    <td>
                        <div id='2' class='dt-picker'>
                            <input class='' type='text' 
                                name='startDateTime'
                                value='<?php echo $this->model->dateTimeConvert($data->fstartDateTime); ?>'>
                            <div class='dt-btn ico-date'></div>
                            <div id='2' class='dt-conteiner'>
                                <button class='btn-tb ico-prev f-left'></button>
                                <div class='monthYear f-left'></div>
                                <button class='btn-tb ico-next f-right'></button>
                                <table class='dt-calendar'>
                                    <thead>
                                        <tr>
                                            <th>Пн</th><th>Вт</th><th>Ср</th><th>Чт</th><th>Пт</th><th>Сб</th><th>Вс</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                                <div class='time-block'>
                                    <table>
                                        <tr>
                                            <td>
                                                <input class='hour' type='text' name='hour'
                                                        maxlength='2' value='00'>
                                            </td>
                                            <td>:</td>
                                            <td>
                                                <input class='min' type='text' name='min' 
                                                        maxlength='2' value='00'>
                                            </td>
                                            <td>:</td>
                                            <td>
                                                <input class='sec' type='text' name='sec' 
                                                        maxlength='2' value='00'>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
            </table>
        </fieldset>
        <fieldset id='repairInform'>
            <legend>Информация о ремонте</legend>
            <table class="form-controls-grid">
                <tr>
                    <td colspan='2'>
                        Отметка о ремонте:<br />
                        <textarea name='repairNote'><?php echo $data->frepairNote; ?></textarea>
                    </td>
                </tr>
                <tr>    
                    <td>Наряд закрыт</td>
                    <td>
                        <div id='1' class='dt-picker'>
                            <input class='' type='text' 
                                name='endDateTime' 
                                value='<?php echo $this->model->dateTimeConvert($data->fendDateTime); ?>'>
                            <div class='dt-btn ico-date'></div>
                            <div id='1' class='dt-conteiner'>
                                <button class='btn-tb ico-prev f-left'></button>
                                <div class='monthYear f-left'></div>
                                <button class='btn-tb ico-next f-right'></button>
                                <table class='dt-calendar'>
                                    <thead>
                                        <tr>
                                            <th>Пн</th><th>Вт</th><th>Ср</th><th>Чт</th><th>Пт</th><th>Сб</th><th>Вс</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                                <div class='time-block'>
                                    <table>
                                        <tr>
                                            <td>
                                                <input class='hour' type='text' name='hour'
                                                        maxlength='2' value='00'>
                                            </td>
                                            <td>:</td>
                                            <td>
                                                <input class='min' type='text' name='min' 
                                                        maxlength='2' value='00'>
                                            </td>
                                            <td>:</td>
                                            <td>
                                                <input class='sec' type='text' name='sec' 
                                                        maxlength='2' value='00'>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
            </table>
        </fieldset>
    </div>
    <div class='btn-bar'>
        <button id='taskUpdateSave' class='btn large success'>Сохранить</button>
        <button id='taskAddCancel' class='btn normal'>Отмена</button>
    </div>
</div>
    <script type="text/javascript" 
                src="http://UI-Controls/js/function.js"></script>
