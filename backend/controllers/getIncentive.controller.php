<?php

     function getIncentives($pdo) {
    
        $query = "SELECT
e.employee_id,
 e.first_name,
 e.last_name,
 i.incentive_name,
 ia.bonus,
 MONTHNAME(ia.award_date) month_award,
 YEAR(ia.award_date) year_award,
 ia.is_claimed
FROM incentive_awards ia
JOIN incentives i
ON ia.incentive_id = i.incentive_id
JOIN employees e
ON e.employee_id = ia.employee_id
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

    function getIncentive($id, $pdo) {
        $query = "SELECT
e.employee_id,
 e.first_name,
 e.last_name,
 i.incentive_name,
 ia.bonus,
 MONTHNAME(ia.award_date) month_award,
 YEAR(ia.award_date) year_award,
 ia.is_claimed
FROM incentive_awards ia
JOIN incentives i
ON ia.incentive_id = i.incentive_id
JOIN employees e
ON e.employee_id = ia.employee_id
WHERE e.employee_id = :employee_id
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