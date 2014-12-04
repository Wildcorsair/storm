$(document).ready(function() {
    $('#content').on('click', 'button[name="taskAdd"]', function() {
        if (!$('div').is('.window-frame')) {
            $.ajax({
                    //url: 'http://acs-storm/console/taskAddFrm',
                    url: 'http://storm/console/taskAddFrm',
                success: function (data) {
                            $('#content').append(data);
                         }
            });
        }
    });

    $('#content').on('click', 'button[name="win-close"]', function() {
        $('#taskAddFrm').remove();
    });
    
    $('#content').on('click', '#taskAddCancel', function() {
       $('#taskAddFrm').remove();
       return;
    });

    $('#content').on('click', '#taskAddSave', function() {
        var phoneNumber = $('input[name="phoneNumber"]').val();
        var boardId = $('input[name="boardId"]').val();
        var portNumber = $('input[name="portNumber"]').val();
        var damageReason = $('textarea[name="damageReason"]').val();
        var startDateTime = $('input[name="startDateTime"]').val();

        $.ajax({
            //url: 'http://acs-storm/console/taskAdd',
            url: 'http://storm/console/taskAdd',
           type: 'POST',
           data: {
                    phoneNumber:   phoneNumber,
                    boardId:       boardId,
                    portNumber:    portNumber,
                    damageReason:  damageReason,
                    startDateTime: startDateTime
                 },
        success: function() {
                    $('#taskAddFrm').remove();
                 },
          error: function() {
                    console.log('Script error!');
                 }
        });
        return;
    });

    $('#content').on('click', '#taskUpdateSave', function() {
        var taskId = $('input[name="taskId"]').val();
        var phoneNumber = $('input[name="phoneNumber"]').val();
        var boardId = $('input[name="boardId"]').val();
        var portNumber = $('input[name="portNumber"]').val();
        var damageReason = $('textarea[name="damageReason"]').val();
        var repairNote = $('textarea[name="repairNote"]').val();
        var startDateTime = $('input[name="startDateTime"]').val();
        var endDateTime = $('input[name="endDateTime"]').val();

        $.ajax({
            //url: 'http://acs-storm/console/taskUpdate',
            url: 'http://storm/console/taskUpdate',
           type: 'POST',
           data: {
                    taskId:        taskId,
                    phoneNumber:   phoneNumber,
                    boardId:       boardId,
                    portNumber:    portNumber,
                    damageReason:  damageReason,
                    repairNote:    repairNote,
                    startDateTime: startDateTime,
                    endDateTime:   endDateTime
                 },
        success: function() {
                    $('#taskAddFrm').remove();
                    getActiveTasks('activeTasks', null);
                 },
          error: function() {
                    console.log('Script error!');
                 }
        });
        return;
    });
    
    $('#requests-submenu').on('click', '#active', function() {
        getActiveTasks('activeTasks', 1);
    });
    
    $('#requests-submenu').on('click', '#closed', function() {
        getClosedTasks('closedTasks', 1);
    });

    $('#content').on('click', '.page-num', function(e) {
        var myEvent = e || window.e;
        var myTarget = myEvent.target || myEvent.srcElement;
        var pageNum = $(myTarget).html();
        var tasksType = $('table').data('value');
        getActiveTasks(tasksType, pageNum);
    });
    $('#content').on('click', '.btn-tb.ico-edit', function(e) {
        var myEvent = e || window.e;
        var btn = myEvent.target || myEvent.srcElement;
        var id = $(btn).data('value');
        //console.log('Working! '+id);
        if (!$('div').is('.window-frame')) {
            $.ajax({
                    //url: 'http://acs-storm/console/taskEditFrm',
                    url: 'http://storm/console/taskEditFrm',
                   type: 'GET',
                   data: { id: id},
                success: function (data) {
                            $('#content').append(data);
                         }
            });
        }        
    });
    $('#menu').on('mouseover', 'li[id="requests"]', function(e) {
        var myEvent = e || window.e;
            myEvent.stopPropagation();
        //console.log('Навел!');
        $('#requests-submenu').css({display:'block'});
        //$('#requests-submenu').css({zIndex:'100'});
        $('#requests-submenu').show();
    });
    $('#menu').on('mouseout', 'li[id="requests"]', function(e) {
        var myEvent = e || window.e;
            myEvent.stopPropagation();
        //console.log('Убрал нах...!');
        $('#requests-submenu').css({display:'none'});
    });
}); //End of ready

function getCurrPage() {
    var currPage = $('span[class="btn f-left active"]').html();
    if (currPage == null) {
        currPage = 1;
    }
    return currPage;
}

function getActiveTasks(type, pageNum) {
    if (pageNum == null) {
        var currPage = getCurrPage();
    } else {
        var currPage = pageNum;
    }
    $.ajax({
            //url: 'http://acs-storm/console/activeTasks?curPage='+curPage,
            url: 'http://storm/console/'+type+'?currPage='+currPage,
           type: 'GET',
        success: function(data) {
                    $('#requests-submenu').css('display', 'none');
                    var content = $('#content');
                        content.html('');
                        content.append(data);
                 },
          error: function() {
                    console.log('Script error!');
                 }        
    });
}

function getClosedTasks(type, pageNum) {
    if (pageNum == null) {
        var currPage = getCurrPage();
    } else {
        var currPage = pageNum;
    }
    $.ajax({
            //url: 'http://acs-storm/console/activeTasks?curPage='+curPage,
            url: 'http://storm/console/'+type+'?currPage='+currPage,
           type: 'GET',
        success: function(data) {
                    $('#requests-submenu').css('display', 'none');
                    var content = $('#content');
                        content.html('');
                        content.append(data);
                 },
          error: function() {
                    console.log('Script error!');
                 }        
    });
}