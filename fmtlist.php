<!DOCTYPE html>
<html lang="fr">
<?php
include_once './database.php';
$database = new Database();
$db = $database->getConnection();
if (isset($_POST['delete'])) {
    $q = 'DELETE FROM diagram where id=' . $_POST["delete"];
    $db->exec($q);
}
?>

<head>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
        }

        p {
            font-size: 19px;
            line-height: 26px;
            letter-spacing: 0.5px;
            color: #ff0707;
        }

        /* Popup Open button */
        .open-button {
            color: #FFF;
            background: #0066CC;
            padding: 10px;
            text-decoration: none;
            border: 1px solid #0157ad;
            border-radius: 3px;
        }

        .open-button:hover {
            background: #01478e;
        }

        .popup {
            position: fixed;
            top: 0px;
            left: 0px;
            background: rgba(0, 0, 0, 0.75);
            width: 100%;
            height: 100%;
            display: none;
        }

        /* Popup inner div */
        .popup-content {
            width: 700px;
            margin: 0 auto;
            box-sizing: border-box;
            padding: 40px;
            margin-top: 100px;
            box-shadow: 0px 2px 6px rgba(0, 0, 0, 1);
            border-radius: 3px;
            background: #fff;
            position: relative;
        }

        /* Popup close button */
        .close-button {
            width: 25px;
            height: 25px;
            position: absolute;
            top: -10px;
            right: -10px;
            border-radius: 20px;
            background: rgba(0, 0, 0, 0.8);
            font-size: 20px;
            text-align: center;
            color: #fff;
            text-decoration: none;
        }

        .close-button:hover {
            background: rgba(0, 0, 0, 1);
        }

        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            padding-top: 100px;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.4);
        }

        .modal-content {
            background-color: #fefefe;
            margin: auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
        }

        .close {
            color: #aaaaaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: #000;
            text-decoration: none;
            cursor: pointer;
        }

        @media screen and (max-width: 720px) {
            .popup-content {
                width: 90%;
            }
        }
    </style>
</head>

<body>
    <div class="container-fluid px-4">
        <h1 class="mt-4">My Familly Tree</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
            <li class="breadcrumb-item active">My Familly Tree</li>
        </ol>
        <div>
            <a class="btn btn-primary btn-lg active" popup-open="popup-1" href="javascript:void(0)">
                Design a new Familly Diagram
            </a>
            <!--<a href="index.php?page=newfamilyT" class="btn btn-primary btn-lg active" role="button" aria-pressed="true">Design a new Familly Diagram</a>-->
        </div>

        <div class="row px-3 mb-4"></div>
        <div class="card mb-4">
            <div id="userForm">
                <table id="datatablesSimple">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Date of Creation</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>Name</th>
                            <th>Date of Creation</th>
                            <th>Actions</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        <?php
                        include_once './database.php';
                        $database = new Database();
                        $db = $database->getConnection();
                        $rec = $db->query("SELECT * FROM diagram where user=" . $_SESSION["userId"])->fetchAll(PDO::FETCH_OBJ);
                        $totals = sizeof($rec);
                        for ($x = 0; $x < $totals; $x++) {
                            echo ('<tr class="gradeX">');
                            echo ('<td>' . $rec[$x]->name . '</td>');
                            echo ('<td> ' . $rec[$x]->CreatedAt . '</td>');
                            echo ("<td>");
                            echo ('<button onclick="openModal(\'' . $rec[$x]->name . '\', ' . $rec[$x]->id . ')" value="' . $rec[$x]->id . '" name="delete" class="btn btn-primary btn-xs" name="delete"><i class="fa fa-trash"></i></button>');
                            echo ('<a href="index.php?page=setfamilyT&id=' . $rec[$x]->id . '" class="btn btn-primary btn-xs" name="edit"><i class="fa fa-edit"></i></a>');
                            echo ("</td>");
                            echo ('</tr>');
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            <div id="confirmModal" class="modal">
                <div class="modal-content">
                    <span class="close" onclick="closeModal()">&times;</span>
                    <p>Are you sure you want to delete <span style="color :black ;" id="my-paragraph"></span> ? This action is irreversible.</p>
                    <button onclick="confirmAction()">Yes</button>
                    <button onclick="closeModal()">No</button>
                </div>
            </div>
            <div class="popup" popup-name="popup-1">
                <div class="popup-content">
                    <div class="card-header">
                        <h3 class="text-center font-weight-light my-4">Draw a new Family Tree</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-floating mb-3">
                            <input class="form-control" type="text" name="nom" id="nom" placeholder="Give a name to the family tree" required />
                            <label for="inputName">Family Name </label>
                        </div>
                        <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                            <button type="submit" class="btn btn-primary btn-xs" id="btnadd" name="add">Add</button>
                        </div>
                    </div>
                    <div class="card-footer text-center py-3">
                        <div class="small">Don't forget you are entitled to just 05 Diagrams.<br>You can not draw more than 05.</div>
                    </div>
                    <a class="close-button" popup-close="popup-1" href="javascript:void(0)">x</a>
                    <p id="msg"></p>
                </div>
            </div>
        </div>

        <script src="./js/jquery_min.js"></script>
        <script type="text/javascript" src="./js/ajax.js"></script>
        <script src="./js/bootstrap_bundle_min.js"></script>
        <script src="./js/datatable_last.js"></script>
        <script>
            // Get the paragraph element by its ID
            var myParagraph = document.getElementById('my-paragraph');
            var idds = '';
            function openModal(name, id) { //Are you sure you want to perform this action?
                myParagraph.textContent = name;
                idds = id
                document.getElementById("confirmModal").style.display = "block";

            }

            function closeModal() {
                document.getElementById("confirmModal").style.display = "none";
            }

            function confirmAction() {
                // Perform the action
                console.log("Action confirmed");
                $.ajax({
                    method: "POST",
                    url: "./crud/diagramdel.php",
                    data: {
                        idd: idds,
                    },
                    cache: false,
                    success: function(data) {
                        alert("Successfull");
                        //if( data == "Diagram created succesfully"){
                        var tableRows = '';
                        $.getJSON('http://localhost/tutors/crud/fmtlist.php', function(data) {
                            $.each(data, function(i, item) {
                                console.log(item.name)
                                tableRows += '<tr class="gradeX">' +
                                    '<td>' + item.name + '</td>' +
                                    '<td> ' + item.CreatedAt + '</td>' +
                                    '<td>' +
                                    '<button onclick="openModal(\''+ item.name +'\', '+item.id + ')" value="' + item.id + '" name="delete" class="btn btn-primary btn-xs" name="delete"><i class="fa fa-trash"></i></button>' +
                                    '<a href="index.php?page=setfamilyT&id=' + item.id + '" class="btn btn-primary btn-xs" name="edit"><i class="fa fa-edit"></i></a>' +
                                    '</td>' +
                                    '</tr>';
                            });
                            $('#datatablesSimple tbody').empty().html(tableRows);
                        });

                        //}
                        //$('#userForm').find('input').val('')
                    }
                });
                closeModal();
            }
            $(function() {
                // Open Popup
                $('[popup-open]').on('click', function() {
                    var popup_name = $(this).attr('popup-open');
                    $('[popup-name="' + popup_name + '"]').fadeIn(300);
                });

                // Close Popup
                $('[popup-close]').on('click', function() {
                    var popup_name = $(this).attr('popup-close');
                    $('[popup-name="' + popup_name + '"]').fadeOut(300);
                });

                // Close Popup When Click Outside
                $('.popup').on('click', function() {
                    var popup_name = $(this).find('[popup-close]').attr('popup-close');
                    $('[popup-name="' + popup_name + '"]').fadeOut(300);
                }).children().click(function() {
                    return false;
                });

            });
        </script>
</body>

</html>