<!DOCTYPE html>
<html>
<head>
    <title>歷史紀錄查詢</title>
    <link rel="stylesheet" href="style.css"> <!-- 引入外部 CSS 檔案 -->
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 10px;
            text-align: left;
            border: 1px solid #ddd;
        }
        th {
            background-color: #f4f4f4;
            color: black;
        }
        td {
            color: black;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>歷史紀錄查詢</h2>

    <?php
    // 連接到 MySQL 伺服器
    require_once "config.php";

    // 創建連接
    $conn = new mysqli($servername, $username, $password, $database);

    // 檢查連接是否成功
    if ($conn->connect_error) {
        die("連接失敗: " . $conn->connect_error);
    }

    // 查詢歷史紀錄
    $sql = "SELECT * FROM parking_history";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<table>";
        echo "<tr>
                <th>聯單編號</th>
                <th>駕駛人姓名</th>
                <th>車牌號碼</th>
                <th>連絡電話</th>
                <th>離場時間</th>
                <th>停車位</th>
                <th>進場時間</th>
                <th>金額</th>
                <th>備註</th>
            </tr>";

        // 輸出每一行資料
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>{$row['ID']}</td>";
            echo "<td>{$row['Name']}</td>";
            echo "<td>{$row['LicensePlateNumber']}</td>";    
            echo "<td>{$row['Phone']}</td>";
            echo "<td>{$row['BackDay']}</td>";
            echo "<td>{$row['ParkingNumber']}</td>";
            echo "<td>{$row['ParkingDay']}</td>";
            echo "<td>{$row['Cost']}</td>";
            echo "<td>{$row['Remasks']}</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "<p>沒有找到任何歷史紀錄。</p>";
    }

    // 關閉資料庫連接
    $conn->close();
    ?>

    <!-- 返回按鈕 -->
    <button onclick="window.location.href = 'index.html';" style="margin-top: 10px;">返回</button>
</div>
</body>
</html>
