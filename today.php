<!DOCTYPE html>
<html>
<head>
    <title>晶順停車場 預約及停車狀況</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <style>
        body {
            background-image: url('background_image.jpg'); /* 添加背景圖片 */
            background-size: cover;
            font-family: Arial, sans-serif;
            color: #333;
        }
        h2 {
            text-align: center;
            margin-top: 50px;
        }
        .result-container {
            background-color: #f0f0f0;
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 8px;
        }
        .result-title {
            font-size: 18px;
            text-align: center;
            margin-top: 0;
            margin-bottom: 10px;
        }
        table {
            width: 80%;
            margin: 0 auto;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .status-container {
            margin: 20px auto;
            width: 80%;
        }
        .tab {
            overflow: hidden;
            background-color: #007bff;
            border-radius: 5px 5px 0 0;
        }
        .tab button {
            background-color: #007bff;
            border: none;
            outline: none;
            cursor: pointer;
            padding: 14px 16px;
            font-size: 16px;
            color: white;
            transition: background-color 0.3s;
        }
        .tab button:hover {
            background-color: #0056b3;
        }
        .tab-content {
            display: none;
            padding: 20px;
            border: 1px solid #007bff;
            border-top: none;
            background-color: #f0f0f0;
        }
        .tab-content table {
            width: 100%;
        }
        .tab-content .available {
            background-color: #dff0d8;
        }
        .tab-content .occupied {
            background-color: #f2dede;
        }
        .active {
            background-color: #0056b3;
        }
        .overview-container, .overview-container h2 {
            cursor: pointer;
        }
        .overview-content {
            display: none;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <h2>查詢所有 預約及停車 狀況</h2>

    <?php
    date_default_timezone_set('Asia/Taipei'); // 設定為台灣時間 UTC+8
    require_once "config.php";

    // 創建到數據庫的連接
    $conn = new mysqli($servername, $username, $password, $database);

    // 檢查連接是否成功
    if ($conn->connect_error) {
        die("連接失敗: " . $conn->connect_error);
    }

    // 今天的日期
    $today = date('Y-m-d');

    // 查詢今天所有預約的詳細資料
    $queryAllReservations = "SELECT * FROM reservation WHERE ReservationDayIn = '$today'";
    $resultAllReservations = $conn->query($queryAllReservations);
    if ($resultAllReservations) {
        $numRows = $resultAllReservations->num_rows;
        if ($numRows > 0) {
            echo "<div class='result-container'>";
            echo "<h2 class='result-title'>今天的所有預約資料 (共 {$numRows} 筆)：</h2>\n";
            echo "<table>";
            echo "<tr><th>車牌號碼</th><th>駕駛人姓名</th><th>電話</th><th>里程數</th><th>預約進場日</th><th>預約出場日</th><th>人數</th><th>出發航廈</th><th>回國航廈</th><th>回國抵台時間</th><th>停車位類型</th><th>備註</th><th>操作</th></tr>";
            while ($row = $resultAllReservations->fetch_assoc()) {
                echo "<tr>";
                echo "<td>{$row['LicensePlateNumber']}</td>";
                echo "<td>{$row['Name']}</td>";
                echo "<td>{$row['Phone']}</td>";
                echo "<td>{$row['Milage']}</td>";
                echo "<td>{$row['ReservationDayIn']}</td>";
                echo "<td>{$row['ReservationDayOut']}</td>";
                echo "<td>{$row['People']}</td>";
                echo "<td>{$row['DepartureTerminal']}</td>";
                echo "<td>{$row['ReturnTerminal']}</td>";
                echo "<td>{$row['ArrivalTime']}</td>";
                echo "<td>{$row['ParkingType']}</td>";
                echo "<td>{$row['Remasks']}</td>";
                echo "<td><button onclick='enterRecord(" . json_encode($row) . ")'>進場</button> ";
                echo "<button onclick='editRecord(" . json_encode($row) . ")'>修改</button>";
                echo "<button onclick='deleteRecord(" . json_encode($row) . ")'>刪除</button></td>";
                echo "</tr>\n";
            }
            echo "</table>";
            echo "</div>";
        } else {
            echo "<div class='result-container'>";
            echo "<p class='result-title'>今天沒有任何預約。</p>\n";
            echo "</div>";
        }
    } else {
        echo "<p style='color: red;'>查詢所有預約資料時出現問題：" . $conn->error . "</p>\n";
    }

    // 查詢今天已停車且預計離場的項目
    $queryParkings = "SELECT * FROM parking WHERE DATE(BackDay) = '$today'";
    $resultParkings = $conn->query($queryParkings);
    if ($resultParkings) {
        $numRows = $resultParkings->num_rows;
        if ($numRows > 0) {
            echo "<div class='result-container'>";
            echo "<h2 class='result-title'>今天預計離場的車輛 (共 {$numRows} 筆)：</h2>\n";
            echo "<table>";
            echo "<tr><th>姓名</th><th>車牌號碼</th><th>停車位</th><th>預計離場時間</th><th>操作</th></tr>";
            while ($row = $resultParkings->fetch_assoc()) {
                echo "<tr>";
                echo "<td>{$row['Name']}</td>";
                echo "<td>{$row['LicensePlateNumber']}</td>";
                echo "<td>{$row['ParkingNumber']}</td>";
                echo "<td>{$row['BackDay']}</td>";
                echo "<td><button onclick='editParkingRecord(" . json_encode($row) . ")'>修改資料</button> ";
                echo "<button onclick='exitRecord(" . htmlspecialchars(json_encode($row)) . ")'>離場結算</button></td>";
                echo "</tr>\n";
            }
            echo "</table>";
            echo "</div>";
        } else {
            echo "<div class='result-container'>";
            echo "<p class='result-title'>今天沒有預計離場的車輛。</p>\n";
            echo "</div>";
        }
    } else {
        echo "<p style='color: red;'>查詢停車狀況時出現問題：" . $conn->error . "</p>\n";
    }

    // 查詢停車位狀況
    $queryParkingNumbers = "SELECT DISTINCT description FROM parking_number";
    $resultParkingNumbers = $conn->query($queryParkingNumbers);
    if ($resultParkingNumbers) {
        // 動態生成停車位分類
        $categories = [];
        $totalSpaces = [];
        $occupiedSpaces = [];

        while ($rowParkingNumber = $resultParkingNumbers->fetch_assoc()) {
            $category = $rowParkingNumber['description'];
            $categories[$category] = [];
            $totalSpaces[$category] = 0;
            $occupiedSpaces[$category] = 0;
        }

        // 取得每個類別下的停車位
        $queryAllParkingSpaces = "SELECT * FROM parking_number";
        $resultAllParkingSpaces = $conn->query($queryAllParkingSpaces);

        while ($rowParkingSpace = $resultAllParkingSpaces->fetch_assoc()) {
            $category = $rowParkingSpace['description'];
            $parkingNumber = $rowParkingSpace['number'];
            $totalSpaces[$category]++;

            // 查詢該停車位的狀態
            $queryCurrentStatus = "SELECT LicensePlateNumber, Name, ParkingDay, BackDay FROM parking WHERE ParkingNumber = '$parkingNumber'";
            $resultCurrentStatus = $conn->query($queryCurrentStatus);
            $status = "可停車"; // 默認為可停車
            $name = "";
            $parkingday = "";
            $backday = "";
            if ($resultCurrentStatus && $resultCurrentStatus->num_rows > 0) {
                $rowCurrentStatus = $resultCurrentStatus->fetch_assoc();
                $status = $rowCurrentStatus['LicensePlateNumber']; // 顯示車牌
                $name = $rowCurrentStatus['Name']; // 顯示姓名
                $parkingday = $rowCurrentStatus['ParkingDay']; //進場時間
                $backday = $rowCurrentStatus['BackDay']; //預計離場時間
                $occupiedSpaces[$category]++;
            }
            $categories[$category][] = [
                'number' => $parkingNumber,
                'status' => $status,
                'name' => $name,
                'parkingday' => $parkingday,
                'backday' => $backday
            ];
        }

        // 顯示總覽統計
        echo "<div class='result-container overview-container'>";
        echo "<h2 class='result-title' onclick='toggleOverview()'>停車位總覽</h2>";
        echo "<div class='overview-content'>";
        echo "<table>";
        echo "<tr><th>類別</th><th>總數量</th><th>已停車數量</th><th>可停車數量</th></tr>";
        foreach ($totalSpaces as $category => $total) {
            $occupied = $occupiedSpaces[$category];
            $available = $total - $occupied;
            echo "<tr><td>{$category}</td><td>{$total}</td><td>{$occupied}</td><td>{$available}</td></tr>";
        }
        echo "</table>";
        echo "</div>";
        echo "</div>";

        // 顯示分類後的停車位狀況
        echo "<div class='result-container'>";
        echo "<h2 class='result-title'>今日停車狀況：</h2>\n";
        echo "<div class='status-container'>";
        echo "<div class='tab'>";
        foreach ($categories as $category => $items) {
            echo "<button class='tablinks' onclick='openTab(event, \"${category}\")'>{$category}</button>";
        }
        echo "</div>";

        foreach ($categories as $category => $items) {
            echo "<div id='{$category}' class='tab-content'>";
            echo "<table class='status-table'>";
            echo "<tr><th>停車位</th><th>狀態 / 車牌</th><th>姓名</th><th>進場日期</th><th>預計離場日期</th></tr>";
            foreach ($items as $item) {
                $class = $item['status'] == '可停車' ? 'available' : 'occupied';
                echo "<tr class='{$class}'>";
                echo "<td>{$item['number']}</td>";
                echo "<td>{$item['status']}</td>";
                echo "<td>{$item['name']}</td>";
                echo "<td>{$item['parkingday']}</td>";
                echo "<td>{$item['backday']}</td>";
                echo "</tr>";
            }
            echo "</table>";
            echo "</div>";
        }
        echo "</div>";
        echo "</div>";
    } else {
        echo "<p style='color: red;'>查詢停車位狀況時出現問題：" . $conn->error . "</p>\n";
    }

    // 關閉資料庫連線
    $conn->close();
    ?>

    <!-- JavaScript -->
    <script>
        // 定義修改記錄函數
        function editRecord(record) {
            var encodedRecord = encodeURIComponent(JSON.stringify(record));  // 確保整個資料被編碼
            window.location.href = "reservation.php?record=" + encodedRecord;
        }

        // 定義進場記錄函數
        function enterRecord(record) {
            var encodedRecord = encodeURIComponent(JSON.stringify(record));  // 確保整個資料被編碼
            window.location.href = "parking.php?record=" + encodedRecord;
        }

        // 定義停車修改函數
        function editParkingRecord(record) {
            var encodedRecord = encodeURIComponent(JSON.stringify(record));  // 確保整個資料被編碼
            window.location.href = "parking_edit.php?record=" + encodedRecord;
        }

        // 定義離場結算記錄函數
        function exitRecord(record) {
            var form = document.createElement('form');
            form.method = 'post';
            form.action = 'parking_exit.php';

            // 將記錄作為表單中的隱藏輸入
            var input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'record';
            input.value = JSON.stringify(record);  // 在這裡不需要進行 URL 編碼，因為這是 POST 提交
            form.appendChild(input);

            document.body.appendChild(form);
            form.submit();
        }

        // 顯示或隱藏停車位總覽
        function toggleOverview() {
            var content = document.querySelector('.overview-content');
            content.style.display = content.style.display === 'none' ? 'block' : 'none';
        }

        // 顯示選中的標籤頁
        function openTab(evt, category) {
            var i, tabcontent, tablinks;
            tabcontent = document.getElementsByClassName("tab-content");
            for (i = 0; i < tabcontent.length; i++) {
                tabcontent[i].style.display = "none";
            }
            tablinks = document.getElementsByClassName("tablinks");
            for (i = 0; i < tablinks.length; i++) {
                tablinks[i].className = tablinks[i].className.replace(" active", "");
            }
            document.getElementById(category).style.display = "block";
            evt.currentTarget.className += " active";
        }

        // 預設顯示第一個標籤頁
        document.addEventListener('DOMContentLoaded', function () {
            var firstTab = document.getElementsByClassName("tablinks")[0];
            firstTab.click();
        });
    </script>
</body>
</html>
