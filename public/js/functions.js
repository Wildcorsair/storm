$(document).ready(function() {
    $('#content').on('click', 'button[name="taskAdd"]', function() {
        if (!$('div').is('.window-frame')) {
            $.ajax({
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
                    getActiveTasks();
                 },
          error: function() {
                    console.log('Script error!');
                 }
        });
        return;
    });
    
    $('#sub-menu1').on('click', '#active', function() {
        getActiveTasks();
    });
    
    $('#content').on('click', '.btn-tb.ico-edit', function(e) {
        var myEvent = e || window.e;
        var btn = myEvent.target || myEvent.srcElement;
        var id = $(btn).data('value');
        //console.log('Working! '+id);
        if (!$('div').is('.window-frame')) {
            $.ajax({
                    url: 'http://storm/console/taskEditFrm',
                   type: 'GET',
                   data: { id: id},
                success: function (data) {
                            $('#content').append(data);
                         }
            });
        }        
    });
    /*$('#menu').on('mouseover', 'li[id="requests"]', function() {
        console.log('Навел!');
        /*$('#sub-menu1').css({display:'block'});
        $('#sub-menu1').css({zIndex:'100'});
        $('#sub-menu1').show();
    });
    $('#menu').on('mouseout', 'li[id="requests"]', function() {
        console.log('Убрал нах...!');
        $('#sub-menu1').css({display:'none'});
    });*/
}); //End of ready

function getActiveTasks() {
    var curPage = $('span[class="btn f-left active"]').html();
    //alert($(curPage).html());
    $.ajax({
            url: 'http://storm/console/activeTasks?curPage='+curPage,
           type: 'GET',
        success: function(data) {
                    $('#sub-menu1').remove();
                    var content = $('#content');
                        content.html('');
                        content.append(data);
                 },
          error: function() {
                    console.log('Script error!');
                 }        
    });
}

function showSubMenu() {
    $('li').append("<ul id='sub-menu1'>\
                        <li id='active'>Активные</li>\
                        <li id='closed'>Закрытые</li>\
                    </ul>");
    $('#sub-menu1').css({display:'block'});
}
function hideSubMenu() {
    console.log('Убрал нах...!');
    $('#sub-menu1').css({display:'none'});
}
