<?php

class Console extends BController {
    public $mainTamplate = "main.php";
    public $currentPage;
    
    public function index() {
        $this->render('console');
    }

    public function activeTasks($page) {
        if (is_numeric($page)) {
            $this->currentPage = $page;
        } else {
            $this->currentPage = 3;
        }
        $this->render('active', true);
    }

    public function active($page) {
        if (is_numeric($page)) {
            $this->currentPage = $page;
        } else {
            $this->currentPage = 1;
        }
        $this->render('active');
    }
    
    public function taskAddFrm() {
        $this->render('taskAddFrm', true);
    }
    public function taskEditFrm() {
        $this->render('taskEditFrm', true);
    }
    public function taskAdd() {
        $this->model->taskAdd();
    }
    public function taskUpdate() {
        $this->model->taskUpdate();
    }

    public function diff() {
        $this->model->diff();
    }
}

?>