<!DOCTYPE html>
<html>
<head>
    <title>晶順停車場 停車登記查詢</title>
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
    <h2>停車登記查詢表單</h2>
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
        $(document).ready(function() {
            $('#searchForm').submit(function(event) {
                event.preventDefault(); // 防止表單正常提交

                // 使用 AJAX 發送資料給伺服器
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
                    html += "<ul>";
                    data.forEach(function(item) {
                        html += "<li>" + item.Name + " - " + item.BackDay + " - " + item.LicensePlateNumber + " - " + item.Phone + "</li>";
                    });
                    html += "</ul>";
                } else {
                    html += "<p>未找到匹配的記錄。</p>";
                }
                $('#searchResults').html(html);
            }
        });
    </script>
</body>
</html>
