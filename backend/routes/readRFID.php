<?php
$serialPort = "\\\\.\\COM11"; 
$baudRate   = "9600";
require_once __DIR__ . "/../utils/isRFIDExists.php";
require_once __DIR__ . "/../config/database.php";
require_once __DIR__ . "/../controllers/timeIn.controller.php";
require_once __DIR__ . "/../controllers/timeOut.controller.php";
require_once __DIR__ . "/../utils/checkIfTimeIn.php";
require_once __DIR__ . "/../utils/availableToCheckOut.php";
require_once __DIR__ . "/../utils/checkIfEmployeeHasDuty.php";
require_once __DIR__ . "/../utils/isDutyDone.php";

$fp = fopen($serialPort, "r");
if (!$fp) {
    die("Error: Unable to open $serialPort");
}

date_default_timezone_set("Asia/Manila");

while (true) {
    $line = trim(fgets($fp));
    
    if ($line) {
        // Ignore the READY signal, only capture UID
        if ($line !== "READY") {
            // echo "UID: $line\n";
            // echo "endpoint hit";

            $response = isRFIDExists($line, $pdo);

            

            if(!$response["isExist"]){
                echo "RFID is not registered\n";
                continue;
            }

            $employeeId = $response["employeeId"];

          

            // WALA PA VALIDATION IF MAY SCHEDULE BA TALAGA THIS DAY SI EMPLOYEE
            // ps -- working on progress na -- done!
            
            $hasDuty = isEmployeeHasDuty($employeeId, $pdo);

            if(!$hasDuty["hasDuty"]){
                echo $hasDuty["message"] . "\n";
                continue;
            }

            $isDutyDone = isDutyDone($employeeId, $pdo);

            if($isDutyDone["isDone"]){
                echo $isDutyDone["message"] . "\n";
                continue;
            }

            // echo "RFID exists\n";
            // echo "{$response["employeeId"]}\n";

            $isTimeIn = checkIfTimeIn($employeeId, $pdo);

            // WALA PA TIME GAP PARA SA MGA NAG T-TAP NG TIME IN (REASON: BAKA MAG TIME OUT KAGAD KUNG KAKA TIME IN LANG)
            // i think fixed na rin to since para makapag time out si employee, the employee must render 4 hours first
            
            if($isTimeIn["isTimeIn"]){

                $isAvailableToCheckOut = isAvailableToCheckOut($employeeId, $pdo);
                 
                if(!$isAvailableToCheckOut["isAvailable"]){
                    echo "{$isAvailableToCheckOut["message"]}\n";
                    continue;
                } else {
                    $responseFromTimeOutController = timeOut($employeeId, $line, $pdo);
                    echo "{$responseFromTimeOutController["message"]}\n";
                    continue;
                }
            }

            if(date("H:i:s") >= '17:00:00') {
                echo "Time in not available past 5 PM \n";
                continue;
            }

            if(date("H:i:s") <= '07:00:00') {
                echo "Time in not available until 7 AM \n";
                continue;
            }

            // THIS ALSO NEEDS VALIDATION IF THE EMPLOYEE FORGOT TO TIME OUT
            $responseFromTimeInController = timeIn($employeeId, $line, $pdo);
            echo "{$responseFromTimeInController["message"]}\n";

            // HAS TO HANDLE TIME OUT DUPLICATION

            // i can get the employee_Id in the $response["employeeId"];
            
            
        }
    }
    flush();
}

fclose($fp);
?>
