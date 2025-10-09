<?php
    // include_once __DIR__ . "/../config/database.php";
    require_once __DIR__ . "/../utils/checkDuplicateEmailForEmployee.php";


    function getEmployees($pdo) {
    
        $query = "SELECT * FROM employees";
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

    function getEmployee($id, $pdo) {
        $query = "SELECT * FROM employees WHERE employee_id = :employee_id";
        $queryForEmployeeSchedule = "CALL getEmployeeScheduleById(:employee_id)";
        try {
            $stmt = $pdo->prepare($query);
            $stmt1 = $pdo->prepare($queryForEmployeeSchedule);
            $stmt->execute([
                ":employee_id" => $id
            ]);
            $stmt1->execute([
                ":employee_id" => $id
            ]);

            $datas = $stmt->fetch();
            $datas1 = $stmt1->fetch();
            $response = [
                "success" => true,
                "data" => [$datas, $datas1] 
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