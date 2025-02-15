<!DOCTYPE html>
<html>
<head>
    <title>晶順停車場 停車登記</title>
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
            background-color: #4CAF50; /* 添加吸按鈕顏色 */
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
</head>
<body>
    <h2>停車登記表單</h2>
    <form id="parkingForm" method="post">

        <label for="ID">聯單編號 (ID)：</label>
        <input type="text" name="ID" id="ID" required>
        <span class="required">*</span>
        <span class="tooltip">
            <span class="tooltiptext">此為必填欄位</span>
        </span><br><br>
      
        <label for="name">駕駛人 (Name)：</label>
        <input type="text" name="name" id="name" required>
        <span class="required">*</span>
        <span class="tooltip">
            <span class="tooltiptext">此為必填欄位</span>
        </span><br><br>
        
        <label for="phone">連絡電話 (Phone)：</label>
        <input type="text" name="phone" id="phone" required>
        <span class="required">*</span>
        <span class="tooltip">
            <span class="tooltiptext">此為必填欄位</span>
        </span><br><br>
        
        <label for="license_plate">車牌 (LicensePlateNumber)：</label>
        <input type="text" name="license_plate" id="license_plate" required>
        <span class="required">*</span>
        <span class="tooltip">
            <span class="tooltiptext">此為必填欄位</span>
        </span><br><br>

        <label for="milage">里程數 (Milage)：</label>
        <input type="text" name="milage" id="milage"><br><br>

        <label for="parking_number">停車位 (ParkingNumber)：</label>
        <select name="parking_number" id="parking_number" required>
            <option value="">選擇停車位</option>
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
            $sql_select = "SELECT number, description FROM parking_number ORDER BY description";
            $result = $conn->query($sql_select);

            $current_category = ""; // 用於跟蹤當前分類

            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    // 如果分類變了，加入一個分類的選項
                    if ($row["description"] !== $current_category) {
                        // 如果已經有一個分類了，先結束這個分類的optgroup
                        if ($current_category !== "") {
                            echo "</optgroup>";
                        }
                        // 開始新的分類
                        echo "<optgroup label='" . $row["description"] . "'>";
                        $current_category = $row["description"];
                    }
                    // 顯示停車位選項
                    echo "<option value='" . $row["number"] . "'>" . $row["number"] . "</option>";
                }
                // 結束最後一個分類的optgroup
                echo "</optgroup>";
            } else {
                echo "<option value=''>沒有可用的停車位</option>";
            }

            
            $conn->close();
            ?>
        </select>
        <span class="required">*</span>
        <span class="tooltip">
            <span class="tooltiptext">此為必填欄位</span>
        </span>

        <!--
        <input type="hidden" name="parking_type" id="parking_type" value="<?php echo isset($_GET['parking_type']) ? $_GET['parking_type'] : ''; ?>">
        <p>預約時選擇的停車位類型為：
            <?php 
                if (isset($_GET['parking_type'])) {
                    $parkingType = $_GET['parking_type'];
                    // 現在你可以使用 $parkingType 變數
                    echo htmlspecialchars($parkingType);
                } ?>
        </p>
        <br><br> 
            -->
            <label for="parking_type">預約時選擇的停車位類型為：</label>
            <select name="parking_type" id="parking_type">
                <option value="">選擇停車位類型</option>
                <?php
                // 連接到 MySQL 伺服器
                require_once "config.php";

                // 創建連接
                $conn = new mysqli($servername, $username, $password, $database);

                // 檢查連接是否成功
                if ($conn->connect_error) {
                    die("連接失敗: " . $conn->connect_error);
                }

                // 查詢資料庫中的停車位類型資料
                $sql_select = "SELECT DISTINCT description FROM parking_number ORDER BY description";
                $result = $conn->query($sql_select);

                if ($result->num_rows > 0) {
                    // 讀取每一條記錄並顯示在選單中
                    while($row = $result->fetch_assoc()) {
                        echo "<option value='" . $row["description"] . "'>" . $row["description"] . "</option>";
                    }
                } else {
                    echo "<option value=''>沒有可用的停車位類型</option>";
                }

                // 關閉連接
                $conn->close();
                ?>
            </select>


        <label for="parking_day">進場日期 (ParkingDay)：</label>
        <input type="datetime-local" name="parking_day" id="parking_day">
        <span class="required">*</span>
        <span class="tooltip">
            <span class="tooltiptext">此為必填欄位</span>
        </span><br><br>

        <label for="emigrantiot">出境航廈 (Emigrantiot)：</label>
        <select name="emigrantiot" id="emigrantiot">
            <option value="第一航廈">第一航廈</option>
            <option value="第二航廈">第二航廈</option>
            <option value="第二航廈">第三航廈</option>
        </select><br><br>

        <label for="emigrantio_people">出境人數 (EmigrantioPeople)：</label>
        <input type="number" name="emigrantio_people" id="emigrantio_people"><br><br>

        <label for="immigration">入境航廈 (Immigration)：</label>
        <select name="immigration" id="immigration">
            <option value="第一航廈">第一航廈</option>
            <option value="第二航廈">第二航廈</option>
            <option value="第二航廈">第三航廈</option>
        </select><br><br>

        <label for="immigration_people">入境人數 (ImmigrationPeople)：</label>
        <input type="number" name="immigration_people" id="immigration_people"><br><br>

        <label for="back_day">回國日期及時間 (BackDay)：</label>
        <input type="datetime-local" name="back_day" id="back_day">
        <span class="required">*</span>
        <span class="tooltip">
            <span class="tooltiptext">此為必填欄位</span>
        </span><br><br>

        <label for="big_package">行李件數(大) (BigPackage)：</label>
        <input type="number" name="big_package" id="big_package"><br><br>

        <label for="small_package">行李件數(小) (SmallPackage)：</label>
        <input type="number" name="small_package" id="small_package"><br><br>

        <label for="ball_tool">球具 (BallTool)：</label>
        <input type="text" name="ball_tool" id="ball_tool"><br><br>

        <label for="ski_board">滑雪(衝浪)版 (SkiBoard)：</label>
        <input type="text" name="ski_board" id="ski_board"><br><br>

        <label for="other_object">其他物件 (OtherObject)：</label>
        <input type="text" name="other_object" id="other_object"><br><br>

        
        <label for="remarks">備註 (Remasks)：</label>
        <input type="text" name="remasks" id="remasks"><br><br>
        <br><br>
        <!-- 隱藏的流水號欄位 -->
        <input type="hidden" name="number" id="number" value="<?php echo isset($_GET['number']) ? $_GET['number'] : ''; ?>">

        <input type="submit" name="submit" value="提交">
    </form>

    <script>
        $(document).ready(function() {
            // 獲取今天的日期和時間
            var now = new Date();
            var year = now.getFullYear();
            var month = (now.getMonth() + 1).toString().padStart(2, '0');
            var day = now.getDate().toString().padStart(2, '0');
            var hour = now.getHours().toString().padStart(2, '0');
            var minute = now.getMinutes().toString().padStart(2, '0');

            // 構造日期時間字符串（格式為YYYY-MM-DDTHH:MM，如2024-06-05T10:30）
            var defaultDateTime = year + '-' + month + '-' + day + 'T' + hour + ':' + minute;

            // 將默認日期時間設置到進場日期欄位
            $('#parking_day').val(defaultDateTime);
            
            $('#parkingForm').submit(function(event) {
                event.preventDefault(); // 防止表單正常提交

                // 使用 AJAX 發送資料給伺服器
                $.ajax({
                    url: "process_parking.php", 
                    method: 'POST',
                    dataType: "json",
                    data: $(this).serialize(),
                    success: function(result) {
                        alert(result.message); // 顯示結果給使用者
                        if (result.success) {
                            $('#parkingForm')[0].reset(); // 清空表單
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
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
                //$('#entry_time').val(record.ReservationDayIn);
                $('#milage').val(record.Milage);
                $('#emigrantio_people').val(record.People);
                //$('#back_day').val(record.ReservationDayOut);
                $('#remasks').val(record.Remasks);
                $('#number').val(record.Number);
                $('#emigrantiot').val(record.DepartureTerminal);
                $('#imigrantiot').val(record.ReturnTerminal);
                $('#back_day').val(record.ArrivalTime);
                $('#parking_type').val(record.ParkingType);
                
            }
        });

    </script>
</body>
</html>
