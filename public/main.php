<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8'>
    <link rel='stylesheet' type='text/css' 
            href='http://UI-Controls/css/controls.css'>
    <link rel='stylesheet' type='text/css' 
            href='http://storm/public/css/styles.css'>
    <script type="text/javascript" 
            src="http://storm/public/js/jquery-1.11.0.min.js"></script>
    <!--<script type="text/javascript" 
                src="http://dbtest.org/UI-Controls/js/function.js"></script>-->
    <script type="text/javascript" 
            src="http://storm/public/js/functions.js"></script>            
    <title>Storm</title>
</head>
<body>
    <div id='page-wrapper'>
        <div id='header'>
            <div id='logo'>Storm</div>
        </div>
        <div id='shadow'></div>
        <div id='menu'>
            <ul>
                <li>
                    <a href='#'>Заявки</a>
                    <ul id='sub-menu1'>
                        <li id='active'>Активные</li>
                        <li id='closed'>Закрытые</li>
                    </ul>
                </li>
                <li><a href='diff'>Отчеты</a></li>
                <li><a href='#'>Настройки</a></li>
            </ul>
        </div>
        <div id='workspace'>
            <div id='sidebar'>
                <ul>
                    <li>Статистика</li>
                    <li>Платы</li>
                </ul>
            </div>
            <div id='content'>
                <?php
                    $this->render($this->tamplate, true);
                ?>
            </div>
        </div>
        <div id='clear'></div>
    </div>
    <div id='footer'>
        <div id='copyright'>Sam Sebe Company &copy 2014</div>
    </div>
</body>
</html>