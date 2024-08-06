<!DOCTYPE html>
<html>
<head>
    <title>晶順停車場 停車查詢總表</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="style.css"> <!-- 引入外部 CSS 檔案 -->
    <style>
        .toggle-arrow {
            cursor: pointer;
        }
        .table-container {
            margin-bottom: 20px;
        }
        .arrow-down {
            display: none;
        }
        .arrow-down.show {
            display: inline-block;
        }
        .arrow-up.show {
            display: none;
        }
    </style>
</head>
<body>
<?php
// 包含資料庫連接文件
require_once "config.php";

// 創建到數據庫的連接
$conn = new mysqli($servername, $username, $password, $database);

// 檢查連接是否成功
if ($conn->connect_error) {
    die("連接失敗: " . $conn->connect_error);
}

// 檢查是否有收到日期的 GET 參數
if (isset($_GET['date'])) {
    //$search_date = $_GET['date'];
    $search_date = date('Y-m-d', strtotime($_GET['date']));

    // 預設的 SQL 查詢 - reservation 表
    $sql_reservation = "SELECT * FROM reservation WHERE DATE(ReservationDayIn) <= ? AND DATE(ReservationDayOut) >= ?";
    $stmt_reservation = $conn->prepare($sql_reservation);
    $stmt_reservation->bind_param("ss", $search_date, $search_date);
    $stmt_reservation->execute();
    $result_reservation = $stmt_reservation->get_result();

    // 檢查是否查詢成功 - reservation 表
    if ($result_reservation === false) {
        echo "查詢失敗: " . $conn->error;
        exit; // 終止腳本執行
    }

    // 顯示 reservation 表格
    if ($result_reservation->num_rows > 0) {
        echo "<div class='toggle-arrow' onclick='toggleTable(\"reservation-table\")'>";
        echo "<span>$search_date 的預約查詢結果</span> ";
        echo "<span class='arrow-up show'>&#9650;</span>";
        echo "<span class='arrow-down'>&#9660;</span>";
        echo "</div>";
        echo "<div id='reservation-table' class='table-container'>";
        echo "<table border='1'>";
        echo "<thead><tr><th>姓名</th><th>電話</th><th>預約進場日期</th><th>車牌號碼</th><th>里程數</th><th>人數</th><th>預約離場時間</th><th>備註</th><th>操作</th></tr></thead>";
        echo "<tbody>";
        while ($row = $result_reservation->fetch_assoc()) {
            echo "<tr>";
            echo "<td class='column-width'>" . htmlspecialchars($row['Name']) . "</td>";
            echo "<td class='column-width'>" . htmlspecialchars($row['Phone']) . "</td>";
            echo "<td class='column-width'>" . htmlspecialchars($row['ReservationDayIn']) . "</td>";
            echo "<td class='column-width'>" . htmlspecialchars($row['LicensePlateNumber']) . "</td>";
            echo "<td class='column-width'>" . htmlspecialchars($row['Milage']) . "</td>";
            echo "<td class='column-width'>" . htmlspecialchars($row['People']) . "</td>";
            echo "<td class='column-width'>" . htmlspecialchars($row['ReservationDayOut']) . "</td>";
            echo "<td class='column-width resizable'>" . htmlspecialchars($row['Remasks']) . "</td>";
            echo "<td class='column-width'>";
            echo "<button onclick='enterRecord(" . json_encode($row) . ")'>進場</button> ";
            echo "<button onclick='editRecord(" . json_encode($row) . ")'>修改</button> ";
            echo "<button onclick='deleteRecord(" . json_encode($row) . ")'>刪除</button>";
            echo "</td>";
            echo "</tr>";
        }
        echo "</tbody></table>";
        echo "</div>";
    } else {
        echo "<p>查無相關預約資料</p>";
    }

    // 釋放 reservation 結果集
    $result_reservation->free();

    // SQL 查詢 - parking 表
    $sql_parking = "SELECT * FROM parking WHERE DATE(ParkingDay) <= ? AND DATE(BackDay) >= ?";
    $stmt_parking = $conn->prepare($sql_parking);
    $stmt_parking->bind_param("ss", $search_date, $search_date);
    $stmt_parking->execute();
    $result_parking = $stmt_parking->get_result();

    // 檢查是否查詢成功 - parking 表
    if ($result_parking === false) {
        echo "查詢失敗: " . $conn->error;
        exit; // 終止腳本執行
    }

    // 顯示 parking 表格
    if ($result_parking->num_rows > 0) {
        $cost = 100;
        echo "<div class='toggle-arrow' onclick='toggleTable(\"parking-table\")'>";
        echo "<span>$search_date 的停車記錄查詢結果</span> ";
        echo "<span class='arrow-up show'>&#9650;</span>";
        echo "<span class='arrow-down'>&#9660;</span>";
        echo "</div>";
        echo "<div id='parking-table' class='table-container'>";
        echo "<table border='1'>";
        echo "<thead><tr><th>聯單編號</th><th>姓名</th><th>連絡電話</th><th>車牌號碼</th><th>里程數</th><th>停車位</th><th>進場時間</th><th>回國時間</th><th>出境航廈</th><th>出境人數</th><th>入境航廈</th><th>入境人數</th><th>行李件數(大)</th><th>行李件數(小)</th><th>球具</th><th>滑雪(衝浪)板</th><th>其他物件</th><th>費用估算</th><th>備註</th><th>操作</th></tr></thead>";
        echo "<tbody>";
        while ($row = $result_parking->fetch_assoc()) {
            echo "<tr>";
            echo "<td class='column-width'>" . htmlspecialchars($row['ID']) . "</td>";
            echo "<td class='column-width'>" . htmlspecialchars($row['Name']) . "</td>";
            echo "<td class='column-width'>" . htmlspecialchars($row['Phone']) . "</td>";
            echo "<td class='column-width'>" . htmlspecialchars($row['LicensePlateNumber']) . "</td>";
            echo "<td class='column-width'>" . htmlspecialchars($row['Milage']) . "</td>";
            echo "<td class='column-width'>" . htmlspecialchars($row['ParkingNumber']) . "</td>";
            echo "<td class='column-width'>" . htmlspecialchars($row['ParkingDay']) . "</td>";
            echo "<td class='column-width'>" . htmlspecialchars($row['BackDay']) . "</td>";
            echo "<td class='column-width'>" . htmlspecialchars($row['Emigrantiot']) . "</td>";
            echo "<td class='column-width'>" . htmlspecialchars($row['EmigrantiotPeople']) . "</td>";
            echo "<td class='column-width'>" . htmlspecialchars($row['Immigration']) . "</td>";
            echo "<td class='column-width'>" . htmlspecialchars($row['ImmigrationPeople']) . "</td>";
            echo "<td class='column-width'>" . htmlspecialchars($row['BigPackage']) . "</td>";
            echo "<td class='column-width'>" . htmlspecialchars($row['SmallPackage']) . "</td>";
            echo "<td class='column-width'>" . htmlspecialchars($row['BallTool']) . "</td>";
            echo "<td class='column-width'>" . htmlspecialchars($row['SkiBoard']) . "</td>";
            echo "<td class='column-width'>" . htmlspecialchars($row['OtherObject']) . "</td>";
            echo "<td class='column-width'>" . $cost . "</td>";
            echo "<td class='column-width resizable'>" . htmlspecialchars($row['Remasks']) . "</td>";
            echo "<td class='column-width'>";
            echo "<button onclick='editParkingRecord(" . json_encode($row) . ")'>修改資料</button> ";
            echo "<button onclick='exitRecord(" . htmlspecialchars(json_encode($row)) . ")'>離場結算</button> ";
            echo "</td>";
            echo "</tr>";
        }
        echo "</tbody></table>";
        echo "</div>";
    } else {
        echo "<p>查無相關停車記錄資料</p>";
    }

    // 釋放 parking 結果集
    $result_parking->free();
} else {
    // 如果沒有收到日期的參數，顯示錯誤訊息或其他處理
    echo "查無相關資料";
}

// 關閉資料庫連接
$conn->close();
?>
<!-- JavaScript -->
<script>
    // 定義修改記錄函數
    function editRecord(record) {
        // 將記錄轉換為 JSON 格式，並將其作為查詢參數傳遞到 reservation.php
        window.location.href = "reservation.php?record=" + encodeURIComponent(JSON.stringify(record));
    }

    // 定義進場記錄函數
    function enterRecord(record) {
        // 將記錄轉換為 JSON 格式，並將其作為查詢參數傳遞到 parking.php
        window.location.href = "parking.php?record=" + encodeURIComponent(JSON.stringify(record));
    }

    // 定義停車修改函數
    function editParkingRecord(record) {
        // 將記錄轉換為 JSON 格式，並將其作為查詢參數傳遞到 parking.php
        window.location.href = "parking_edit.php?record=" + encodeURIComponent(JSON.stringify(record));
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
        input.value = JSON.stringify(record);
        form.appendChild(input);

        // 可以加入其他需要的表單數據

        // 將表單加入到文檔中並提交
        document.body.appendChild(form);
        form.submit();
    }

    // 定義刪除記錄函數
    function deleteRecord(record) {
        if (confirm('確定要刪除此預約嗎？')) {
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "delete_reservation.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onload = function() {
                if (xhr.status === 200) {
                    alert('預約已刪除');
                    location.reload(); // 刪除後重新載入頁面
                } else {
                    alert('刪除失敗');
                }
            };
            xhr.send("number=" + encodeURIComponent(record.Number));
        }
    }

    function toggleTable(tableId) {
        var table = document.getElementById(tableId);
        var arrowUp = table.previousElementSibling.querySelector('.arrow-up');
        var arrowDown = table.previousElementSibling.querySelector('.arrow-down');

        if (table.style.display === 'none' || table.style.display === '') {
            table.style.display = 'block';
            arrowUp.style.display = 'inline-block';
            arrowDown.style.display = 'none';
        } else {
            table.style.display = 'none';
            arrowUp.style.display = 'none';
            arrowDown.style.display = 'inline-block';
        }
    }
</script>
</body>
</html>
