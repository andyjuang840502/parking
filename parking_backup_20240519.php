<!DOCTYPE html>
<html>
<head>
    <title>晶順停車場 停車登記</title>
</head>
<body>
    <h2>停車登記表單</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
    <label for="reservation_check">是否有預約過？</label>
        <input type="radio" name="reservation_check" value="yes" checked>是
        <input type="radio" name="reservation_check" value="no">否<br><br>

        <button type="button" onclick="checkReservation()">確認</button><br><br>

        <div id="reservation_plate" style="display:none;">
            <label for="reservation_plate_input">預約車牌：</label>
            <input type="text" name="reservation_plate_input" id="reservation_plate_input"><br><br>
        </div>
        <label for="number">聯單編號 (Number)：</label>
        <input type="text" name="number" id="number" required><br><br>
        
        <label for="name">駕駛人 (Name)：</label>
        <input type="text" name="name" id="name" required><br><br>
        
        <label for="phone">連絡電話 (Phone)：</label>
        <input type="text" name="phone" id="phone" required><br><br>
        
        <label for="license_plate">車牌 (LicensePlateNumber)：</label>
        <input type="text" name="license_plate" id="license_plate" required><br><br>

        <label for="milage">里程數 (Milage)：</label>
        <input type="text" name="milage" id="milage"><br><br>

        <label for="parking_number">停車位 (ParkingNumber)：</label>
        <input type="text" name="parking_number" id="parking_number"><br><br>

        <label for="emigrantiot">出境航廈 (Emigrantiot)：</label>
        <select name="emigrantiot" id="emigrantiot">
            <option value="第一航廈">第一航廈</option>
            <option value="第二航廈">第二航廈</option>
        </select><br><br>

        <label for="emigrantio_people">出境人數 (EmigrantioPeople)：</label>
        <input type="number" name="emigrantio_people" id="emigrantio_people"><br><br>

        <label for="immigration">入境航廈 (Immigration)：</label>
        <select name="immigration" id="immigration">
            <option value="第一航廈">第一航廈</option>
            <option value="第二航廈">第二航廈</option>
        </select><br><br>

        <label for="immigration_people">入境人數 (ImmigrationPeople)：</label>
        <input type="number" name="immigration_people" id="immigration_people"><br><br>

        <label for="back_day">回國日期及時間 (BackDay)：</label>
        <input type="datetime-local" name="back_day" id="back_day"><br><br>

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

        <label for="parking_day">進場日期 (ParkingDay)：</label>
        <input type="datetime-local" name="parking_day" id="parking_day"><br><br>
        
        <input type="submit" name="submit" value="提交">
    </form>
    <script>
        function checkReservation() {
            var reservation_check = document.querySelector('input[name="reservation_check"]:checked').value;
            if (reservation_check === "yes") {
                var license_plate = prompt("請輸入預約車牌：");
                if (license_plate != null && license_plate != "") {
                    // 發送 AJAX 請求
                    var xhr = new XMLHttpRequest();
                    xhr.onreadystatechange = function() {
                        if (this.readyState == 4 && this.status == 200) {
                            var data = JSON.parse(this.responseText);
                            if (data) {
                                document.getElementById("reservation_plate_input").value = data.LicensePlateNumber;
                                // 其他欄位類似填入
                            } else {
                                alert("未找到匹配的預約資訊。");
                            }
                        }
                    };
                    xhr.open("GET", "get_reservation_info.php?license_plate=" + license_plate, true);
                    xhr.send();
                }
            }
        }
    </script>

    <?php
    // 包含 MySQL 配置檔
    require_once "config.php";

    // 確認是否有提交表單
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // 創建連接
        $conn = new mysqli($servername, $username, $password, $database);

        // 檢查連接是否成功
        if ($conn->connect_error) {
            die("連接失敗：" . $conn->connect_error);
        }

        // 獲取表單數據
        $number = $_POST["number"];
        $name = $_POST["name"];
        $phone = $_POST["phone"];
        $license_plate = $_POST["license_plate"];
        $milage = $_POST["milage"];
        $parking_number = $_POST["parking_number"];
        $emigrantiot = $_POST["emigrantiot"];
        $emigrantio_people = $_POST["emigrantio_people"];
        $immigration = $_POST["immigration"];
        $immigration_people = $_POST["immigration_people"];
        $back_day = $_POST["back_day"];
        $big_package = $_POST["big_package"];
        $small_package = $_POST["small_package"];
        $ball_tool = $_POST["ball_tool"];
        $ski_board = $_POST["ski_board"];
        $other_object = $_POST["other_object"];
        $parking_day = $_POST["parking_day"];

        // SQL 插入語句
        $sql = "INSERT INTO parking (Number, Name, Phone, LicensePlateNumber, Milage, ParkingNumber, Emigrantiot, EmigrantioPeople, Immigration, ImmigrationPeople, BackDay, BigPackage, SmallPackage, BallTool, SkiBoard, OtherObject, ParkingDay) 
                VALUES ('$number', '$name', '$phone', '$license_plate', '$milage', '$parking_number', '$emigrantiot', '$emigrantio_people', '$immigration', '$immigration_people', '$back_day', '$big_package', '$small_package', '$ball_tool', '$ski_board', '$other_object', '$parking_day')";

        // 執行 SQL 插入語句
        if ($conn->query($sql) === TRUE) {
            echo '<script>alert("停車登記成功！");</script>';
        } else {
            echo "錯誤：" . $sql . "<br>" . $conn->error;
        }

        // 關閉連接
        $conn->close();
    }
    ?>
</body>
</html>