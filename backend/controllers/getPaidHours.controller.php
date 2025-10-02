<?php

    function getAllPaidHoursOfTheFirstCutOff($pdo) {
    
        $query = "SELECT 
    attendance_id,
    employee_id,
    check_in_time,
    check_out_time,
    TIMESTAMPDIFF(
        HOUR,
        CASE 
            WHEN TIME(check_in_time) <= '09:15:00' 
                THEN DATE_FORMAT(check_in_time, '%Y-%m-%d 09:00:00')
            ELSE DATE_FORMAT(
                check_in_time + INTERVAL 1 HOUR, 
                '%Y-%m-%d %H:00:00'
            )
        END,
        LEAST(check_out_time, DATE_FORMAT(check_out_time, '%Y-%m-%d 17:00:00'))
    ) AS paid_hours
FROM time_and_attendance
WHERE check_out_time IS NOT NULL
  AND DAY(check_in_time) <= 14
  AND MONTH(check_in_time) = MONTH(CURDATE())
  AND YEAR(check_in_time) = YEAR(CURDATE());
";

        try {
            $stmt = $pdo->prepare($query);
            $stmt->execute();

            $datas = $stmt->fetchAll();
            $response = [
                "success" => true,
                "data" => $datas 
            ];
        } catch (PDOException $e) {
            $response = [
                "success" => false,
                "error" => $e->getMessage()
            ];
            }
            return $response;
    }

    function getPaidHoursOfTheFirstCutOff($id, $pdo) {
        $query = "SELECT 
    attendance_id,
    employee_id,
    check_in_time,
    check_out_time,
    TIMESTAMPDIFF(
        HOUR,
        CASE 
            WHEN TIME(check_in_time) <= '09:15:00' 
                THEN DATE_FORMAT(check_in_time, '%Y-%m-%d 09:00:00')
            ELSE DATE_FORMAT(
                check_in_time + INTERVAL 1 HOUR, 
                '%Y-%m-%d %H:00:00'
            )
        END,
        LEAST(check_out_time, DATE_FORMAT(check_out_time, '%Y-%m-%d 17:00:00'))
    ) AS paid_hours
FROM time_and_attendance
WHERE employee_id = :employee_id
  AND check_out_time IS NOT NULL
  AND DAY(check_in_time) <= 14
  AND MONTH(check_in_time) = MONTH(CURDATE())
  AND YEAR(check_in_time) = YEAR(CURDATE());
";

        try {
            $stmt = $pdo->prepare($query);
            $stmt->execute([
                ":employee_id" => $id
            ]);

            $datas = $stmt->fetchAll();
            $response = [
                "success" => true,
                "data" => $datas 
            ];
        } catch (PDOException $e) {
            $response = [
                "success" => false,
                "error" => $e->getMessage()
            ];
            }
            return $response;
    }

?>