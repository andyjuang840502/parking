<?php
// 包含 PHP Spreadsheet 的自動加載文件
require_once 'C:/composer/vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;

// 檢查是否收到有效的 POST 數據
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['record'])) {
    // 解析 POST 過來的 JSON 數據
    $record = json_decode($_POST['record'], true);
    
    // 如果成功解析數據
    if ($record) {
        // 創建新的 Excel 對象
        $spreadsheet = new Spreadsheet();

        // 設置 Excel 頁面屬性
        $spreadsheet->getProperties()->setCreator("Your Name")
                                     ->setLastModifiedBy("Your Name")
                                     ->setTitle("停車場離場報表")
                                     ->setSubject("停車場離場報表")
                                     ->setDescription("停車場離場報表")
                                     ->setKeywords("停車場, 離場, 報表")
                                     ->setCategory("報表");

        // 添加一個工作表
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('報表');

        // 寫入數據到 Excel 中，使用繁體中文
        $sheet->setCellValue('A1', '姓名');
        $sheet->setCellValue('B1', '連絡電話');
        $sheet->setCellValue('C1', '車牌號碼');
        $sheet->setCellValue('D1', '進場時間');
        $sheet->setCellValue('E1', '回國時間');
        $sheet->setCellValue('F1', '停車位');
        $sheet->setCellValue('G1', '估算費用');
        $sheet->setCellValue('H1', '備註');
        $sheet->setCellValue('I1', '中間日期');

        // 將收到的數據寫入 Excel
        $sheet->setCellValue('A2', htmlspecialchars($record['Name']));
        $sheet->setCellValue('B2', htmlspecialchars($record['Phone']));
        $sheet->setCellValue('C2', htmlspecialchars($record['LicensePlateNumber']));
        $sheet->setCellValue('D2', htmlspecialchars($record['ParkingDay']));
        $sheet->setCellValue('E2', htmlspecialchars($record['BackDay']));
        $sheet->setCellValue('F2', htmlspecialchars($record['ParkingNumber']));
        $sheet->setCellValue('G2', htmlspecialchars(100)); // 這裡的費用暫時使用固定值，你可以根據需求設置動態計算
        $sheet->setCellValue('H2', htmlspecialchars($record['Remarks']));

        // 計算中間的日期範圍，並將日期以繁體中文格式輸出
        $parkingStartDate = new DateTime($record['ParkingDay']);
        $backDate = new DateTime($record['BackDay']);
        $currentDate = clone $parkingStartDate;
        $row = 2;

        while ($currentDate <= $backDate) {
            $row++;
            $sheet->setCellValue('I' . $row, $currentDate->format('Y年m月d日')); // 使用繁體中文格式輸出日期
            $currentDate->modify('+1 day');
        }

        // 設置 Excel 外觀格式等
        $sheet->getStyle('A1:I1')->getFont()->setBold(true);
        $sheet->getStyle('A1:I1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A1:I1')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('f2f2f2');

        // 設置列寬自適應
        foreach(range('A','I') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }

        // 輸出 Excel 文件
        $filename = '停車場報表_' . date('YmdHis') . '.xlsx'; // 文件名可以自定義，這裡添加了時間戳以確保唯一性
        $encoded_filename = rawurlencode($filename);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment; filename*=UTF-8''" . $encoded_filename);
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->setUseBOM(true); // 添加 BOM 头，确保 UTF-8 编码
        $writer->save('php://output');

        exit;
    } else {
        echo "<p>無法解析收到的資料。</p>";
    }
} else {
    echo "<p>沒有收到有效的資料。</p>";
}
?>
