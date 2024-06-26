<!DOCTYPE html>
<html>
<head>
    <title>晶順停車場 預約登記查詢</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="style.css">
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
    <h2>預約登記查詢表單</h2>
    <form id="searchForm" method="post">
        <label for="name">姓名：</label>
        <input type="text" name="name" id="name"><br><br>
        
        <label for="date">預約日期：</label>
        <input type="date" name="date" id="date"><br><br>
        
        <label for="license_plate">車牌：</label>
        <input type="text" name="license_plate" id="license_plate"><br><br>
        
        <label for="phone">電話：</label>
        <input type="text" name="phone" id="phone"><br><br>
        
        <input type="submit" name="submit" value="查詢">
    </form>

    <div id="searchResults">
        <!-- 這裡顯示搜索結果 -->
    </div>

    <script>
        // 定義編輯記錄函數
        function editRecord(record) {
            // 將記錄轉換為 JSON 格式，並將其作為查詢參數傳遞到 reservation.php
            window.location.href = "reservation.php?record=" + encodeURIComponent(JSON.stringify(record));
        }

        // 定義進場記錄函數
        function enterRecord(record) {
            // 將記錄轉換為 JSON 格式，並將其作為查詢參數傳遞到 reservation.php
            window.location.href = "parking.php?record=" + encodeURIComponent(JSON.stringify(record));
        }
        /*
        function enterRecord(record) {
            // 將記錄轉換為 JSON 格式，並將其作為查詢參數傳遞到 parking.php
            $.ajax({
                type: 'POST',
                url: 'parking.php',
                data: record,
                dataType: 'json',
                success: function(response) {
                    alert(response.message); // 顯示結果給用戶
                    if (response.success) {
                        // 如果成功，重置表單
                        $('#parkingForm')[0].reset();
                    }
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error:', error);
                    console.log('Server response:', xhr.responseText); // 顯示伺服器回應的內容
                    alert('發生了一些問題，請稍後再試！'); // 或者顯示一個友好的錯誤訊息給用戶
                }
            });
        }
        */

        $(document).ready(function() {
            $('#searchForm').submit(function(event) {
                event.preventDefault(); // 防止表單正常提交

                // 使用 AJAX 發送數據給服務器
                $.ajax({
                    url: "search.php", 
                    method: 'POST',
                    dataType: "json",
                    data: $(this).serialize(),
                    success: function(data) {
                        displayResults(data);
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                    }
                });
            });

            function displayResults(data) {
                var html = "<h3>查詢結果</h3>";
                if (data.length > 0) {
                    html += "<table border='1'>";
                    // 表頭
                    html += "<tr><th>姓名</th><th>電話</th><th>預約進場日期</th><th>車牌號碼</th><th>里程數</th><th>人數</th><th>預約離場時間</th><th>備註</th></tr>";
                    // 遍歷每條結果並添加到表格中
                    data.forEach(function(item) {
                        html += "<tr id='row_" + item.ID + "' data-record='" + JSON.stringify(item) + "'>";
                        html += "<td>" + item.Name + "</td>";
                        html += "<td>" + item.Phone + "</td>";
                        html += "<td>" + item.ReservationDayIn + "</td>";
                        html += "<td>" + item.LicensePlateNumber + "</td>";
                        html += "<td>" + item.Milage + "</td>";
                        html += "<td>" + item.People + "</td>";
                        html += "<td>" + item.ReservationDayOut + "</td>";
                        html += "<td>" + item.Remasks + "</td>";
                        html += "<td><button onclick='enterRecord(" + JSON.stringify(item) + ")'>進場</button> <button onclick='editRecord(" + JSON.stringify(item) + ")'>修改</button> <button onclick='deleteRecord(" + item.ID + ")'>刪除</button></td>";
                        html += "</tr>";
                    });
                    html += "</table>";
                } else {
                    html += "<p>未找到匹配的預約記錄。</p>";
                }
                $('#searchResults').html(html);
            }
        });
    </script>
</body>
</html>
