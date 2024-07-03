<?php
// 包含資料庫配置檔案
require_once "config.php";

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// 確保資料是透過 POST 方法接收
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 從請求主體中解碼 JSON 資料
    $json_data = file_get_contents("php://input");
    $record = json_decode($json_data, true); // 解碼為關聯陣列

    if ($record && isset($record['ID'])) {
        // 提取停車記錄中的相關數據
        $id = $record['ID'];
        $name = $record['Name'];
        $license_plate = $record['LicensePlateNumber'];

        // 取得目前時間作為離場時間
        $exit_time = date("Y-m-d H:i:s");

        // 在這裡您可以進行需要的數據處理，例如更新數據庫中的離場時間，計算費用等操作

        // 以下示例將數據輸出為 Excel 文件

        // 創建新的 PhpSpreadsheet 物件
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // 設置列標題
        $sheet->setCellValue('A1', '聯單編號');
        $sheet->setCellValue('B1', '姓名');
        $sheet->setCellValue('C1', '車牌');
        $sheet->setCellValue('D1', 'ExitTime');

        // 設置資料行
        $sheet->setCellValue('A2', $id);
        $sheet->setCellValue('B2', $name);
        $sheet->setCellValue('C2', $license_plate);
        $sheet->setCellValue('D2', $exit_time);

        // 儲存為 Excel 2007 格式 (.xlsx)
        $filename = 'exit_data_' . date('Ymd') . '.xlsx';
        $writer = new Xlsx($spreadsheet);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        $writer->save('php://output');
        exit;
    } else {
        echo "接收到無效的資料或缺少必要的字段。";
    }
} else {
    echo "請使用 POST 方法訪問此頁面。";
}
?>
