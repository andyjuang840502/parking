<?php
require_once "config.php";

// 檢查是否收到有效的 POST 數據
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['new_daily_rate'])) {
    // 創建連接
    $conn = new mysqli($servername, $username, $password, $database);

    // 檢查連接是否成功
    if ($conn->connect_error) {
        die("連接失敗: " . $conn->connect_error);
    }

    // 獲取提交的新每日費率
    $newDailyRate = $_POST['new_daily_rate'];

    // 更新 price 表中的每日費率
    $sql = "UPDATE price SET daily_rate = '$newDailyRate'";

    if ($conn->query($sql) === TRUE) {
        // 成功更新後，將費率存儲到 $_SESSION 中以便於 price.php 使用
        session_start();
        $_SESSION['dailyRate'] = $newDailyRate;

        // 關閉連接
        $conn->close();

        // 導向回 price.php
        header('Location: price.php');
        exit;
    } else {
        echo "Error updating record: " . $conn->error;
    }

    $conn->close();
} else {
    echo "無效的請求";
}
?>
