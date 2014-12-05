<div>
    <div>
      <button class='btn large' name='taskAdd'>Добавить задание</button>
      <br /><br />
    </div>
    <?php
        $dataSet = $this->model->activeTasksList($this->currentPage);
        if (!empty($dataSet)) {
            $fields = array('fphoneNumber'      => array('Номер', 5),
                            'fboardName'        => array('Наименование платы', 15),
                            'fport'             => array('Порт', '5'),
                            'fdamageReason'     => array('Причина повреждения', '45'),
                            'frepairNote'       => array('Заметка о ремонте', '45'),
                            'fstartDateTime'    => array('Дата регистрации', '10'),
                            'fendDateTime'      => array('Дата ремонта', '10'));
            $this->model->dataGrid($dataSet,
                                   $fields,
                                   'activeTasks',
                                   'Активные задания',
                                   10,
                                   false);
        }
    ?>
</div>