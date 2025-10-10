<?php
    // include_once __DIR__ . "/../config/database.php";

    function timeOut($employeeId, $rfid, $pdo){

        $query = "UPDATE time_and_attendance SET check_out_time = CURTIME() WHERE employee_id = :employee_id AND schedule_day = DATE(CURDATE());";

        try {
            $stmt = $pdo->prepare($query);
            $isTimeOut = $stmt->execute([
                ":employee_id" => $employeeId
            ]);


            if($isTimeOut){
            $response = [
                 "success" => false,
                 "message" => "Failed time out for the employee ID: {$employeeId}"
                ];
    
            }
             
            $response = [
                 "success" => true,
                //  "message" => "Successfully time out for the employee ID: {$employeeId}"
                 "message" => "Successfully time out"
                ];

        } catch (PDOException $e) {
            $response = [
                "success" => false,
                "message" => $e->getMessage()
            ];
        }

        return $response;

    }

?>