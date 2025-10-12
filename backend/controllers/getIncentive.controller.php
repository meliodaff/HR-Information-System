<?php

     function getIncentives($pdo) {
    
        $query = "SELECT
e.employee_id,
i.incentive_id,
CONCAT(e.first_name, ' ', e.last_name) AS name,
i.incentive_name,
i.description,
ia.notes,
ia.bonus,
ia.award_date,
ia.is_claimed
FROM incentive_awards ia
JOIN employees e
ON ia.employee_id = e.employee_id
JOIN incentives i
ON ia.incentive_id = i.incentive_id";
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
i.incentive_id,
CONCAT(e.first_name, ' ', e.last_name) AS name,
i.incentive_name,
i.description,
ia.notes,
ia.bonus,
ia.award_date,
ia.is_claimed
FROM incentive_awards ia
JOIN employees e
ON ia.employee_id = e.employee_id
JOIN incentives i
ON ia.incentive_id = i.incentive_id
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