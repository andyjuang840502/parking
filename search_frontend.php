<!DOCTYPE html>
<html>
<head>
    <title>晶順停車場 預約登記查詢</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            background-image: url('background_image.jpg');
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
            background-color: rgba(255, 255, 255, 0.8);
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
            background-color: #4CAF50;
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
        .sort-arrow {
            margin-left: 5px;
            cursor: pointer;
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
        let sortDirection = { "ReservationDayIn": true, "ReservationDayOut": true }; // true: 升冪，false: 降冪

        $(document).ready(function() {
            $('#searchForm').submit(function(event) {
                event.preventDefault(); // 防止表單正常提交

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
                    html += "<tr><th>姓名</th><th>電話</th><th onclick='sortTable(\"ReservationDayIn\")'>預約進場日期 <span class='sort-arrow'>&#9650;</span></th><th>車牌號碼</th><th>里程數</th><th>人數</th><th onclick='sortTable(\"ReservationDayOut\")'>預約離場時間 <span class='sort-arrow'>&#9650;</span></th><th>備註</th><th>操作</th></tr>";
                    
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

        function sortTable(columnName) {
            const rows = Array.from(document.querySelectorAll('#searchResults table tr:not(:first-child)'));
            const direction = sortDirection[columnName] ? 1 : -1; // 升冪或降冪

            rows.sort((a, b) => {
                const cellA = a.querySelector(`td:nth-child(${columnName === 'ReservationDayIn' ? 3 : 7})`).innerText;
                const cellB = b.querySelector(`td:nth-child(${columnName === 'ReservationDayIn' ? 3 : 7})`).innerText;
                return (cellA > cellB ? 1 : -1) * direction;
            });

            // 清空現有的表格，並添加排序後的行
            const table = document.querySelector('#searchResults table');
            const tbody = table.querySelector('tbody') || document.createElement('tbody');
            tbody.innerHTML = '';
            rows.forEach(row => tbody.appendChild(row));

            // 如果表格沒有tbody，則創建一個
            if (!table.querySelector('tbody')) {
                table.appendChild(tbody);
            }

            // 更新表格
            table.appendChild(tbody);

            // 切換排序方向
            sortDirection[columnName] = !sortDirection[columnName];

            // 更新箭頭顯示
            const arrows = document.querySelectorAll('.sort-arrow');
            arrows.forEach(arrow => arrow.innerHTML = '&#9650;'); // 重設所有箭頭
            const index = columnName === 'ReservationDayIn' ? 2 : 6; // 判斷要顯示的箭頭
            arrows[index].innerHTML = sortDirection[columnName] ? '&#9650;' : '&#9660;'; // 根據排序方向顯示箭頭
        }

        function editRecord(record) {
            window.location.href = "reservation.php?record=" + encodeURIComponent(JSON.stringify(record));
        }

        function enterRecord(record) {
            window.location.href = "parking.php?record=" + encodeURIComponent(JSON.stringify(record));
        }

        function deleteRecord(id) {
            if (confirm('確定要刪除此預約嗎？')) {
                var xhr = new XMLHttpRequest();
                xhr.open("POST", "delete_reservation.php", true);
                xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                xhr.onload = function() {
                    if (xhr.status === 200) {
                        alert('預約已刪除');
                        location.reload();
                    } else {
                        alert('刪除失敗');
                    }
                };
                xhr.send("id=" + encodeURIComponent(id));
            }
        }
    </script>
</body>
</html>
