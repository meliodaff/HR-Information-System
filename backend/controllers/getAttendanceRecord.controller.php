<?php

     function getAttendanceRecords($date, $pdo) {
    
        $query = "SELECT
e.employee_id,
e.first_name,
e.last_name,
e.department,
e.position,
taa.schedule_day,
taa.check_in_time,
taa.check_out_time,
taa.attendance_status,
taa.notes
FROM employees e
JOIN time_and_attendance taa
ON e.employee_id = taa.employee_id
WHERE DATE(check_in_time) = :date
";
        try {
            $stmt = $pdo->prepare($query);
            $stmt->execute([
                ":date" => $date
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

    function getAttendanceRecord($id, $date, $pdo) {
        $query = "SELECT
e.employee_id,
e.first_name,
e.last_name,
e.department,
e.position,
taa.schedule_day,
taa.check_in_time,
taa.check_out_time,
taa.attendance_status,
taa.notes
FROM employees e
JOIN time_and_attendance taa
ON e.employee_id = taa.employee_id
WHERE e.employee_id = :employee_id AND DATE(taa.check_in_time) = :date
";

        try {
            $stmt = $pdo->prepare($query);
            $stmt->execute([
                ":employee_id" => $id,
                ":date" => $date
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