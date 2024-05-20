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
</head>
<body>
    <h2>停車登記表單</h2>
    <form id="parkingForm" method="post">
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
            var reservation_check = $('input[name="reservation_check"]:checked').val();
            if (reservation_check === "yes") {
                var license_plate = prompt("請輸入預約車牌：");
                if (license_plate != null && license_plate != "") {
                    // 發送 AJAX 請求
                    $.ajax({
                        type: 'GET',
                        url: 'get_reservation_info.php',
                        data: { license_plate: license_plate },
                        dataType: 'json',
                        success: function(data) {
                            if (data) {
                                $('#reservation_plate_input').val(data.LicensePlateNumber);
                                // 更新其他相關欄位
                            } else {
                                alert("未找到匹配的預約資訊。");
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error(xhr.responseText);
                        }
                    });
                }
            }
        }

        $(document).ready(function() {
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
    </script>
</body>
</html>
