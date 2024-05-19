<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>晶順停車場 預約停車</title>
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
        form {
            max-width: 400px;
            margin: 0 auto;
            background-color: rgba(255, 255, 255, 0.8); /* 調整表單背景色 */
            padding: 20px;
            border-radius: 10px;
        }
        label {
            display: block;
            margin-bottom: 10px;
            font-weight: bold;
        }
        input[type="text"],
        input[type="date"],
        input[type="number"],
        input[type="submit"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }
        input[type="submit"] {
            background-color: #4CAF50; /* 添加吸引人的按鈕顏色 */
            color: white;
            border: none;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
        }
        .required {
            color: red;
        }
        .tooltip {
            position: relative;
            display: inline-block;
        }
        .tooltip .tooltiptext {
            visibility: hidden;
            width: 120px;
            background-color: #555;
            color: #fff;
            text-align: center;
            border-radius: 6px;
            padding: 5px;
            position: absolute;
            z-index: 1;
            bottom: 125%;
            left: 50%;
            margin-left: -60px;
            opacity: 0;
            transition: opacity 0.3s;
        }
        .tooltip:hover .tooltiptext {
            visibility: visible;
            opacity: 1;
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
</head>
<body>
    <h2>請輸入預約資料</h2>
    <form id="reservationForm" autocomplete="off">
        <label for="name">姓名 (Name)：<span class="required">*</span></label>
        <input type="text" name="name" id="name" required>
        <div class="tooltip"><span class="tooltiptext">此為必填欄位</span></div>
        
        <label for="phone">電話 (Phone)：<span class="required">*</span></label>
        <input type="text" name="phone" id="phone" required>
        <div class="tooltip"><span class="tooltiptext">此為必填欄位</span></div>
        
        <label for="license_plate">車牌號碼 (LicensePlateNumber)：<span class="required">*</span></label>
        <input type="text" name="license_plate" id="license_plate" required>
        <div class="tooltip"><span class="tooltiptext">此為必填欄位</span></div>
        
        <label for="entry_time">預約進場時間 (ReservationDayIn)：<span class="required">*</span></label>
        <input type="date" name="entry_time" id="entry_time" required>
        <div class="tooltip"><span class="tooltiptext">此為必填欄位</span></div>
        
        <label for="mileage">里程數 (Milage)：</label>
        <input type="text" name="mileage" id="mileage">
        
        <label for="people_count">人數 (People)：</label>
        <input type="number" name="people_count" id="people_count">
        
        <label for="exit_time">預約離場時間 (ReservationDayOut)：<span class="required">*</span></label>
        <input type="date" name="exit_time" id="exit_time" required>
        <div class="tooltip"><span class="tooltiptext">此為必填欄位</span></div>
        
        <label for="remarks">備註 (Remarks)：</label>
        <input type="text" name="remarks" id="remarks">
        
        <input type="submit" name="submit" value="提交">
    </form>

    <script>
        $(document).ready(function() {
            // 當表單提交時觸發
            $('#reservationForm').submit(function(event) {
                event.preventDefault(); // 防止表單正常提交

                // 使用 AJAX 發送資料給伺服器
                $.ajax({
                    url: "process_reservation.php", 
                    method: 'POST',
                    dataType: "json",
                    data: $(this).serialize(),
                    success: function(result) {
                        // 根據伺服器返回的結果進行處理
                        alert(result.message); // 可以使用 alert() 或其他方式顯示結果給使用者
                        if
