<!DOCTYPE html>
<html>
<head>
    <title>晶順停車場 預約停車</title>
    <style>
        .required {
            color: red;
            font-size: 20px;
            margin-left: 5px;
        }
        .tooltip {
            display: inline-block;
        }
        .tooltip .tooltiptext {
            visibility: hidden;
            width: 120px;
            background-color: #555;
            color: #fff;
            text-align: center;
            border-radius: 6px;
            padding: 5px 0;
            position: absolute;
            z-index: 1;
            top: -30px;
            left: 100%;
            margin-left: 5px;
            display: none;
        }
        .tooltip:hover .tooltiptext {
            visibility: visible;
            display: inline;
        }
    </style>
    <script src="jquery-3.7.1.min.js"></script>
</head>
<body>
    <h2>請輸入預約資料</h2>
    <form id="reservationForm" autocomplete="off">
        <label for="name">姓名 (Name)：</label>
        <input type="text" name="name" id="name" required>
        <span class="required">*</span>
        <span class="tooltip">
            <span class="tooltiptext">此為必填欄位</span>
        </span><br><br>
        
        <label for="phone">電話 (Phone)：</label>
        <input type="text" name="phone" id="phone" required>
        <span class="required">*</span>
        <span class="tooltip">
            <span class="tooltiptext">此為必填欄位</span>
        </span><br><br>
        
        <label for="license_plate">車牌號碼 (LicensePlateNumber)：</label>
        <input type="text" name="license_plate" id="license_plate" required>
        <span class="required">*</span>
        <span class="tooltip">
            <span class="tooltiptext">此為必填欄位</span>
        </span><br><br>
        
        <label for="entry_time">預約進場時間 (ReservationDayIn)：</label>
        <input type="date" name="entry_time" id="entry_time" required>
        <span class="required">*</span>
        <span class="tooltip">
            <span class="tooltiptext">此為必填欄位</span>
        </span><br><br>
        
        <label for="mileage">里程數 (Milage)：</label>
        <input type="text" name="mileage" id="mileage"><br><br>
        
        <label for="people_count">人數 (People)：</label>
        <input type="number" name="people_count" id="people_count"><br><br>
        
        <label for="exit_time">預約離場時間 (ReservationDayOut)：</label>
        <input type="date" name="exit_time" id="exit_time" required>
        <span class="required">*</span>
        <span class="tooltip">
            <span class="tooltiptext">此為必填欄位</span>
        </span><br><br>
        
        <label for="remarks">備註 (Remasks)：</label>
        <input type="text" name="remasks" id="remasks"><br><br>
        
        <input type="submit" name="submit" value="提交">
    </form>

    <script>
        document.querySelectorAll('.required').forEach(function(element) {
            var tooltip = element.nextElementSibling.querySelector('.tooltiptext');
            element.addEventListener('mouseover', function() {
                tooltip.style.display = 'inline';
            });
            element.addEventListener('mouseout', function() {
                tooltip.style.display = 'none';
            });
        });

        $(document).ready(function() {
        // 當表單提交時觸發
        $('#reservationForm').submit(function(event) {
            event.preventDefault(); // 防止表單正常提交

            // 使用 AJAX 發送資料給伺服器
            $.ajax({
                url: "process_reservation.php", // 您需要創建一個處理表單的 PHP 檔案
                method: 'POST',
                dataType: "json",
                data: $(this).serialize(),
                success: function(result) {
                    // 根據伺服器返回的結果進行處理
                    alert(result.message); // 可以使用 alert() 或其他方式顯示結果給使用者
                    if (result.success) {
                        // 如果預約成功，清空表單資料（延遲 500 毫秒）
                        setTimeout(function() {
                            $('#reservationForm')[0].reset();
                        }, 500);
                    }
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText); // 如果出現錯誤，可以在控制台中顯示錯誤訊息
                }
            });
        });
    });

    </script>
</body>
</html>
