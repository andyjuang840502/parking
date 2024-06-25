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
    $search_date = $_GET['date'];

    // 預設的 SQL 查詢
    $sql = "SELECT * FROM reservation WHERE ReservationDayIn LIKE '%$search_date%'";

    // 執行 SQL 查詢
    $result = $conn->query($sql);

    // 檢查是否查詢成功
    if ($result === false) {
        echo "查詢失敗: " . $conn->error;
        exit; // 終止腳本執行
    }

    // 檢查查詢結果
    if ($result->num_rows > 0) {
        // 如果有查詢到結果，顯示表格
        echo "<h2>Search Results</h2>";
        echo "<div class='table-container'>";
        echo "<table border='1'>";
        echo "<thead><tr><th>姓名</th><th>電話</th><th>預約進場日期</th><th>車牌號碼</th><th>里程數</th><th>人數</th><th>預約離場時間</th><th>備註</th><th>操作</th></tr></thead>";
        echo "<tbody>";

        // 遍歷每條結果並添加到表格中
        while ($row = $result->fetch_assoc()) {
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
            //echo "<button onclick='deleteRecord(" . $row['ID'] . ")'>刪除</button>";
            echo "</td>";
            echo "</tr>";
        }
        echo "</tbody></table>";
        echo "</table>";
    } else {
        // 如果查詢結果為空，顯示提示訊息
        echo "查無相關資料";
    }

    // 釋放結果集
    $result->free();
} else {
    // 如果沒有收到日期的參數，顯示錯誤訊息或其他處理
    echo "查無相關資料";
}

// 關閉資料庫連接
$conn->close();
?>

<!-- CSS 樣式 -->
<style>
.table-container {
    overflow-x: auto;
    margin-bottom: 20px;
}

.styled-table {
    width: 100%;
    border-collapse: collapse;
    border: 1px solid #ddd;
    background-color: #f3f3f3; /* 設置表格背景顏色 */
}

.styled-table thead th {
    background-color: #f2f2f2;
    border: 1px solid #ddd;
    padding: 10px;
    text-align: left;
}

.styled-table tbody td {
    border: 1px solid #ddd;
    padding: 10px;
    text-align: left;
    background-color: #ffffff; /* 設置內容背景顏色 */
}

.column-width {
    width: 150px; /* 設置固定寬度 */
    word-wrap: break-word; /* 斷詞，避免長字串超出單元格 */
}

.resizable {
    resize: both; /* 允許垂直和水平拉伸 */
    overflow: auto; /* 滾動條顯示 */
    min-width: 150px; /* 最小寬度 */
    max-width: 500px; /* 最大寬度 */
    min-height: 40px; /* 最小高度 */
    max-height: 200px; /* 最大高度 */
}
</style>

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
</script>