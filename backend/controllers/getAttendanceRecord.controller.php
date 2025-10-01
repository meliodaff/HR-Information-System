<?php

     function getAttendanceRecords($pdo) {
    
        $query = "SELECT
e.employee_id,
e.first_name,
e.last_name,
taa.schedule_day,
taa.check_in_time,
taa.check_out_time,
taa.attendance_status,
taa.notes
FROM employees e
JOIN time_and_attendance taa
ON e.employee_id = taa.employee_id
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

    function getAttendanceRecord($id, $pdo) {
        $query = "SELECT
e.employee_id,
e.first_name,
e.last_name,
taa.schedule_day,
taa.check_in_time,
taa.check_out_time,
taa.attendance_status,
taa.notes
FROM employees e
JOIN time_and_attendance taa
ON e.employee_id = taa.employee_id
WHERE e.employee_id = :employee_id AND MONTH(taa.schedule_day) = MONTH(CURDATE())
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