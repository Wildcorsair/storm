<?php

class BDatabase extends DataAccess {
    public function __construct() {
        parent::__construct("localhost", "root", "", "stormBase");
    }

    /*
    * Функция преобразования даты из строки формата:
    * 'dd-mm-yyyy hh:mm:ss' в строку формата:
    * 'yyyy-mm-dd hh:mm:ss'
    */
    public function dateTimeConvert($dateTimeStr) {
        if (!empty($dateTimeStr)) {
            $dateTimeParts = explode(' ', $dateTimeStr);
            $dateParts = explode('-', $dateTimeParts[0]);
            $resultDateStr = $dateParts[2] . '-'
                            . $dateParts[1] . '-'
                            . $dateParts[0];
            $resultDateTimeStr = $resultDateStr . ' ' . $dateTimeParts[1];
            return $resultDateTimeStr;
        } else {
            return '0000-00-00 00:00:00';
        }
    }
}

?>