<?php

header('Content-Type: application/json');

require_once '../../Model/Service.php';


if($_SERVER['REQUEST_METHOD'] == 'POST'){

    if(
        isset($_POST['service_id']) &&
        isset($_POST['status'])
    ){

        $serviceId = $_POST['service_id'];

        $status = $_POST['status'];



        $success = Service::updateServiceStatus(
            $serviceId,
            $status
        );



        if($success){

            echo json_encode([
                'status' => 'success'
            ]);

        }else{

            echo json_encode([
                'status' => 'failed'
            ]);

        }

    }

}

?>