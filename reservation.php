
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
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
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
        <input type="date" name="exit_time" id="exit_time"><br><br>
        
        <label for="remarks">備註 (Remasks)：</label>
        <input type="text" name="remasks" id="remasks"><br><br>
        
        <input type="submit" name="submit" value="提交">
        <input type="button" value="測試" onclick="test()">
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

        function test(){
            $.ajax({
                url: "test.php",
                method:'POST',
                // dataType:"text",
                dataType:"json",
                data: {
                    testCode: $('#name').val()
                },
                //dataType:"text",
                dataType:"json",
                success: function(result) {
                    $('#remasks').val(result);
                }
                });
        }
    </script>

    <?php
    // 確認是否有提交表單
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // 包含配置檔
        require_once "config.php";

        // 創建連接
        $conn = new mysqli($servername, $username, $password, $database);

        // 檢查連接是否成功
        if ($conn->connect_error) {
            die("連接失敗：" . $conn->connect_error);
        }

        // 獲取表單數據
        $name = $_POST["name"];
        $phone = $_POST["phone"];
        $license_plate = $_POST["license_plate"];
        $mileage = $_POST["mileage"];
        $people_count = $_POST["people_count"];
        $entry_time = $_POST["entry_time"];
        $exit_time = $_POST["exit_time"];
        $remasks = $_POST["remasks"];

        // SQL 插入語句
        if (strtotime($entry_time) <= time()) {
            echo '<script>alert("預約進場時間不能是過去時間！");</script>';
        } else {
            // SQL 插入語句
            $sql = "INSERT INTO reservation (Name, Phone, LicensePlateNumber, ReservationDayIn, Milage, People, ReservationDayOut, Remasks) 
                    VALUES ('$name', '$phone', '$license_plate', '$entry_time', '$mileage', '$people_count', '$exit_time', '$remarks')";
    
            // 執行 SQL 插入語句
            if ($conn->query($sql) === TRUE) {
                echo '<script>alert("預約成功！");</script>';
            } else {
                echo "錯誤：" . $sql . "<br>" . $conn->error;
            }
        }

        // 關閉連接
        $conn->close();
    }
    ?>
</body>
</html>