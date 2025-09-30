<?php

function isRFIDExists($rfid, $pdo){
        $query = "SELECT COUNT(rfid) AS total, employee_id FROM employees WHERE rfid = :rfid";
        try {
            $stmt = $pdo->prepare($query);
            $stmt->execute([":rfid" => $rfid]);
            $row = $stmt->fetch();

            if($row && $row["total"] > 0) {
                $response = [
                    "isExist" => true,
                    "message" => "The employee ID exists",
                    "employeeId" => $row["employee_id"]
                    
                ];
            }else {
                $response = [
                    "isExist" => false,
                    "message" => "The employee ID doesnt exist"
                ];
            }

        } catch (PDOException $e) {
            $response = [
                    "isExist" => false,
                    "message" => "Error: {$e->getMessage()}"
                ];
        }
        return $response;
    }

?>