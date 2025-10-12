<?php

    function getAttendancePercentage($id, $date, $year, $month, $pdo) {
       
        $query = "WITH ScheduledDays AS (
    -- Generate all days the employee SHOULD work in October 2025
    SELECT 
        s.employee_id,
        DATE_ADD(:date, INTERVAL seq DAY) as expected_work_date,
        s.day_of_week
    FROM employee_schedules s
    CROSS JOIN (
        SELECT 0 as seq UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL 
        SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL 
        SELECT 8 UNION ALL SELECT 9 UNION ALL SELECT 10 UNION ALL SELECT 11 UNION ALL 
        SELECT 12 UNION ALL SELECT 13 UNION ALL SELECT 14 UNION ALL SELECT 15 UNION ALL 
        SELECT 16 UNION ALL SELECT 17 UNION ALL SELECT 18 UNION ALL SELECT 19 UNION ALL 
        SELECT 20 UNION ALL SELECT 21 UNION ALL SELECT 22 UNION ALL SELECT 23 UNION ALL 
        SELECT 24 UNION ALL SELECT 25 UNION ALL SELECT 26 UNION ALL SELECT 27 UNION ALL 
        SELECT 28 UNION ALL SELECT 29 UNION ALL SELECT 30
    ) days
    WHERE DATE_ADD(:date, INTERVAL seq DAY) <= LAST_DAY(:date)
      AND DAYNAME(DATE_ADD(:date, INTERVAL seq DAY)) = s.day_of_week
      AND s.employee_id = :employee_id   -- Replace with parameter
)
SELECT 
    sd.employee_id,
    CONCAT(e.first_name, ' ' , e.last_name) as name,
    COUNT(DISTINCT sd.expected_work_date) as expected_working_days,
    COUNT(DISTINCT ta.schedule_day) as actual_attended_days,
    COUNT(DISTINCT sd.expected_work_date) - COUNT(DISTINCT ta.schedule_day) as missed_days,
    SUM(CASE WHEN ta.attendance_status = 'Present' THEN 1 ELSE 0 END) as on_time_days,
    SUM(CASE WHEN ta.attendance_status = 'Late' THEN 1 ELSE 0 END) as late_days,
    SUM(CASE WHEN ta.attendance_status = 'Absent' THEN 1 ELSE 0 END) as absent_days,
    -- Percentage calculation
    ROUND(
        (COALESCE(SUM(CASE WHEN ta.attendance_status = 'Present' THEN 1 ELSE 0 END), 0) / 
        COUNT(DISTINCT sd.expected_work_date)) * 100, 
        2
    ) as attendance_percentage,
    -- Alternative: Days attended percentage (including Late)
    ROUND(
        (COALESCE(COUNT(DISTINCT ta.schedule_day), 0) / 
        COUNT(DISTINCT sd.expected_work_date)) * 100, 
        2
    ) as days_attended_percentage,
    CASE 
        WHEN COUNT(DISTINCT sd.expected_work_date) = COUNT(DISTINCT ta.schedule_day)
             AND SUM(CASE WHEN ta.attendance_status != 'Present' THEN 1 ELSE 0 END) = 0
             AND COUNT(DISTINCT sd.expected_work_date) = SUM(CASE WHEN ta.attendance_status = 'Present' THEN 1 ELSE 0 END)
        THEN 1
        ELSE 0
    END as is_perfect_attendance
FROM ScheduledDays sd
LEFT JOIN time_and_attendance ta 
    ON sd.employee_id = ta.employee_id 
    AND sd.expected_work_date = ta.schedule_day
    AND YEAR(ta.schedule_day) = :year
    AND MONTH(ta.schedule_day) = :month
JOIN employees e ON sd.employee_id = e.employee_id
GROUP BY sd.employee_id;";

        try {
            $stmt = $pdo->prepare($query);
            $stmt->execute([
                ":employee_id" => $id,
                ":date" => $date,
                ":year" => $year,
                ":month" => $month,
            ]);
            $datas = $stmt->fetch();
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