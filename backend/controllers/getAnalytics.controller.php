<?php
    // include_once __DIR__ . "/../config/database.php";


    function getAveragePerformance($pdo) {
    
        $query = "SELECT ROUND((AVG(review_score) * 0.1), 2) AS average_performance FROM `performance_reviews` WHERE MONTH(review_date) = MONTH(CURDATE()) AND YEAR(review_date) = YEAR(CURDATE())";
        try {
            $stmt = $pdo->prepare($query);
            $stmt->execute();

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
    function getEmployeePerformanceComparison($pdo) {
    
        $query = "SELECT 
    DATE_FORMAT(pr.review_date, '%Y-%m') AS review_month,
    DATE_FORMAT(pr.review_date, '%M %Y') AS month_name,
    COUNT(DISTINCT pr.employee_id) AS employees_reviewed,
    COUNT(pr.review_id) AS total_reviews,
    ROUND(AVG(pr.review_score), 2) AS avg_review_score,
    MAX(pr.review_score) AS highest_score,
    MIN(pr.review_score) AS lowest_score,
    COUNT(ia.award_id) AS total_awards_given,
    SUM(CASE WHEN ia.status = 'Claimed' THEN 1 ELSE 0 END) AS awards_claimed,
    SUM(CASE WHEN ia.status = 'Pending Approval' THEN 1 ELSE 0 END) AS awards_pending
FROM 
    performance_reviews pr
    LEFT JOIN incentive_awards ia ON pr.review_id = ia.performance_review_id
GROUP BY 
    DATE_FORMAT(pr.review_date, '%Y-%m'),
    DATE_FORMAT(pr.review_date, '%M %Y')
ORDER BY 
    review_month DESC;";
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


    function getAttendanceTrends($pdo) {
    
        $query = "SELECT 
    DATE_FORMAT(schedule_day, '%Y-%m') AS attendance_month,
    DATE_FORMAT(schedule_day, '%M %Y') AS month_name,
    COUNT(DISTINCT employee_id) AS employees_tracked,
    COUNT(*) AS total_records,
    SUM(CASE WHEN attendance_status = 'Present' THEN 1 ELSE 0 END) AS total_present,
    SUM(CASE WHEN attendance_status = 'Absent' THEN 1 ELSE 0 END) AS total_absent,
    SUM(CASE WHEN attendance_status = 'Late' THEN 1 ELSE 0 END) AS total_late,
    SUM(CASE WHEN attendance_status = 'On Leave' THEN 1 ELSE 0 END) AS total_on_leave,
    SUM(CASE WHEN attendance_status = 'Half Day' THEN 1 ELSE 0 END) AS total_half_day,
    ROUND((SUM(CASE WHEN attendance_status = 'Present' THEN 1 ELSE 0 END) / COUNT(*)) * 100, 2) AS attendance_rate,
    ROUND((SUM(CASE WHEN attendance_status = 'Absent' THEN 1 ELSE 0 END) / COUNT(*)) * 100, 2) AS absence_rate,
    ROUND((SUM(CASE WHEN attendance_status = 'Late' THEN 1 ELSE 0 END) / COUNT(*)) * 100, 2) AS late_rate
FROM 
    time_and_attendance
WHERE 
    YEAR(schedule_day) = 2025
GROUP BY 
    DATE_FORMAT(schedule_day, '%Y-%m'),
    DATE_FORMAT(schedule_day, '%M %Y')
ORDER BY 
    attendance_month;";
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

    function getAverageWorkedHours($pdo) {
    
        $query = "WITH employee_weekly_hours AS (
    SELECT 
        employee_id,
        SUM(
            CASE 
                WHEN attendance_status IN ('Present', 'Late') THEN
                    LEAST(17, HOUR(check_out_time))
                    -
                    CASE
                        WHEN MINUTE(check_in_time) >= 15 
                        THEN HOUR(check_in_time) + 1
                        ELSE HOUR(check_in_time)
                    END
                ELSE 0
            END
        ) as hours_worked
    FROM time_and_attendance
    WHERE WEEK(schedule_day, 1) = WEEK(CURDATE(), 1)  -- Current week
      AND YEAR(schedule_day) = YEAR(CURDATE())
    GROUP BY employee_id
)
SELECT 
    ROUND(AVG(hours_worked), 2) as avg_hours_worked
FROM employee_weekly_hours;";
        try {
            $stmt = $pdo->prepare($query);
            $stmt->execute();

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