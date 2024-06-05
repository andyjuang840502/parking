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

    $now = time();
    $entry_time_stamp = strtotime($parking_day);
    $exit_time_stamp = strtotime($back_day);


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

    if ($count >= $parking_amount or $exit_count >= $parking_amount) {
        $response = array("message" => "抱歉，停車場已滿！");
    } elseif ($entry_time_stamp < $now) {
        $response = array("message" => "進場時間不能是過去！");
    } elseif ($exit_time_stamp < $now) {
        $response = array("message" => "回國時間不能是過去！");
    } elseif ($exit_time_stamp < $entry_time_stamp) {
        $response = array("message" => "時間錯誤，請重新輸入！");
    } elseif ($emigrantio_people < 0) {
        $response = array("message" => "出境人數不得為負！");
    } elseif ($immigration_people < 0) {
        $response = array("message" => "入境人數不得為負！");
    } else {
        // SQL 插入語句
        $sql = "INSERT INTO parking (Number, Name, Phone, LicensePlateNumber, Milage, ParkingNumber, Emigrantiot, EmigrantiotPeople, Immigration, ImmigrationPeople, BackDay, BigPackage, SmallPackage, BallTool, SkiBoard, OtherObject, ParkingDay) 
                VALUES ('$number', '$name', '$phone', '$license_plate', '$milage', '$parking_number', '$emigrantiot', '$emigrantio_people', '$immigration', '$immigration_people', '$back_day', '$big_package', '$small_package', '$ball_tool', '$ski_board', '$other_object', '$parking_day')";

        // 執行 SQL 插入語句
        if ($conn->query($sql) === TRUE) {
            $response = array("message" => "停車登記成功！", "success" => true);
        } else {
            $response = array("message" => "錯誤：" . $sql . "<br>" . $conn->error, "success" => false);
        }
    }


    // 關閉連接
    $conn->close();

    // 返回 JSON 格式的響應
    header('Content-Type: application/json');
    echo json_encode($response);
}
?>
