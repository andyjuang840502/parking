<?php
// 包含資料庫連接文件
require_once "config.php";

// 創建到數據庫的連接
$conn = new mysqli($servername, $username, $password, $database);

// 檢查連接是否成功
if ($conn->connect_error) {
    die("連接失敗: " . $conn->connect_error);
}

// 確保收到數字參數
if (isset($_POST['number'])) {
    $number = $_POST['number'];

    // 準備刪除 SQL 語句
    $sql = "DELETE FROM reservation WHERE Number = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $number);

    if ($stmt->execute()) {
        echo "刪除成功";
    } else {
        echo "刪除失敗: " . $conn->error;
    }

    // 關閉聲明
    $stmt->close();
} else {
    echo "沒有提供預約編號";
}

// 關閉資料庫連接
$conn->close();
?>
