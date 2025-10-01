<?php

function isDutyDone($employeeId, $pdo){
        $query = "SELECT employee_id, COUNT(check_out_time) AS total FROM time_and_attendance WHERE employee_id = :employee_id AND DATE(check_in_time) = CURDATE()
";
        try {
            $stmt = $pdo->prepare($query);
            $stmt->execute([":employee_id" => $employeeId]);
            $row = $stmt->fetch();

            if($row && $row["total"] > 0) {
                $response = [
                    "isDone" => true,
                    "message" => "The employee ID {$employeeId} has already checked out for today's duty",
                    "employeeId" => $row["employee_id"]
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