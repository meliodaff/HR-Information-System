<?php
// require_once __DIR__ . '/../config/config.php';
include_once __DIR__ . "/../config/database.php";
require_once __DIR__ . "/../controllers/getPaidHours.controller.php";
include_once __DIR__ . "/../config/cors.php";



$REQUEST_METHOD = $_SERVER["REQUEST_METHOD"];


if($REQUEST_METHOD === "GET"){

    $idParams = isset($_GET["id"]) ? $_GET["id"] : null;
    $period = isset($_GET["period"]) ? (int)$_GET["period"] : null;
    $year = isset($_GET["year"]) ? $_GET["year"] : null;
    $month = isset($_GET["month"]) ? $_GET["month"] : null;
    
    // if(!$idParams) {
    //     // WALA PA HERE YUNG OTHER QUERY KEY LIKE THE PERIOD OR THE YEAR OR THE MONTH
    // } else {
        // $response = getPaidHoursOfTheFirstCutOff($idParams, $pdo);
        // }

        // WALA RIN PAPALA YUNG BY MONTH

        if ($idParams && $period === 1 && $year && $month){
            $response = getAllPaidHoursOfTheFirstCutOffByYearMonthId($idParams, $year, $month, $pdo);   
        }
        else if ($idParams && $period === 2 && $year && $month){
            $response = getAllPaidHoursOfTheSecondCutOffByYearMonthId($idParams, $year, $month, $pdo);   
            
        }
        else if ($idParams && $period === 1 && $month){
            $response = getAllPaidHoursOfTheFirstCutOffByMonthId($idParams, $month, $pdo);
        }
        else if ($idParams && $period === 2 && $month){
            $response = getAllPaidHoursOfTheSecondCutOffByMonthId($idParams, $month, $pdo);
            
        }
        else if($idParams && $period === 1 && $year){

            $response = getAllPaidHoursOfTheFirstCutOffByYearAndId($idParams, $year, $pdo);
        }
        else if ($idParams && $period === 2 && $year){
            
            $response = getAllPaidHoursOfTheSecondCutOffByYearAndId($idParams, $year, $pdo);
        }
        else if ($idParams && $period === 1) {

            $response = getPaidHoursOfTheFirstCutOff($idParams, $pdo);
        }
        else if ($idParams && $period === 2) {

            $response = getPaidHoursOfTheSecondCutOff($idParams, $pdo);
        }
        else if ($year && $period === 1) {
            // THIS IS GETTING THE RECORD OF THE CURRENT MONTH
            $response = getAllPaidHoursOfTheFirstCutOffByYear($year, $pdo);
        }
        else if ($year && $period === 2) {
            // THIS IS GETTING THE RECORD OF THE CURRENT MONTH
            $response = getAllPaidHoursOfTheSecondCutOffByYear($year, $pdo);
        }
        else if ($month && $period === 1) {
            $response = getAllPaidHoursOfTheFirstCutOffByMonth($month, $pdo);
        }
        else if ($month && $period === 2) {
            $response = getAllPaidHoursOfTheSecondCutOffByMonth($month, $pdo);
        }
        else if ($period === 1) {
            // THIS IS GETTING THE RECORD OF THE CURRENT MONTH AND YEAR
            $response = getAllPaidHoursOfTheFirstCutOff($pdo);
        }
        else if ($period === 2) {
            // THIS IS GETTING THE RECORD OF THE CURRENT MONTH AND YEAR
            $response = getAllPaidHoursOfTheSecondCutOff($pdo);
        }

        else if ($month) {
            $response = getAllYearPaidHoursOfTheFirstCutOffByMonth($month, $pdo);
        } else {
            // doesnt work yet
            $response = [
                "success" => true,
                "data" => "The parameters are wrong"
            ];
        }
        
        


    if (!$response["success"]){
        http_response_code(500);
        $response = [
            "error" => $response["error"]
        ];
    } else {
        http_response_code(200);
        $response = [
            "data" => $response["data"]
        ];
    }
    echo json_encode($response);
}

?>
