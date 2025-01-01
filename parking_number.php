<?php
// 連接到 MySQL 伺服器
require_once "config.php";

// 創建連接
$conn = new mysqli($servername, $username, $password, $database);

// 檢查連接是否成功
if ($conn->connect_error) {
    die("連接失敗: " . $conn->connect_error);
}

// 查詢所有的停車位類別
$sql_select_categories = "SELECT DISTINCT description FROM parking_number";
$category_result = $conn->query($sql_select_categories);

// 準備停車位類別
$categories = [];
if ($category_result->num_rows > 0) {
    while($row = $category_result->fetch_assoc()) {
        $categories[] = $row['description'];
    }
}

// 處理新增停車位的 POST 請求
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $new_number = $_POST["new_number"];
    $new_description = $_POST["new_description"];
    
    // 插入新的停車位資料到資料庫
    $sql_insert = "INSERT INTO parking_number (number, description) VALUES ('$new_number', '$new_description')";

    if ($conn->query($sql_insert) === TRUE) {
        echo "<meta http-equiv='refresh' content='0'>";
    } else {
        echo "錯誤: " . $sql_insert . "<br>" . $conn->error;
    }
}

// 查詢資料庫中的停車位資料
$sql_select = "SELECT number, description FROM parking_number";
$result = $conn->query($sql_select);

// 組織停車位數據以便分組顯示
$parking_data = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $parking_data[$row['description']][] = $row;
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>停車位管理</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 20px;
        }
        h2, h3 {
            text-align: center;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #ccc;
        }
        th, td {
            padding: 10px;
            text-align: center;
        }
        th {
            background-color: #f2f2f2;
        }
        form {
            margin-bottom: 20px;
            text-align: center;
        }
        form input[type="text"], form input[type="submit"], form select {
            padding: 8px;
            margin-right: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        form input[type="submit"] {
            cursor: pointer;
            background-color: #4CAF50;
            color: white;
            border: none;
        }
        form input[type="submit"]:hover {
            background-color: #45a049;
        }
        .edit-link, .delete-link {
            text-decoration: none;
            color: #333;
            padding: 5px 10px;
            border-radius: 4px;
            border: 1px solid #ccc;
            margin-right: 5px;
        }
        .edit-link:hover, .delete-link:hover {
            background-color: #f2f2f2;
        }
        .tab {
            overflow: hidden;
            background-color: #007bff;
            border-radius: 5px 5px 0 0;
            margin-bottom: 20px;
        }
        .tab button {
            background-color: #007bff;
            border: none;
            outline: none;
            cursor: pointer;
            padding: 14px 16px;
            font-size: 16px;
            color: white;
            transition: background-color 0.3s;
        }
        .tab button:hover {
            background-color: #0056b3;
        }
        .tab-content {
            display: none;
            padding: 20px;
            border: 1px solid #007bff;
            border-top: none;
            background-color: #f0f0f0;
        }
        .tab-content table {
            width: 100%;
        }
        .active {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <h2>停車位管理</h2>

    <!-- 新增停車位表單 -->
    <h3>新增停車位</h3>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        停車位號碼：<input type="text" name="new_number" required>
        位置：
        <select name="new_description">
            <?php foreach ($categories as $category): ?>
                <option value="<?php echo $category; ?>"><?php echo $category; ?></option>
            <?php endforeach; ?>
        </select>
        <input type="submit" value="新增">
    </form>

    <!-- 動態生成停車位類別的 Tab -->
    <div class="tab">
        <?php foreach ($categories as $category): ?>
            <button class="tablinks" onclick="openTab(event, '<?php echo $category; ?>')"><?php echo $category; ?></button>
        <?php endforeach; ?>
    </div>

    <!-- 顯示停車位資料表格 -->
    <?php foreach ($categories as $category): ?>
        <div id="<?php echo $category; ?>" class="tab-content">
            <h3><?php echo $category; ?> 停車位</h3>
            <table>
                <thead>
                    <tr>
                        <th>停車位號碼</th>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (isset($parking_data[$category])): ?>
                        <?php foreach ($parking_data[$category] as $row): ?>
                            <tr>
                                <td><?php echo $row["number"]; ?></td>
                                <td>
                                    <a class='edit-link' href='parking_number_edit.php?number=<?php echo $row["number"]; ?>'>修改</a>
                                    <a class='delete-link' href='parking_number_delete.php?number=<?php echo $row["number"]; ?>' onclick='return confirm("確定要刪除這個停車位嗎？");'>刪除</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    <?php endforeach; ?>

    <script>
        function openTab(evt, tabName) {
            var i, tabcontent, tablinks;
            tabcontent = document.getElementsByClassName("tab-content");
            for (i = 0; i < tabcontent.length; i++) {
                tabcontent[i].style.display = "none";  
            }
            tablinks = document.getElementsByClassName("tablinks");
            for (i = 0; i < tablinks.length; i++) {
                tablinks[i].className = tablinks[i].className.replace(" active", "");
            }
            document.getElementById(tabName).style.display = "block";
            evt.currentTarget.className += " active";
        }

        // 默认显示第一个标签页
        document.querySelector(".tab button").click();
    </script>
</body>
</html>
