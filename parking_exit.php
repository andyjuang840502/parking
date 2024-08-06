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
    // 連接到 MySQL 伺服器
    require_once "config.php";

    // 創建連接
    $conn = new mysqli($servername, $username, $password, $database);

    // 檢查連接是否成功
    if ($conn->connect_error) {
        die("連接失敗: " . $conn->connect_error);
    }

    // 查詢每日費率
    $sql = "SELECT daily_rate FROM price";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // 獲取每日費率
        $row = $result->fetch_assoc();
        $cost = $row["daily_rate"];
    } else {
        $cost = "未設定費用";
    }

    // 檢查是否收到有效的 POST 數據
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['record'])) {
        $record = json_decode($_POST['record'], true);
        if ($record) {
            // 計算停車天數和總費用
            $parkingStartDate = new DateTime($record['ParkingDay']);
            $backDate = new DateTime(); // 當下的時間
            
            // 計算兩個日期之間的差異
            $diff = $backDate->diff($parkingStartDate);

            // 計算總天數
            $totalDays = $diff->days;

            // 如果離場時間在進場時間的同一天，也算作一天
            if ($backDate->format('Y-m-d') === $parkingStartDate->format('Y-m-d')) {
                $totalDays = 1;
            } else {
                // 計算日期差異後加一天
                $totalDays = $diff->days + 1;
            }
            
            $totalCost = $cost * $totalDays;

            // 輸出停車場離場結算明細表格
            echo "<table>";
            echo "<tr><th colspan='2'>基本資訊</th></tr>";
            echo "<tr><td>聯單編號</td><td>" . htmlspecialchars($record['ID']) . "</td></tr>";
            echo "<tr><td>姓名</td><td>" . htmlspecialchars($record['Name']) . "</td></tr>";
            echo "<tr><td>連絡電話</td><td>" . htmlspecialchars($record['Phone']) . "</td></tr>";
            echo "<tr><td>車牌號碼</td><td>" . htmlspecialchars($record['LicensePlateNumber']) . "</td></tr>";
            echo "<tr><td>進場時間</td><td>" . htmlspecialchars($record['ParkingDay']) . "</td></tr>";
            echo "<tr><td>離場時間</td><td>" . $backDate->format('Y-m-d H:i:s') . "</td></tr>"; // 當下的時間
            echo "<tr><td>停車位</td><td>" . htmlspecialchars($record['ParkingNumber']) . "</td></tr>";
            echo "<tr><td>每日費率</td><td>" . htmlspecialchars($cost) . " 元</td></tr>";
            echo "<tr><td>停車天數</td><td>" . htmlspecialchars($totalDays) . " 天</td></tr>";
            echo "<tr><td>總共費用</td><td>" . htmlspecialchars($totalCost) . " 元</td></tr>";
            echo "<tr><td>備註</td><td>" . htmlspecialchars($record['Remasks']) . "</td></tr>";
            echo "</table>";
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
    <button onclick="window.history.back();" style="margin-top: 10px;">返回</button>

    <!-- 產出離場報表按鈕 -->
    <form action="generate_report.php" method="post" style="display: inline;">
        <input type="hidden" name="record" value="<?php echo htmlspecialchars(json_encode($record)); ?>">
        <button type="submit" style="margin-top: 10px;">產出離場報表</button>
    </form>

    <!-- 結算 -->
    <form action="parking_history.php" method="post" class="form-group" onsubmit="return confirmCheckout()">
        <input type="hidden" name="record" value="<?php echo htmlspecialchars(json_encode($record)); ?>">

        <!-- 最终金额输入框 -->
        <label for="finalCost">最終金額：</label>
        <input type="number" id="finalCost" name="finalCost" step="any" value="<?php echo htmlspecialchars($totalCost); ?>" required>
        
        <!-- 结算按钮 -->
        <button type="submit" name="checkout">結算</button>
    </form>

</div>

    <script>
        // JavaScript 部分，用于确认结算
        function confirmCheckout() {
            return confirm("是否確認結算？");
        }
    </script>
</body>
</html>



