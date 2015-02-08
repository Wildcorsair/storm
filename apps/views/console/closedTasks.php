<div>
    <!--<div>
      Отображение за период&nbsp;
      <button class='btn normal' name='select'>Выбрать</button>
      <br /><br />
    </div>-->
    <?php
        $dataSet = $this->model->closedTasksList($this->currentPage);
        if (!empty($dataSet)) {
            $fields = array('fphoneNumber'      => array('Номер', 5),
                            'fboardName'        => array('Наименование платы', 10),
                            'fport'             => array('Порт', 5),
                            'fdamageReason'     => array('Причина повреждения', 5),
                            'frepairNote'       => array('Заметка о ремонте', 5),
                            'fstartDateTime'    => array('Дата регистрации', 10),
                            'fendDateTime'      => array('Дата ремонта', 10));
            $this->model->dataGrid($dataSet,
                                   $fields,
                                   'closedTasks',
                                   'Закрытые задания',
                                   8,
                                   true);
        }
    ?>
</div>