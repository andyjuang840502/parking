<?php
// 包含配置檔
require_once "config.php";

// 創建連接
$conn = new mysqli($servername, $username, $password, $database);

// 檢查連接是否成功
if ($conn->connect_error) {
    die("連接失敗：" . $conn->connect_error);
}

$parking_amount = 5; //停車場總停車格數
$count = 0; //停車場停放+預約數量

// 獲取表單數據
$name = $_POST["name"];
$phone = $_POST["phone"];
$license_plate = $_POST["license_plate"];
$mileage = $_POST["mileage"];
$people_count = $_POST["people_count"];
$entry_time = $_POST["entry_time"];
$exit_time = $_POST["exit_time"];
$remasks = $_POST["remasks"];

// 確保表單提交的數據不為空
if (!empty($name) && !empty($phone) && !empty($license_plate) && !empty($entry_time) && !empty($exit_time)) {
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

    // 判斷退場
    $sql = "SELECT COUNT(*) AS count FROM parking WHERE ? BETWEEN ParkingDay AND BackDay";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $exit_time);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $parking_exit_count = $row['count'];
    //==============查詢停車欄位 是否還有停車位可預約===========//

    $count = $reservation_count + $parking_count;
    $exit_count = $reservation_exit_count + $parking_exit_count;

    // 判斷停車場剩餘數量
    if ($count >= $parking_amount or $exit_count >= $parking_amount) {
        $response = array("message" => "抱歉，停車場已滿，請選擇其他時間預約！");
    } else {
        // SQL 插入語句
        $sql = "INSERT INTO reservation (Name, Phone, LicensePlateNumber, ReservationDayIn, Milage, People, ReservationDayOut, Remasks) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

        // 准备查询语句并绑定参数
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssssss", $name, $phone, $license_plate, $entry_time, $mileage, $people_count, $exit_time, $remasks);

        // 執行 SQL 插入語句
        if ($stmt->execute()) {
            $response = array("message" => "預約成功！", "success" => true);
        } else {
            $response = array("message" => "錯誤：" . $sql . "<br>" . $conn->error, "success" => false);
        }
    }
} else {
    $response = array("message" => "請填寫所有必填欄位！");
}

// 返回 JSON 格式的響應
header('Content-Type: application/json');
echo json_encode($response);

// 關閉連接
$stmt->close();
$conn->close();
?>
