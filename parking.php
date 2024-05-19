<!DOCTYPE html>
<html>
<head>
    <title>晶順停車場 停車登記</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
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
        
        <!-- 其他輸入欄位 -->

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
