<?php
// require_once __DIR__ . '/../config/config.php';
include_once __DIR__ . "/../config/database.php";
require_once __DIR__ . "/../controllers/getAttendancePercentage.controller.php";
include_once __DIR__ . "/../config/cors.php";



$REQUEST_METHOD = $_SERVER["REQUEST_METHOD"];


if($REQUEST_METHOD === "GET"){
    $idParams = isset($_GET["id"]) ? $_GET["id"] : null;
    $date = isset($_GET["date"]) ? $_GET["date"] : null;
    $year = isset($_GET["year"]) ? $_GET["year"] : null;
    $month = isset($_GET["month"]) ? $_GET["month"] : null;
    if(!$idParams) {

        // wala pang get attendance percentage for all
    } else {
        
        $response = getAttendancePercentage($idParams, $date, $year, $month, $pdo);
    }


    if (!$response["success"]){
        http_response_code(500);
        $response = [
            "success" => false,
            "error" => $response["error"]
        ];
    } else {
        http_response_code(200);
        $response = [
            "success" => true,
            "data" => $response["data"]
        ];
    }
    echo json_encode($response);
}

?>
