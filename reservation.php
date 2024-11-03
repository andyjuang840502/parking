<!DOCTYPE html>
<html>
<head>
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
        
        <!--
            <label for="mileage">里程數 (Milage)：</label>
            <input type="text" name="mileage" id="mileage"><br><br>
        -->

        <label for="people_count">人數 (People)：</label>
        <input type="number" name="people_count" id="people_count"><br><br>
        
        <label for="exit_time">預約離場時間 (ReservationDayOut)：</label>
        <input type="date" name="exit_time" id="exit_time" required>
        <span class="required">*</span>
        <span class="tooltip">
            <span class="tooltiptext">此為必填欄位</span>
        </span><br><br>

        <label for="departure_terminal">出發航廈 (Departure Terminal)：</label>
        <select name="departure_terminal" id="departure_terminal">
            <option value="">不選擇</option>
            <option value="第一航廈">第一航廈</option>
            <option value="第二航廈">第二航廈</option>
            <option value="第三航廈">第三航廈</option>
        </select><br><br>

        <label for="return_terminal">回國航廈 (Return Terminal)：</label>
        <select name="return_terminal" id="return_terminal">
            <option value="">不選擇</option>
            <option value="第一航廈">第一航廈</option>
            <option value="第二航廈">第二航廈</option>
            <option value="第三航廈">第三航廈</option>
        </select><br><br>

        <label for="arrival_time">回國抵台時間 (Arrival Time in Taiwan)：</label>
        <input type="date" name="arrival_time" id="arrival_time"><br><br>

        <label for="parking_type">停車位類型 (ParkingType)：</label>
        <select name="parking_type" id="parking_type" required>
            <option value="">選擇類型</option>
            <?php
            // 連接到 MySQL 伺服器
            require_once "config.php";

            // 創建連接
            $conn = new mysqli($servername, $username, $password, $database);

            // 檢查連接是否成功
            if ($conn->connect_error) {
                die("連接失敗: " . $conn->connect_error);
            }

            // 查詢資料庫中的停車位資料，按照描述分類顯示
            $sql_select = "SELECT DISTINCT description FROM parking_number ORDER BY description";
            $result = $conn->query($sql_select);

            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    // 顯示 description 的選項
                    echo "<option value='" . htmlspecialchars($row["description"]) . "'>" . htmlspecialchars($row["description"]) . "</option>";
                }
            } else {
                echo "<option value=''>沒有可用的停車位</option>";
            }

            $conn->close();
            ?>
        </select>
        <span class="required">*</span>
        
        

        
        <label for="remarks">備註 (Remasks)：</label>
        <input type="text" name="remasks" id="remasks"><br><br>
        <!-- 隱藏的流水號欄位 -->
        <input type="hidden" name="number" id="number" value="<?php echo isset($_GET['number']) ? $_GET['number'] : ''; ?>">
        
        <input type="submit" name="submit" value="提交">
    </form>

    <div id="error-message" style="color: red;"></div>

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
                    url: "process_reservation.php", 
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
                        // 如果出現錯誤，將錯誤訊息顯示在頁面上
                        $('#error-message').text("錯誤：" + xhr.responseText);
                    }
                });
            });
        });

        // 檢查是否有從搜索頁面傳遞過來的記錄數據
        $(document).ready(function() {
            // 檢查是否有從搜索頁面傳遞過來的記錄數據
            const urlParams = new URLSearchParams(window.location.search);
            const recordData = urlParams.get('record');
            if (recordData) {
                const record = JSON.parse(recordData);
                // 將記錄填入表單
                $('#name').val(record.Name);
                $('#phone').val(record.Phone);
                $('#license_plate').val(record.LicensePlateNumber);
                $('#entry_time').val(record.ReservationDayIn);
                //$('#mileage').val(record.Milage);
                $('#people_count').val(record.People);
                $('#exit_time').val(record.ReservationDayOut);
                $('#remasks').val(record.Remasks);
                $('#number').val(record.Number);
                $('#departure_terminal').val(record.DepartureTerminal);
                $('#return_terminal').val(record.ReturnTerminal);
                $('#arrival_timel').val(record.ArrivalTime);
                $('#parking_type').val(record.ParkingType);
            }
        });
    </script>
</body>
</html>
