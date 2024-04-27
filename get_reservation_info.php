<?php
// 包含 MySQL 配置檔
require_once "config.php";

// 檢查是否有傳遞車牌號碼參數
if(isset($_GET['license_plate'])) {
    // 獲取車牌號碼
    $license_plate = $_GET['license_plate'];

    try {
        // 建立與資料庫的連線
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        // 設置PDO錯誤模式為例外
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // 準備查詢
        $stmt = $conn->prepare("SELECT * FROM reservation WHERE LicensePlateNumber = :license_plate");
        // 綁定參數
        $stmt->bindParam(':license_plate', $license_plate);
        // 執行查詢
        $stmt->execute();

        // 檢查是否有查詢到結果
        if ($stmt->rowCount() > 0) {
            // 將查詢結果轉換為關聯數組
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            // 返回JSON格式的結果
            echo json_encode($result);
        } else {
            // 如果沒有查詢到結果，返回空值
            echo json_encode(null);
        }
    } catch(PDOException $e) {
        // 如果有錯誤，返回錯誤訊息
        echo "Error: " . $e->getMessage();
    }
    // 關閉資料庫連線
    $conn = null;
} else {
    // 如果未提供車牌號碼，返回錯誤訊息
    echo "請提供車牌號碼";
}
?>
