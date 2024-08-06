<?php
if (isset($_GET["number"])) {
    $delete_number = $_GET["number"];

    require_once "config.php";

    $conn = new mysqli($servername, $username, $password, $database);

    if ($conn->connect_error) {
        die("連接失敗: " . $conn->connect_error);
    }

    // 刪除指定的停車位資料
    $sql_delete = "DELETE FROM parking_number WHERE number='$delete_number'";

    if ($conn->query($sql_delete) === TRUE) {
        // 刪除成功，跳轉並顯示成功訊息
        echo "<script>alert('停車位已成功刪除'); window.location.href = 'http://localhost/xampp/parking/parking_number.php';</script>";
        exit();
    } else {
        echo "錯誤: " . $sql_delete . "<br>" . $conn->error;
    }

    $conn->close();
} else {
    echo "未指定要刪除的停車位";
}
?>
