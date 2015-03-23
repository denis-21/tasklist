//добавление статуса выполненого и невыполненого
function ajax_add_status_task(id_task, type) {
    $.ajax({
        type: "POST",
        data: {id_task: id_task, type: type},
        dataType: "json",
        url: "/task/ChangeStatusTask"
    });
}

//приоритет заданий
function exchange(id_first, id_second, type) {
    $.ajax({
        type: "POST",
        data: {id_first: id_first, id_second: id_second},
        dataType: "json",
        url: "/task/priority",
        success: function () {
            switch (type) {
                case 1:
                    $('.data_tr_' + id_first).before($('.data_tr_' + id_second));
                    break;
                case 2:
                    $('.data_tr_' + id_first).after($('.data_tr_' + id_second));
                    break;
            }
            $('.data_tr_' + id_first).attr('data-id-task', id_second);
            $('.data_tr_' + id_second).attr('data-id-task', id_first);
            $('[data-id-task = ' + id_second + ']').removeClass('data_tr_' + id_first).addClass('data_tr_' + id_second);
            $('[data-id-task = ' + id_first + ']').removeClass('data_tr_' + id_second).addClass('data_tr_' + id_first);
        }
    });
}

//кнопка вверх задание
$(document).on('click', '.prew', function () {
    var tr_prev = $(this).parent().parent().parent().prev().attr('data-id-task');
    var tr_click = $(this).parent().parent().parent().attr('data-id-task');
    exchange(tr_prev, tr_click, 1);
});

//кнопка вниз задание
$(document).on('click', '.next', function () {
    var tr_next = $(this).parent().parent().parent().next().attr('data-id-task');
    var tr_click = $(this).parent().parent().parent().attr('data-id-task');
    exchange(tr_next, tr_click, 2);
});

//удаление задания
$(document).on('click', '.delete_task', function () {
    var id_task = $('.hidden_input_delete_id').val();
    $.ajax({
        type: "POST",
        data: {id_task: id_task},
        dataType: "json",
        url: "/task/DeleteTask",
        success: function () {
            $('.data_tr_' + id_task).remove();
            $('.modal').modal('hide');
        }
    });
});

$(document).on('click', '.delete_project', function () {
    var id_project = $(this).parent().parent().parent().parent().attr('data-project-id');
    if (confirm('Вы точно хотите удалить проект?')) {
        $.ajax({
            type: "POST",
            data: {id_project: id_project},
            dataType: "json",
            url: "/task/DeleteProject",
            success: function () {
                $('.table_js' + id_project).parent().remove();
                $('.modal').modal('hide');
            }
        });
    }
    return false;
});

$(document).on('click', '.edit_project', function () {
    var text = $(this).parent().parent().parent().parent().attr('data-project-desc');
    var id_project = $(this).parent().parent().parent().parent().attr('data-project-id');
    $('.hidden_input_id').val(id_project);
    $('.hidden_input').val(text);
    $('.input_for_desciption').val(text);
    $('.project').val('1');
});

//запись в невидимый интуп для удаления
$(document).on('click', '.delete', function () {
    $('.hidden_input_delete_id').val($(this).parent().parent().parent().attr('data-id-task'));
});


//запись в невидимые инпуты для обновления
$(document).on('click', '.update', function () {
   var  text = $(this).data('task-descr');
    $('.hidden_input_id').val($(this).parent().parent().parent().attr('data-id-task'));
    $('.hidden_input').val(text);
    $('.input_for_desciption').val(text);
});
$(document).on('click', '.close', function () {
    $('.input_for_desciption').val('');
});
//обновление задания
$(document).on('click', '.update_task', function () {
    var id_task = $('.hidden_input_id').val();
    var descr = $('.input_for_desciption').val();
    var type = $('.project').val();
    console.log(id_task);
    console.log(descr);
    console.log(type);
    $.ajax({
        type: "POST",
        data: {id_task: id_task, descr: descr, type: type},
        dataType: "json",
        url: "/task/UpdateTask",
        success: function () {
            if (type == 1) {
                $('[data-project-id = ' + id_task + '] tr .name_project').html(descr);
                $('[data-project-id = ' + id_task + ']').attr('data-project-descr',descr);
            } else {
                $('[data-id-task = ' + id_task + '] td .name_task').html(descr);
            }
            $('.modal').modal('hide');
            $('.input_for_desciption').val('');
        }
    });
});

//добавление статуса заданию
$(document).on('click', '.chekbox_task', function () {
    if ($(this).is(":checked") == true) {
        $('[data-id-task = ' + $(this).parent().parent().attr('data-id-task') + '] td .name_task').css('text-decoration', 'line-through');
        ajax_add_status_task($(this).parent().parent().attr('data-id-task'), 1);
    } else {
        $('[data-id-task = ' + $(this).parent().parent().attr('data-id-task') + '] td .name_task').css('text-decoration', 'none');
        ajax_add_status_task($(this).parent().parent().attr('data-id-task'), 0);
    }
});


//скрипты по загрузке страницы
$(document).ready(function () {

    //показ модального окна с обновлением
    $('.modal').on('shown.bs.modal', function (e) {
        var descr = $('.hidden_input').val();
        $('.input_for_description').val(descr);
    });

    //добавление самого задания
    $('.input-group button').click(function () {
        var number = $(this).attr('data-number');
        var input = $('.input_name_task' + number);
        var input_val = input.val();

        $.ajax({
            type: "POST",
            data: {projectId: number, descr: input_val},
            dataType: "json",
            url: "/task/addtask",
            context: input,
            success: function (result) {
                console.log(result['id']);
                console.log(result['descr']);
                $('.table_js' + number).append('<tr class="data_tr_' + result['id'] + ' style_for_task" data-id-task="' + result['id'] + '">' +
                '<td><input type="checkbox" class="chekbox_task" data-task="' + result['id'] + '"/></td>' +
                '<td colspan="2" class="border_td"><span class="name_task">' + result['descr'] + '</span><div class="pull-right icons_action">' +
                '<a href="#" onclick="return false;" class="prew color_td"><i class="glyphicon glyphicon-chevron-up"></i></a>' +
                '<a href="#" onclick="return false;" class="next color_td"><i class="glyphicon glyphicon-chevron-down"></i></a>' +
                '<a data-toggle="modal" href="#" class="update color_td" data-target="#myModal" data-task-descr="' + result['descr'] + '"><i class="glyphicon glyphicon-pencil"></i> </a>' +
                '<a href="#" data-toggle="modal" class="delete color_td" data-target=".bs-example-modal-sm"><i class="glyphicon glyphicon-trash"></i> </a></div>' +
                '</td></tr>');
                input.val('');
            }
        });
    });

    //сохранение нового проекта
    $('#save_todo').click(function () {
        var input = $('#modaladd').find('input[name="name_todo_list"]');
        var name=input.val();
            var hostname = window.location.hostname;
            var path ="//"+hostname+ "/" +"task/addProject";
            $.ajax({
                type: "POST", // HTTP method POST or GET
                url: path, //Where to make Ajax calls
                dataType: "json", // Data type, HTML, json etc.
                data:{name: name},//Form variables
                success: function (response) {
                    if(response)
                    {
                        $('#modaladd').modal('hide');
                        location.reload();
                     
                    }

                }
            });
        });
});
