<div>
    <div>
      <button class='btn large' name='taskAdd'>Добавить задание</button>
      <br /><br />
    </div>
    <?php
        $dataSet = $this->model->activeTasksList($this->currentPage);
        if (!empty($dataSet)) {
            $fields = array('fphoneNumber'      => 'Номер',
                            'fboardName'        => 'Наименование платы',
                            'fport'             => 'Порт',
                            'fdamageReason'     => 'Причина повреждения',
                            'frepairNote'       => 'Заметка о ремонте',
                            'fstartDateTime'    => 'Дата регистрации',
                            'fendDateTime'      => 'Дата ремонта');
            $this->model->dataGrid($dataSet,
                                   $fields,
                                   'activeTasks',
                                   'Активные задания',
                                   9,
                                   false);
        }
    ?>
</div>