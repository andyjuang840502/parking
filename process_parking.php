<?php
// 包含 MySQL 配置檔
require_once "config.php";

// 確認是否有提交表單
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 創建連接
    $conn = new mysqli($servername, $username, $password, $database);

    // 檢查連接是否成功
    if ($conn->connect_error) {
        die("連接失敗：" . $conn->connect_error);
    }

    $parking_amount = 10; //停車場總停車格數
    $count = 0; //停車場停放+預約數量


    // 獲取表單數據
    $number = $_POST["number"];
    $ID = $_POST["ID"];
    $name = $_POST["name"];
    $phone = $_POST["phone"];
    $license_plate = $_POST["license_plate"];
    $milage = $_POST["milage"];
    $parking_number = $_POST["parking_number"];
    $emigrantiot = $_POST["emigrantiot"];
    $emigrantio_people = $_POST["emigrantio_people"];
    $immigration = $_POST["immigration"];
    $immigration_people = $_POST["immigration_people"];
    $back_day = $_POST["back_day"];
    $big_package = $_POST["big_package"];
    $small_package = $_POST["small_package"];
    $ball_tool = $_POST["ball_tool"];
    $ski_board = $_POST["ski_board"];
    $other_object = $_POST["other_object"];
    $parking_day = $_POST["parking_day"];
    $remasks = $_POST["remasks"];
    //$number_reservation = $_POST["number_reservation"];

    $now = time();
    $entry_time_stamp = strtotime($parking_day);
    $exit_time_stamp = strtotime($back_day);

    //echo "Debug: Number = " . $number ;

    //==============查詢預約欄位 是否還有停車位可預約===========//
    // 判斷進場
    $sql = "SELECT COUNT(*) AS count FROM reservation WHERE ? BETWEEN ReservationDayIn AND ReservationDayOut";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $entry_time);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $reservation_count = $row['count'];
    $stmt->close();

    // 判斷退場
    $sql = "SELECT COUNT(*) AS count FROM reservation WHERE ? BETWEEN ReservationDayIn AND ReservationDayOut";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $exit_time);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $reservation_exit_count = $row['count'];
    $stmt->close();
    //==============查詢預約欄位 是否還有停車位可預約===========//

    //==============查詢停車欄位 是否還有停車位可預約===========//
    // 判斷進場
    $sql = "SELECT COUNT(*) AS count FROM parking WHERE ? BETWEEN ParkingDay AND BackDay";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $entry_time);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $parking_count = $row['count'];
    $stmt->close();
    // 判斷退場
    $sql = "SELECT COUNT(*) AS count FROM parking WHERE ? BETWEEN ParkingDay AND BackDay";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $exit_time);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $parking_exit_count = $row['count'];
    $stmt->close();
    //==============查詢停車欄位 是否還有停車位可預約===========//

    //==============查詢車位是否有被停=========================//
    $sql = "SELECT * FROM parking WHERE ParkingNumber = ? AND BackDay >= ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $parking_number, $now);
    $stmt->execute();
    $result = $stmt->get_result();
    $parking_exists = $result->num_rows > 0; // 如果有相應的記錄，則為 true；否則為 false
    $stmt->close();
    //==============查詢車位是否有被停=========================//

    $count = $reservation_count + $parking_count;  //進場：預約+已停車數量
    $exit_count = $reservation_exit_count + $parking_exit_count;  //退場：預約+ 

    if ($count >= $parking_amount or $exit_count >= $parking_amount) {
        $response = array("message" => "抱歉，停車場已滿！");
    } elseif ($entry_time_stamp < ($now-86400)) {
        $response = array("message" => "進場時間不能是過去！");
    } elseif ($exit_time_stamp < ($now-86400)) {
        $response = array("message" => "回國時間不能是過去！");
    } elseif ($exit_time_stamp < $entry_time_stamp) {
        $response = array("message" => "時間錯誤，請重新輸入！");
    } elseif ($emigrantio_people < 0) {
        $response = array("message" => "出境人數不得為負！");
    } elseif ($immigration_people < 0) {
        $response = array("message" => "入境人數不得為負！");
    } elseif ($parking_exists <> 0) {
        $response = array("message" => "該車位已有停車，請填寫其他車位！");
    } else {

        $stmt = $conn->prepare("INSERT INTO parking (ID, Name, Phone, LicensePlateNumber, Milage, ParkingNumber, Emigrantiot, EmigrantiotPeople, Immigration, ImmigrationPeople, BackDay, BigPackage, SmallPackage, BallTool, SkiBoard, OtherObject, ParkingDay, Remasks) 
                            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    
        // 綁定參數並執行
        $stmt->bind_param("ssssssssssssssssss", $ID, $name, $phone, $license_plate, $milage, $parking_number, $emigrantiot, $emigrantio_people, $immigration, $immigration_people, $back_day, $big_package, $small_package, $ball_tool, $ski_board, $other_object, $parking_day, $remasks);
        
        
        
        if ($stmt->execute()) {
            // 插入成功，準備刪除預約紀錄
            $stmt->close(); // 關閉之前的 prepared statement
            //$response = array("message" => "停車登記成功！  $number", "success" => true);
            
            if (isset($number) && is_numeric($number)) {
                $delete_stmt = $conn->prepare("DELETE FROM reservation WHERE Number = ?");
                $delete_stmt->bind_param("s", $number);
                if ($delete_stmt->execute()) {
                    $response = array("message" => "停車登記成功！" , "success" => true);
                } else {
                $response = array("message" => "刪除預約紀錄時發生錯誤：" . $delete_stmt->error, "success" => false);
                }
                $delete_stmt->close(); // 關閉 prepared statement
            } else {
                $response = array("message" => "停車登記成功！" . $number, "success" => true);
            }
        } else {
            $response = array("message" => "錯誤：" . $stmt->error, "success" => false);
        }
        
        
        
    }

    


    // 關閉連接
    //$conn->close();

    // 返回 JSON 格式的響應
    header('Content-Type: application/json');
    echo json_encode($response);
}
?>
