<?php
// 包含 PHP Spreadsheet 的自動加載文件
require_once 'C:/composer/vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// 檢查是否收到有效的 POST 數據
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['record'])) {
    // 解析 POST 過來的 JSON 數據
    $record = json_decode($_POST['record'], true);
    
    // 如果成功解析數據
    if ($record) {
        // 連接到 MySQL 伺服器獲取每日費率
        require_once "config.php";
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

        // 計算停車天數
        $parkingStartDate = new DateTime($record['ParkingDay']);
        $backDate = new DateTime($record['BackDay']);
        $diff = $backDate->diff($parkingStartDate);
        $totalDays = $diff->days;

        // 其他費用，這裡可以從表單或其他地方獲取，這裡先假設為固定值
        $otherCost = isset($_POST['otherCost']) ? $_POST['otherCost'] : 0; // 使用者輸入的其他費用

        // 計算估算費用，包括每日費率和其他費用
        $totalCost = $cost * $totalDays + $otherCost;

        // 創建新的 Excel 對象
        $spreadsheet = new Spreadsheet();

        // 設置 Excel 頁面屬性
        $spreadsheet->getProperties()->setCreator("您的名字")
                                     ->setLastModifiedBy("您的名字")
                                     ->setTitle("停車場離場報表")
                                     ->setSubject("停車場離場報表")
                                     ->setDescription("停車場離場報表")
                                     ->setKeywords("停車場, 離場, 報表")
                                     ->setCategory("Report");

        // 添加一個工作表
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('報表');

        // 寫入數據到 Excel 中
        $sheet->setCellValue('A1', '姓名');
        $sheet->setCellValue('B1', '連絡電話');
        $sheet->setCellValue('C1', '車牌號碼');
        $sheet->setCellValue('D1', '進場時間');
        $sheet->setCellValue('E1', '回國時間');
        $sheet->setCellValue('F1', '停車位');
        $sheet->setCellValue('G1', '其他費用');
        $sheet->setCellValue('H1', '每日費率');
        $sheet->setCellValue('I1', '停車天數');
        $sheet->setCellValue('J1', '估算費用');
        $sheet->setCellValue('K1', '備註');

        // 將收到的數據寫入 Excel
        $sheet->setCellValue('A2', htmlspecialchars($record['Name']));
        $sheet->setCellValue('B2', htmlspecialchars($record['Phone']));
        $sheet->setCellValue('C2', htmlspecialchars($record['LicensePlateNumber']));
        $sheet->setCellValue('D2', htmlspecialchars($record['ParkingDay']));
        $sheet->setCellValue('E2', htmlspecialchars($record['BackDay']));
        $sheet->setCellValue('F2', htmlspecialchars($record['ParkingNumber']));
        $sheet->setCellValue('G2', htmlspecialchars($otherCost)); // 其他費用
        $sheet->setCellValue('H2', htmlspecialchars($cost)); // 每日費率
        $sheet->setCellValue('I2', htmlspecialchars($totalDays)); // 停車天數
        $sheet->setCellValue('J2', "=H2*I2+G2"); // 估算費用公式
        $sheet->setCellValue('K2', htmlspecialchars($record['Remasks']));

        // 設置 Excel 外觀格式等
        $sheet->getStyle('A1:K1')->getFont()->setBold(true);
        $sheet->getStyle('A1:K1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A1:K1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('f2f2f2');

        // 設置列寬自適應
        foreach(range('A','K') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }

        // 輸出 Excel 文件
        $filename = '停車場報表_' . date('YmdHis') . '.xlsx'; // 文件名可以自定義，這裡添加了時間戳以確保唯一性
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment; filename=\"$filename\"");
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');

        // 關閉資料庫連接
        $conn->close();

        exit;
    } else {
        echo "<p>無法解析收到的資料。</p>";
    }
} else {
    echo "<p>沒有收到有效的資料。</p>";
}
?>
