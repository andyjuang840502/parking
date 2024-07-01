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

    // 獲取表單數據
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

    // 確認時間戳
    $now = time();
    $entry_time_stamp = strtotime($parking_day);
    $exit_time_stamp = strtotime($back_day);

    // 檢查停車場是否已滿
    $parking_amount = 10; // 停車場總停車格數
    $count = checkParkingAvailability($conn, $entry_time_stamp, $exit_time_stamp, $parking_amount);

    if ($count >= ($parking_amount - 1)) {
        $response = array("message" => "抱歉，停車場已滿！");
    } elseif ($exit_time_stamp < ($now - 86400)) {
        $response = array("message" => "回國時間不能是過去！");
    } elseif ($exit_time_stamp < $entry_time_stamp) {
        $response = array("message" => "時間錯誤，請重新輸入！");
    } elseif ($emigrantio_people < 0) {
        $response = array("message" => "出境人數不得為負！");
    } elseif ($immigration_people < 0) {
        $response = array("message" => "入境人數不得為負！");
    } else {
        // 執行更新操作
        $success = updateParkingRecord($conn, $ID, $name, $phone, $license_plate, $milage, $parking_number, $emigrantiot, $emigrantio_people, $immigration, $immigration_people, $back_day, $big_package, $small_package, $ball_tool, $ski_board, $other_object, $parking_day, $remasks);
        
        if ($success) {
            $response = array("message" => "修改成功", "success" => true);
        } else {
            $response = array("message" => "修改失敗", "success" => false);
        }
    }

    // 關閉連接
    $conn->close();

    // 返回 JSON 格式的響應
    header('Content-Type: application/json');
    echo json_encode($response);
}

// 函數：檢查停車場是否還有空位
function checkParkingAvailability($conn, $entry_time_stamp, $exit_time_stamp, $parking_amount) {
    $count = 0;

    // 查詢預約欄位是否還有停車位可預約
    $count += countReservedParking($conn, $entry_time_stamp);
    $count += countReservedParking($conn, $exit_time_stamp);

    // 查詢停車欄位是否還有停車位可預約
    $count += countActualParking($conn, $entry_time_stamp);
    $count += countActualParking($conn, $exit_time_stamp);

    return $count;
}

// 函數：計算預約的停車位數量
function countReservedParking($conn, $time_stamp) {
    $sql = "SELECT COUNT(*) AS count FROM reservation WHERE ? BETWEEN ReservationDayIn AND ReservationDayOut";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $time_stamp);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $count = $row['count'];
    $stmt->close();
    return $count;
}

// 函數：計算實際停車位數量
function countActualParking($conn, $time_stamp) {
    $sql = "SELECT COUNT(*) AS count FROM parking WHERE ? BETWEEN ParkingDay AND BackDay";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $time_stamp);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $count = $row['count'];
    $stmt->close();
    return $count;
}

// 函數：更新停車記錄
function updateParkingRecord($conn, $ID, $name, $phone, $license_plate, $milage, $parking_number, $emigrantiot, $emigrantio_people, $immigration, $immigration_people, $back_day, $big_package, $small_package, $ball_tool, $ski_board, $other_object, $parking_day, $remasks) {
    $stmt = $conn->prepare("UPDATE parking 
                            SET Name=?, Phone=?, LicensePlateNumber=?, Milage=?, ParkingNumber=?, Emigrantiot=?, EmigrantiotPeople=?, Immigration=?, ImmigrationPeople=?, BackDay=?, BigPackage=?, SmallPackage=?, BallTool=?, SkiBoard=?, OtherObject=?, ParkingDay=?, Remasks=? 
                            WHERE ID=?");

    if ($stmt === false) {
        echo "準備更新語句失敗: " . $conn->error;
        return false;
    }

    // 綁定參數並執行
    $stmt->bind_param("ssssssssssssssssss", $name, $phone, $license_plate, $milage, $parking_number, $emigrantiot, $emigrantio_people, $immigration, $immigration_people, $back_day, $big_package, $small_package, $ball_tool, $ski_board, $other_object, $parking_day, $remasks, $ID);

    // 執行更新
    $success = $stmt->execute();

    // 關閉語句
    $stmt->close();

    return $success;
}
?>
