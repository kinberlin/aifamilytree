$(document).ready(function () {
    /* $('#btnPrint').on('click', function() {
         print();
     });*/
    $('#btnadd').on('click', function () {
        var nom = $('#nom').val();
        $.ajax({
            method: "POST",
            url: "./crud/diagramadd.php",
            data: {
                name: nom,
            },
            cache: false,
            success: function (data) {
                $('#msg').html(data);
                //if( data == "Diagram created succesfully"){
                var tableRows = '';
                $.getJSON('http://localhost/tutors/crud/fmtlist.php', function (data) {
                    $.each(data, function (i, item) {
                        console.log(item.name)
                        tableRows += '<tr class="gradeX">'
                            + '<td>' + item.name + '</td>'
                            + '<td> ' + item.CreatedAt + '</td>'
                            + '<td>'
                            +'<button onclick="openModal(\'' + item.name + '\', ' + item.id + ')" value="' + item.id + '" name="delete" class="btn btn-primary btn-xs" name="delete"><i class="fa fa-trash"></i></button>'
                            +'<a href="index.php?page=setfamilyT&id=' + item.id + '" class="btn btn-primary btn-xs" name="edit"><i class="fa fa-edit"></i></a>'
                            +'</td>'
                            + '</tr>';
                    });
                    $('#datatablesSimple tbody').empty().html(tableRows);
                });
                console.log(tableRows);
                setTimeout(() => {  
                var popup_name = "popup-1";
                $('[popup-name="' + popup_name + '"]').fadeOut(300);
            }, 100);

                //}
                //$('#userForm').find('input').val('')
            }
        });
    });

});