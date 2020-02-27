<?php
    date_default_timezone_set('Asia/Manila'); 
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: PUT, POST, PATCH, OPTIONS, GET');
    header('Content-Type: application/json');

    include_once './config/database.php';
    include_once './model/post.php';

    $database = new Database();
    $db = $database->connect();
    $post = new Post($db);
    $data = array();

    $req = explode('/',rtrim($_REQUEST['request'],'/'));
    
    $d = json_decode( base64_decode( file_get_contents('php://input')));

    switch ($_SERVER['REQUEST_METHOD']) {
        case 'POST':
            switch ($req[0]) {
                case 'getStudents':
                    echo json_encode($post->queryWithRes("SELECT * from students ORDER BY stud_name,stud_address,stud_number ASC"));
                break;

                case 'addStudent':
                    echo json_encode($post->queryWithoutRes("INSERT INTO students(stud_name,stud_address,stud_number) VALUES('$d->studName','$d->studAddress','$d->studNo')"));
                break;

                case 'updateStudent':
                    echo json_encode($post->queryWithoutRes("UPDATE students SET stud_name='$d->studName1' ,stud_address='$d->studAddress1',stud_number='$d->studContactNo1' WHERE stud_recno = '$d->studRecno1'"));
                break;

                case 'deleteStudent':
                    echo json_encode($post->queryWithoutRes("DELETE from students WHERE stud_recno= '$d->studRecno'"));
                break;
                
                default:
                    http_response_code(400);
                    echo json_encode(array('status'=>'failed', 'message'=>'Bad request.'));

            }

        break;

        default:
            http_response_code(400);
            echo json_encode(array('status'=>'failed', 'message'=>'Bad request.'));
    
    }

    $db->close();
?>