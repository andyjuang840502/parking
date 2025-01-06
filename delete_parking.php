<?php
require_once "config.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST['id'])) {
        $parking_id = $_POST['id'];

        // 建立資料庫連線
        $conn = new mysqli($servername, $username, $password, $database);

        if ($conn->connect_error) {
            die("連接失敗: " . $conn->connect_error);
        }

        // 刪除停車記錄
        $sql = "DELETE FROM parking WHERE ID = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $parking_id); // 使用 "i" 表示整數類型
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            echo "刪除成功";
        } else {
            echo "刪除失敗，請確認記錄是否存在";
        }

        // 關閉資料庫連線
        $stmt->close();
        $conn->close();
    } else {
        echo "無效的請求";
    }
}
?>
