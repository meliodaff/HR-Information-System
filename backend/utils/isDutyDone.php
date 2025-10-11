<?php

function isDutyDone($employeeId, $pdo){
        $query = "SELECT employee_id, check_in_time, check_out_time, COUNT(check_out_time) AS total FROM time_and_attendance WHERE employee_id = :employee_id AND DATE(check_in_time) = CURDATE()
";
        try {
            $stmt = $pdo->prepare($query);
            $stmt->execute([":employee_id" => $employeeId]);
            $row = $stmt->fetch();

            if($row && $row["total"] > 0) {
                $response = [
                    "isDone" => true,
                    "message" => "You have already checked out for today's duty",
                    "employeeId" => $row["employee_id"],
                    "timeIn" => $row["check_in_time"], 
                    "timeOut" => $row["check_out_time"] 
                ];
            }else {
                $response = [
                    "isDone" => false,
                    "message" => "The employee ID {$employeeId} has not yet checked out for today's duty"
                ];
            }

        } catch (PDOException $e) {
            $response = [
                    "isDone" => false,
                    "message" => "Error: {$e->getMessage()}"
                ];
        }
        return $response;
    }

?>