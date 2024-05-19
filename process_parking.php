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
    // 其他表單數據......

    // SQL 插入語句
    $sql = "INSERT INTO parking (Number, ...) 
            VALUES ('$number', ...)";

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
