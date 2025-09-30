<?php
$serialPort = "\\\\.\\COM10"; 
$baudRate   = "9600";
require_once __DIR__ . "/../utils/isRFIDExists.php";
require_once __DIR__ . "/../config/database.php";
require_once __DIR__ . "/../controllers/timeIn.controller.php";

$fp = fopen($serialPort, "r");
if (!$fp) {
    die("Error: Unable to open $serialPort");
}

while (true) {
    $line = trim(fgets($fp));

    if ($line) {
        // Ignore the READY signal, only capture UID
        if ($line !== "READY") {
            // echo "UID: $line\n";
            // echo "endpoint hit";
            $response = isRFIDExists($line, $pdo);

            if(!$response["isExist"]){
                echo "RFID Doesnt exist\n";
                continue;
            }

            echo "RFID exists\n";
            echo "{$response["employeeId"]}\n";

            $responseFromTimeInController = timeIn($response["employeeId"], $line, $pdo);

            echo "{$responseFromTimeInController["message"]}\n";
            
            
        }
    }
    flush();
}

fclose($fp);
?>
