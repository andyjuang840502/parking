<!DOCTYPE html>
<html>
<head>
    <title>停車場離場結算</title>
    <link rel="stylesheet" href="style.css"> <!-- 引入外部 CSS 檔案 -->
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 8px;
            text-align: left;
            border: 1px solid #ddd;
        }
        th {
            background-color: #f2f2f2;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>停車場離場結算明細</h2>

    <?php
    $cost = 100;
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['record'])) {
        $record = json_decode($_POST['record'], true);
        if ($record) {
            echo "<table>";
            echo "<tr><th colspan='2'>基本資訊</th></tr>";
            echo "<tr><td>姓名</td><td>" . htmlspecialchars($record['Name']) . "</td></tr>";
            echo "<tr><td>連絡電話</td><td>" . htmlspecialchars($record['Phone']) . "</td></tr>";
            echo "<tr><td>車牌號碼</td><td>" . htmlspecialchars($record['LicensePlateNumber']) . "</td></tr>";
            echo "<tr><td>進場時間</td><td>" . htmlspecialchars($record['ParkingDay']) . "</td></tr>";
            echo "<tr><td>回國時間</td><td>" . htmlspecialchars($record['BackDay']) . "</td></tr>";
            echo "<tr><td>停車位</td><td>" . htmlspecialchars($record['ParkingNumber']) . "</td></tr>";
            echo "<tr><td>估算費用</td><td>" . htmlspecialchars($cost) . "</td></tr>";
            echo "<tr><td>備註</td><td>" . htmlspecialchars($record['Remasks']) . "</td></tr>";
            echo "</table>";
        } else {
            echo "<p>無法解析收到的資料。</p>";
        }
    } else {
        echo "<p>沒有收到有效的資料。</p>";
    }
    ?>

    <!-- 返回按鈕 -->
    <button onclick="window.history.back();" style="margin-top: 10px;">返回</button>

    <!-- 產出離場報表按鈕 -->
    <form action="generate_report.php" method="post" style="display: inline;">
        <input type="hidden" name="record" value="<?php echo htmlspecialchars(json_encode($record)); ?>">
        <button type="submit" style="margin-top: 10px;">產出離場報表</button>
    </form>


</div>
</body>
</html>
