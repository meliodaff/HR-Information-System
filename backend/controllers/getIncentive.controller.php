<?php

     function getIncentives($isClaim, $pdo) {
    
        $query = "SELECT
e.employee_id,
i.incentive_id,
CONCAT(e.first_name, ' ', e.last_name) AS name,
i.incentive_name,
i.description,
ia.notes,
ia.bonus,
ia.award_date,
ia.claimed_date,
ia.status,
ia.is_claimed
FROM incentive_awards ia
JOIN employees e
ON ia.employee_id = e.employee_id
JOIN incentives i
ON ia.incentive_id = i.incentive_id
WHERE is_claimed = :is_claim";
        try {
            $stmt = $pdo->prepare($query);
            $stmt->execute([
                "is_claim" => $isClaim
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
ia.status,
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
    function getAllIncentivesForTheMonth($pdo) {
        $query = "SELECT
e.employee_id,
e.profile_image_url,
i.incentive_id,
CONCAT(e.first_name, ' ', e.last_name) AS name,
i.incentive_name,
i.description,
ia.notes,
ia.bonus,
ia.award_date,
ia.status,
ia.is_claimed
FROM incentive_awards ia
JOIN employees e
ON ia.employee_id = e.employee_id
JOIN incentives i
ON ia.incentive_id = i.incentive_id
WHERE YEAR(ia.award_date) = YEAR(CURDATE())
AND MONTH(ia.award_date) = MONTH(CURDATE())
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

    function getTotalIncentivesGivenPerMonth($pdo) {
        $query = "SELECT 
    SUM(
        CAST(
            REPLACE(REPLACE(bonus, '₱', ''), ',', '') 
            AS DECIMAL(10,2)
        )
    ) AS total_incentives_value
FROM incentive_awards
WHERE status = 'Claimed' AND YEAR(award_date) = YEAR(CURDATE()) AND MONTH(award_date) = MONTH(CURDATE())
  AND bonus REGEXP '^₱[0-9,]+';
";

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