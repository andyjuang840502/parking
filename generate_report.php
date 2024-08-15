<?php
// 包含 PHP Spreadsheet 的自動加載文件
require_once 'C:/composer/vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Font;

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
        $backDate = new DateTime(); // 當下的時間
        $diff = $backDate->diff($parkingStartDate);
        $totalDays = $diff->days+1;

        // 其他費用，這裡可以從表單或其他地方獲取，這裡先假設為固定值
        $otherCost = isset($_POST['otherCost']) ? $_POST['otherCost'] : 0; // 使用者輸入的其他費用

        // 計算總計，包括每日費率和其他費用
        $totalCost = $cost * $totalDays + $otherCost;

        // 創建新的 Excel 對象
        $spreadsheet = new Spreadsheet();

        // 設置 Excel 頁面屬性
        $spreadsheet->getProperties()->setCreator("您的名字")
                                     ->setLastModifiedBy("您的名字")
                                     ->setTitle("停車場離場收據")
                                     ->setSubject("停車場離場收據")
                                     ->setDescription("停車場離場收據")
                                     ->setKeywords("停車場, 離場, 收據")
                                     ->setCategory("Receipt");

        // 添加一個工作表
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('收據');

        // 設置合併儲存格
        $sheet->mergeCells('C2:D2');

        // 寫入標題
        $sheet->setCellValue('C2', '晶順停車場 停車明細');
        $sheet->getStyle('C2')->getFont()->setBold(true)->setSize(26);
        $sheet->getStyle('C2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('C2')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('f2f2f2');

        
        // 寫入數據到 Excel 中
        $sheet->setCellValue('C3', '聯單編號：'); // 添加一個新的欄位
        $sheet->setCellValue('D3', htmlspecialchars($record['ID'])); // 將 ID 對應到這個新欄位
        $sheet->setCellValue('C4', '姓名：');
        $sheet->setCellValue('D4', htmlspecialchars($record['Name']));
        $sheet->setCellValue('C5', '聯絡電話：');
        $sheet->setCellValue('D5', htmlspecialchars($record['Phone']));
        $sheet->setCellValue('C6', '車牌號碼：');
        $sheet->setCellValue('D6', htmlspecialchars($record['LicensePlateNumber']));
        $sheet->setCellValue('C7', '進場時間：');
        $sheet->setCellValue('D7', htmlspecialchars($record['ParkingDay']));
        $sheet->setCellValue('C8', '離場時間：');
        $sheet->setCellValue('D8', $backDate->format('Y-m-d H:i:s')); // 當下的時間
        $sheet->setCellValue('C9', '停車位：');
        $sheet->setCellValue('D9', htmlspecialchars($record['ParkingNumber']));
        $sheet->setCellValue('C10', '其他費用：');
        $sheet->setCellValue('D10', htmlspecialchars($otherCost)); // 其他費用
        $sheet->setCellValue('C11', '每日費率：');
        $sheet->setCellValue('D11', htmlspecialchars($cost)); // 每日費率
        $sheet->setCellValue('C12', '停車天數：');
        $sheet->setCellValue('D12', htmlspecialchars($totalDays)); // 停車天數
        $sheet->setCellValue('C13', '總計(新台幣)：');
        $sheet->setCellValue('D13', "=D11*D12+D10"); // 總計(新台幣)公式
        $sheet->setCellValue('C14', '備註：');
        $sheet->setCellValue('D14', htmlspecialchars($record['Remasks']));

        // 設置 Excel 外觀格式等
        $sheet->getStyle('B3:D3')->getFont()->setBold(true); // 聯單編號欄位加粗
        $sheet->getStyle('C3:D14')->getFont()->setSize(16);
        $sheet->getStyle('C3:C14')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT); // 聯單編號居左對齊
        $sheet->getStyle('D3:D14')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT); // 其他數據居左對齊

        // 設置列寬
        $sheet->getColumnDimension('B')->setWidth(10); // 聯單編號欄位列寬
        $sheet->getColumnDimension('C')->setWidth(35);
        $sheet->getColumnDimension('D')->setWidth(40);

        // 加上粗外框
        $sheet->getStyle('C2:D14')->applyFromArray([
            'borders' => [
                'outline' => [
                    'borderStyle' => Border::BORDER_THICK,
                ],
            ],
        ]);

        // 設置 Excel 檔案名稱，包含相關資訊和時間戳
        $filename = '停車場收據_' . htmlspecialchars($record['Name']) . '_' . date('YmdHis') . '.xlsx'; // 文件名可以自定義，這裡添加了時間戳以確保唯一性
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment; filename=\"$filename\"");
        header('Cache-Control: max-age=0');

        // 儲存 Excel 檔案到輸出流
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
