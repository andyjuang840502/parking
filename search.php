<?php
// 包含資料庫連接文件
require_once "config.php";
// 創建到數據庫的連接
$conn = new mysqli($servername, $username, $password, $database);

// 檢查連接是否成功
if ($conn->connect_error) {
    die("連接失敗: " . $conn->connect_error);
}
// 預設的 SQL 查詢
$sql = "SELECT * FROM reservation";

// 檢查是否有提交查詢表單
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 檢查是否有提供姓名作為查詢條件
    if (!empty($_POST["name"])) {
        $name = $_POST["name"];
        $sql .= " WHERE Name LIKE '%$name%'";
    }

    // 檢查是否有提供日期作為查詢條件
    if (!empty($_POST["date"])) {
        $date = $_POST["date"];
        if (!empty($_POST["name"])) {
            $sql .= " AND";
        } else {
            $sql .= " WHERE";
        }
        $sql .= " ReservationDayIn LIKE '%$date%'";
    }

    // 檢查是否有提供車牌作為查詢條件
    if (!empty($_POST["license_plate"])) {
        $license_plate = $_POST["license_plate"];
        if (!empty($_POST["name"]) || !empty($_POST["date"])) {
            $sql .= " AND";
        } else {
            $sql .= " WHERE";
        }
        $sql .= " LicensePlateNumber LIKE '%$license_plate%'";
    }

    // 檢查是否有提供電話作為查詢條件
    if (!empty($_POST["phone"])) {
        $phone = $_POST["phone"];
        if (!empty($_POST["name"]) || !empty($_POST["date"]) || !empty($_POST["license_plate"])) {
            $sql .= " AND";
        } else {
            $sql .= " WHERE";
        }
        $sql .= " Phone LIKE '%$phone%'";
    }
}

// 執行 SQL 查詢
$result = $conn->query($sql);

// 檢查是否查詢成功
if ($result === false) {
    echo "查詢失敗: " . $conn->error;
    exit; // 終止腳本執行
}

// 檢查查詢結果
if ($result->num_rows > 0) {
    // 將查詢結果轉換為關聯陣列並返回
    $rows = array();
    while ($row = $result->fetch_assoc()) {
        $rows[] = $row;
    }
    echo json_encode($rows);
} else {
    // 如果查詢結果為空，返回空陣列
    echo json_encode([]);
}

// 關閉資料庫連接
$conn->close();
?>
