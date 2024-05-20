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

    // SQL 插入語句
    $sql = "INSERT INTO parking (Number, Name, Phone, LicensePlateNumber, Milage, ParkingNumber, Emigrantiot, EmigrantioPeople, Immigration, ImmigrationPeople, BackDay, BigPackage, SmallPackage, BallTool, SkiBoard, OtherObject, ParkingDay) 
            VALUES ('$number', '$name', '$phone', '$license_plate', '$milage', '$parking_number', '$emigrantiot', '$emigrantio_people', '$immigration', '$immigration_people', '$back_day', '$big_package', '$small_package', '$ball_tool', '$ski_board', '$other_object', '$parking_day')";

    // 執行 SQL 插入語句
    if ($conn->query($sql) === TRUE) {
        $response = array("message" => "停車登記成功！", "success" => true);
    } else {
        $response = array("message" => "錯誤：" . $sql . "<br>" . $conn->error, "success" => false);
    }

    // 關閉連接
    $conn->close();

    // 返回 JSON 格式的響應
    header('Content-Type: application/json');
    echo json_encode($response);
}
?>
