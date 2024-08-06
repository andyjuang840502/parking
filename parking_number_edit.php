<?php
// 如果是修改的表單提交
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $edit_number = $_POST["edit_number"];
    $edit_description = $_POST["edit_description"];
    
    // 更新資料庫中的停車位資料
    $sql_update = "UPDATE parking_number SET description='$edit_description' WHERE number='$edit_number'";

    require_once "config.php";

    $conn = new mysqli($servername, $username, $password, $database);

    if ($conn->connect_error) {
        die("連接失敗: " . $conn->connect_error);
    }

    if ($conn->query($sql_update) === TRUE) {
        header("Location: index.php"); // 返回首頁或列表頁
        exit();
    } else {
        echo "錯誤: " . $sql_update . "<br>" . $conn->error;
    }

    $conn->close();
}

// 如果是顯示要修改的停車位表單
if (isset($_GET["number"])) {
    $edit_number = $_GET["number"];

    require_once "config.php";

    $conn = new mysqli($servername, $username, $password, $database);

    if ($conn->connect_error) {
        die("連接失敗: " . $conn->connect_error);
    }

    $sql_select = "SELECT number, description FROM parking_number WHERE number='$edit_number'";
    $result = $conn->query($sql_select);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $edit_number = $row["number"];
        $edit_description = $row["description"];
    } else {
        echo "找不到要編輯的停車位";
        exit();
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>修改停車位</title>
</head>
<body>
    <h2>修改停車位</h2>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <input type="hidden" name="edit_number" value="<?php echo $edit_number; ?>">
        停車位號碼：<input type="text" name="edit_number" value="<?php echo $edit_number; ?>" disabled><br>
        描述：<input type="text" name="edit_description" value="<?php echo $edit_description; ?>" required><br>
        <input type="submit" value="更新">
    </form>
</body>
</html>
