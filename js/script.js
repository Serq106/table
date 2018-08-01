
$( document ).ready(function(){
    $(document).on('click','.rTableRow',function(){
        var id = '#child_' + $(this).attr('id');
        var flag = true;
        if ($(id).hasClass('active') == true && flag == true) {
            $('.children-table').removeClass('active');
            flag = false;
        } else if ($(id).hasClass('active') == false && flag == true){
            $('.children-table').removeClass('active');
            $(id).addClass('active');
        }
    });

    function hideBtn(){
        $('#upload').hide();
        $('#res').html("Идет загрузка файла");
    }

    function handleResponse(mes) {
        $('#upload').show();
        if (mes.errors != null) {
            $('#res').html("Возникли ошибки во время загрузки файла: " + mes.errors);
        }
        else {
            $('#res').html("Файл " + mes.name + " загружен");
        }
    }
    
    $(document).on('click', '.child_edit', function () {
        var id = '#' + $(this).attr('id');
        s = $(id).parents('tr').find("td").text().split(' ');
        var id_item = '#' + $('.children-table.active').attr('id');
        $.ajax({
            dataType: 'html',
            url : "child_edit.php",
            method : "POST",
            data : {
                "article" : s[1],
                "color" : s[3],
                "price": s[4],
                "price-diskont": s[5],
                "sizes": $(id_item+".sizes").val(),
                "art": $(id_item+".art").val()
            },
            beforeSend: function () {
                inProgress = true;
            }
        }).done(function (data) {
            data = jQuery.parseJSON(data);
            $(id).parent().parent().before(data[0]);
            $(id).parent().parent().remove();
        });
    });

    $(document).on('click','.btne',function(){
        var id = '#' + $(this).attr('id') + ' table tbody tr:last';
        var id_item = '#' + $(this).attr('id');
        alert(id_item);
        $.ajax({
            dataType: 'html',
            url: "processor.php", // файл обработчик
            method: 'POST',
            data: {
                "article" : $(id_item+".article").val(),
                "color" : $(id_item + ".color").val(),
                "price": $(id_item+ ".price").val(),
                "price-diskont": $(".price-diskont").val(),
                "size": $(id_item+" #child_size option:selected").text(),
                "sizes": $(id_item+".sizes").val(),
                "name": $(id_item+".child_name").val(),
                "art": $(id_item+".art").val()
            },
            beforeSend: function () {
                inProgress = true;
            }
            /* что нужно сделать по факту выполнения запроса*/
        }).done(function (data) {
            data = jQuery.parseJSON(data);
            $(id).before('<tr><td> '+data[0]+'</td><td> '+data[1]+'</td><td> '+data[2]+'</td><td> '+data[3]+'</td><td> '+data[4]+'</td><td> '+data[5]+'</td></tr>')

        });
    });

    $(".btne_parent").click(function(){
        $.ajax({
            dataType: 'html',
            url: "parent.php", // файл обработчик
            method: 'POST',
            data: {
                "kategory" : $('#kat .multiselect.dropdown-toggle.btn.btn-default').attr('Title'),
                "brand" : $(".brand").val(),
                "name": $(".name").val(),
                "color": $("#color option:selected").text(),
                "size": $('#size .multiselect.dropdown-toggle.btn.btn-default').attr('Title'),
                "count": $(".count").val(),
                "discription": $(".discription").val(),
                "photo": $(".photo").val()
            },
            beforeSend: function () {
                inProgress = true;
            }
            /* что нужно сделать по факту выполнения запроса*/
        }).done(function (data) {
            data = jQuery.parseJSON(data);
            var id = 'item' + data[0];
            $('#add_perent').after('<div class="rTableRow"  id="'+id+'"><div class="rTableCell">'+data[0]+'</div><div class="rTableCell">'+data[1]+'</div><div class="rTableCell">'+data[2]+'</div><div class="rTableCell">'+data[3]+'</div><div class="rTableCell">'+data[4]+'</div><div class="rTableCell">'+data[5]+'</div><div class="rTableCell">'+data[6]+'</div><div class="rTableCell">'+data[7]+'</div><div class="rTableCell">'+data[8]+'</div><div class="rTableCell">'+data[9]+'</div></div> '+data[10])

        });
    });



    $(document).ready(function() {
        $('#example-getting-started-kategory').multiselect();
        $('#example-getting-started-size').multiselect();
    });
});
