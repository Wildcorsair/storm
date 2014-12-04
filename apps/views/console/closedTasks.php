<div>
    <div>
      Отображение за период&nbsp;
      <button class='btn normal' name='select'>Выбрать</button>
      <br /><br />
    </div>
    <?php
        $dataSet = $this->model->closedTasksList($this->currentPage);
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
                                   'closedTasks',
                                   'Закрытые задания',
                                   8,
                                   true);
        }
    ?>
</div>