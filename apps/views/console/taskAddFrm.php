<?php
    //include_once '../../models/CommonModel.class.php';
    //$db = new CommonModel();
    /*$db = new mysqli('localhost', 'root', 'k13ju357', 'stormBase') 
                    or die("Database error: ".$this->db->error);
    $db->set_charset("UTF8");
    $query = "SELECT * FROM `stm_boards` LIMIT 0, 30";
    $result = $db->query($query);
    if ($result->num_rows > 0) {
        while ($record = $result->fetch_assoc()) {
            $dataSet[] = $record;
        }
    }*/
?>
<div id='taskAddFrm' class='window-frame grey taskAdd'>
    <div class='caption'>
        Новое задание
        <button class='btn-tb f-right ico-close' name='win-close'></button>
    </div>
    <div class='workspace'>
        <fieldset id='subscriberInfo'>
            <legend>Информация об абоненте</legend>
            <table class='form-controls-grid'>
                <tr>
                    <td>Номер телефона</td>
                    <td>
                        <input class='text-field' type='text'
                               name='phoneNumber' size='5' maxlength='5'>
                    </td>
                </tr>
                <tr>
                    <td>Наименование платы</td>
                    <td>
                        <div id='4' class='dropdown'>
                            <input class='' type='text' 
                                    name='boardVal' value='Выбрать...'>
                            <input type='hidden' name='boardId' value=''>
                            <div class='dd-btn ico-down'></div>                     
                            <div class='items' id='4'>
                                <ul>
                                    <?php
                                        $this->model->getBoardsList();
                                        //$db->getBoardsList();
                                    ?>
                                </ul>
                            </div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>Номер порта</td>
                    <td>
                        <input class='text-field' type='text'
                               name='portNumber' size='2' maxlength='3'>
                    </td>
                </tr>
            </table>
        </fieldset>
        <fieldset id='taskInfo'>
            <legend>Информация о наряде</legend>
            <table class='form-controls-grid'>
                <tr>
                    <td colspan='2'>
                        Причина обращения:<br />
                        <textarea name='damageReason'></textarea>
                    </td>
                </tr>
                <tr>
                    <td width='90'>Наряд создан</td>
                    <td>
                        <div id='3' class='dt-picker'>
                            <input class='' type='text' 
                                name='startDateTime' value=''>
                            <div class='dt-btn ico-date'></div>
                            <div id='3' class='dt-conteiner'>
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
        <button id='taskAddSave' class='btn large success'>Сохранить</button>
        <button id='taskAddCancel' class='btn normal'>Отмена</button>
    </div>
</div>
    <script type="text/javascript" 
                src="http://dbtest.org/UI-Controls/js/function.js"></script>