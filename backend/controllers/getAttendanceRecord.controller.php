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


    function getAttendanceRecordForTheMonth($id, $month, $pdo) {
        $query = "SELECT
e.employee_id,
e.first_name,
e.last_name,
e.department,
e.position,
taa.schedule_day,
TIME(taa.check_in_time) AS check_in_time,
TIME(taa.check_out_time) AS check_out_time,
taa.attendance_status,
taa.notes
FROM employees e
JOIN time_and_attendance taa
ON e.employee_id = taa.employee_id
WHERE e.employee_id = :employee_id AND MONTH(taa.check_in_time) = :month AND YEAR(taa.check_in_time) = YEAR(CURDATE())
";

        try {
            $stmt = $pdo->prepare($query);
            $stmt->execute([
                ":employee_id" => $id,
                ":month" => $month
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


    function getAttendanceSummary($id, $pdo) {
        $queryForPresent = "SELECT
e.employee_id,
COUNT(taa.attendance_status) AS present_count
FROM employees e
JOIN time_and_attendance taa
ON e.employee_id = taa.employee_id
WHERE e.employee_id = :employee_id AND MONTH(taa.check_in_time) = MONTH(CURDATE()) AND YEAR(taa.check_in_time) = YEAR(CURDATE()) 
AND taa.attendance_status = 'Present'
";
        $queryForLate = "SELECT
e.employee_id,
COUNT(taa.attendance_status) AS late_count
FROM employees e
JOIN time_and_attendance taa
ON e.employee_id = taa.employee_id
WHERE e.employee_id = :employee_id AND MONTH(taa.check_in_time) = MONTH(CURDATE()) AND YEAR(taa.check_in_time) = YEAR(CURDATE()) 
AND taa.attendance_status = 'Late'
";
        $queryForAbsent = "SELECT
e.employee_id,
COUNT(taa.attendance_status) AS absent_count
FROM employees e
JOIN time_and_attendance taa
ON e.employee_id = taa.employee_id
WHERE e.employee_id = :employee_id AND MONTH(taa.check_in_time) = MONTH(CURDATE()) AND YEAR(taa.check_in_time) = YEAR(CURDATE()) 
AND taa.attendance_status = 'Absent'
";

        $queryForApprovedLeave = "SELECT COUNT(*) AS leave_count
FROM leave_requests lr
JOIN employees e
ON lr.employee_id = e.employee_id
WHERE e.employee_id = :employee_id AND lr.status = 'Approved'
";

//         $queryForBalanceLeave = "SELECT
// e.employee_id,
// lb.days_remaining AS leave_remaining
// FROM leave_balances lb
// JOIN employees e
// ON lb.employee_id = e.employee_id
// WHERE e.employee_id  = :employee_id
// ";
        $queryForBalanceLeave = "SELECT
e.employee_id,
lt.type_name,
lb.days_remaining AS leave_remaining
FROM leave_balances lb
JOIN employees e
ON lb.employee_id = e.employee_id
JOIN leave_types lt
ON	lb.leave_type_id = lt.leave_type_id
WHERE e.employee_id  = :employee_id
ORDER BY lt.leave_type_id ASC
";

        try {
            $stmt = $pdo->prepare($queryForPresent);
            $stmt->execute([
                ":employee_id" => $id,
            ]);
            $stmt1 = $pdo->prepare($queryForLate);
            $stmt1->execute([
                ":employee_id" => $id,
            ]);
            $stmt2 = $pdo->prepare($queryForAbsent);
            $stmt2->execute([
                ":employee_id" => $id,
            ]);
            $stmt3 = $pdo->prepare($queryForApprovedLeave);
            $stmt3->execute([
                ":employee_id" => $id,
            ]);
            $stmt4 = $pdo->prepare($queryForBalanceLeave);
            $stmt4->execute([
                ":employee_id" => $id,
            ]);

            $datas = $stmt->fetch();
            $datas1 = $stmt1->fetch();
            $datas2 = $stmt2->fetch();
            $datas3 = $stmt3->fetch();
            $datas4 = $stmt4->fetchAll();
            $response = [
                "success" => true,
                "data" => [
                    "present_count" => $datas['present_count'],
                    "late_count" => $datas1["late_count"],
                    "absent_count" => $datas2["absent_count"],
                    "leave_count" => $datas3["leave_count"],
                    "leave" =>  array_map(function($row) {
                        return [
                            "leave_type" => $row["type_name"],
                            "leave_remaining" => $row["leave_remaining"]
                        ];
                    }, $datas4)
                ]
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