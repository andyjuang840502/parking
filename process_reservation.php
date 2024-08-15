<?php
// 包含配置檔
require_once "config.php";

// 創建連接
$conn = new mysqli($servername, $username, $password, $database);

// 檢查連接是否成功
if ($conn->connect_error) {
    die("連接失敗：" . $conn->connect_error);
}

$parking_amount = 50; //停車場總停車格數
$count = 0; //停車場停放+預約數量

$stmt_select = null;
$stmt_update = null;

// 獲取表單數據
$name = $_POST["name"];
$phone = $_POST["phone"];
$license_plate = $_POST["license_plate"];
$mileage = $_POST["mileage"];
$people_count = $_POST["people_count"];
$entry_time = $_POST["entry_time"];
$exit_time = $_POST["exit_time"];
$remasks = $_POST["remasks"];
$number = $_POST["number"];

$now = time();
$entry_time_stamp = strtotime($entry_time);
$exit_time_stamp = strtotime($exit_time);

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

    if (empty($number)) { //如果沒有流水號，表示為新的預約
        // 判斷停車場剩餘數量
        if ($count >= $parking_amount or $exit_count >= $parking_amount) {
            $response = array("message" => "抱歉，停車場已滿，請選擇其他時間預約！");
        } elseif ($entry_time_stamp < ($now-86400)) {
            $response = array("message" => "預約進場時間不能是過去！");
        } elseif ($exit_time_stamp < ($now-86400)) {
            $response = array("message" => "預約離場時間不能是過去！");
        } elseif ($exit_time_stamp < $entry_time_stamp) {
            $response = array("message" => "離場時間不得早於進場時間！");
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
    } else { //如果有流水號，表示已經有預約過，此為修改預約需求
        // 判斷停車場剩餘數量
        if ($count >= ($parking_amount+1) or $exit_count >= ($parking_amount+1)) {
            $response = array("message" => "抱歉，停車場已滿，請選擇其他時間預約！");
        } elseif ($entry_time_stamp < ($now-86400)) {
            $response = array("message" => "預約進場時間不能是過去！");
        } elseif ($exit_time_stamp < ($now-86400)) {
            $response = array("message" => "預約離場時間不能是過去！");
        } elseif ($exit_time_stamp < $entry_time_stamp) {
            $response = array("message" => "時間錯誤，請重新輸入！");
        } else {
            // SQL 插入語句
            $sql_select = "SELECT * FROM reservation WHERE Number = ?";
            $stmt_select = $conn->prepare($sql_select);
            $stmt_select->bind_param("s", $number);
            $stmt_select->execute();
            $result_select = $stmt_select->get_result();

            // 檢查是否找到了相應的記錄
            if ($result_select->num_rows > 0) {
                // 如果找到了記錄，則執行修改操作

                // 這裡是你的修改操作
                // 例如，更新記錄的某些字段值
                $row = $result_select->fetch_assoc();
                $id_to_update = $row['Number']; // 假設 Number 是要修改的記錄的唯一標識符

                $sql_update = "UPDATE reservation SET Name = ?, Phone = ?, LicensePlateNumber = ?, ReservationDayIn = ?, Milage = ?, People = ?, ReservationDayOut = ?, Remasks = ? WHERE Number = ?";
                $stmt_update = $conn->prepare($sql_update);
                if ($stmt_update) {
                    $stmt_update->bind_param("sssssssss", $name, $phone, $license_plate, $entry_time, $mileage, $people_count, $exit_time, $remasks, $number);

                    if ($stmt_update->execute()) {
                        $response = array("message" => "修改成功！", "success" => true);
                    } else {
                        $response = array("message" => "修改失敗：" . $stmt_update->error, "success" => false);
                    }
                } else {
                    $response = array("message" => "修改失敗：" . $conn->error, "success" => false);
                }
            } else {
                // 如果沒有找到相應的記錄，返回錯誤信息
                $response = array("message" => "找不到要修改的記錄！", "success" => false);
            }
        }
    }
} else {
    $response = array("message" => "請填寫所有必填欄位！");
}

// 返回 JSON 格式的響應
header('Content-Type: application/json');
echo json_encode($response);

// 關閉準備好的語句
if ($stmt_select) {
    $stmt_select->close();
}
if ($stmt) {
    $stmt->close();
}
if ($stmt_update) {
    $stmt_update->close();
}
// 關閉連接
$conn->close();
?>
