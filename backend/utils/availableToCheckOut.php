<?php

function isAvailableToCheckOut($employeeId, $pdo){
        $query = "SELECT COUNT(*) as total, attendance_id, employee_id, check_in_time,
       TIMESTAMPDIFF(HOUR, check_in_time, NOW()) AS hours_worked
FROM time_and_attendance
WHERE employee_id = :employee_id
  AND check_out_time IS NULL
  AND TIMESTAMPDIFF(HOUR, check_in_time, NOW()) >= 4;
";
        try {
            $stmt = $pdo->prepare($query);
            $stmt->execute([":employee_id" => $employeeId]);
            $row = $stmt->fetch();

            if($row && $row["total"] > 0) {
                $response = [
                    "isAvailable" => true,
                    "message" => "The employee ID is available to check out as the employee has already rendered 4 hours",
                    "employeeId" => $row["employee_id"]
                ];
            }else {
                $response = [
                    "isAvailable" => false,
                    "message" => "The employee ID {$employeeId} is not available to check out as the employee has not yet rendered 4 hours"
                ];
            }

        } catch (PDOException $e) {
            $response = [
                    "isAvailable" => false,
                    "message" => "Error: {$e->getMessage()}"
                ];
        }
        return $response;
    }

?>