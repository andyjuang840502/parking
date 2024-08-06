<!DOCTYPE html>
<html>
<head>
    <title>停車場離場結算 - 儲存至歷史紀錄</title>
    <link rel="stylesheet" href="style.css"> <!-- 引入外部 CSS 檔案 -->
    <style>
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ddd;
            margin-top: 20px;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>停車場離場結算 - 儲存至歷史紀錄</h2>

    <?php
    // 連接到 MySQL 伺服器
    require_once "config.php";

    // 創建連接
    $conn = new mysqli($servername, $username, $password, $database);

    // 檢查連接是否成功
    if ($conn->connect_error) {
        die("連接失敗: " . $conn->connect_error);
    }

    // 檢查是否收到有效的 POST 數據
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['record']) && isset($_POST['finalCost'])) {
        $record = json_decode($_POST['record'], true);
        $finalCost = $_POST['finalCost'];

        if ($record) {
            // 將停車場離場結算資料插入到 parking_history 資料表中
            $id = $conn->real_escape_string($record['ID']);
            $name = $conn->real_escape_string($record['Name']);
            $phone = $conn->real_escape_string($record['Phone']);
            $licensePlateNumber = $conn->real_escape_string($record['LicensePlateNumber']);
            $parkingDay = $conn->real_escape_string($record['ParkingDay']);
            $backDate = date('Y-m-d H:i:s'); // 當下的時間
            $parkingNumber = $conn->real_escape_string($record['ParkingNumber']);
            $remarks = $conn->real_escape_string($record['Remasks']);

            // 建立插入資料的 SQL 語句
            $sql = "INSERT INTO parking_history (ID, Name, Phone, LicensePlateNumber, ParkingDay, BackDay, ParkingNumber, Cost, Remasks)
                    VALUES ('$id','$name', '$phone', '$licensePlateNumber', '$parkingDay', '$backDate', '$parkingNumber', '$finalCost', '$remarks')";

            if ($conn->query($sql) === TRUE) {
                // 插入成功後刪除原始資料
                $sqlDelete = "DELETE FROM parking WHERE ID = '$id'";

                if ($conn->query($sqlDelete) === TRUE) {
                    echo "<p>資料已成功儲存至歷史紀錄，並從原資料中刪除。</p>";
                    echo "<p class='message'>如欲查詢歷史紀錄，請點 <a href='http://localhost/xampp/parking/history.php'>歷史查詢</a></p>";
                } else {
                    echo "<p>資料儲存成功，但刪除停車資料時發生錯誤: " . $conn->error . "</p>";
                }
            } else {
                echo "<p>發生錯誤: " . $conn->error . "</p>";
            }
        } else {
            echo "<p>無法解析收到的資料。</p>";
        }
    } else {
        echo "<p>沒有收到有效的資料。</p>";
    }

    // 關閉資料庫連接
    $conn->close();
    ?>


    <!-- 返回按鈕 -->
    <button onclick="window.location.href = 'http://localhost/xampp/parking/index.html';" style="margin-top: 10px;">返回</button>
</div>
</body>
</html>
