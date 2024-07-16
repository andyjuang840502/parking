<?php
session_start();
require_once "config.php";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("連接失敗: " . $conn->connect_error);
}

// 如果 $_SESSION 中有 dailyRate，使用它；否則從數據庫中獲取
if (isset($_SESSION['dailyRate'])) {
    $dailyRate = $_SESSION['dailyRate'];
} else {
    $sql = "SELECT daily_rate FROM price";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $dailyRate = $row["daily_rate"];
        }
    } else {
        $dailyRate = "未設定費用";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>每日費率</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        form {
            text-align: center;
        }
        input[type="number"] {
            padding: 8px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
            width: 100%;
            margin-bottom: 10px;
        }
        input[type="submit"] {
            padding: 10px 20px;
            font-size: 16px;
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
            border-radius: 4px;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>每日費率</h2>
        <p><strong>當前每日費率：</strong> <?php echo $dailyRate; ?></p>
        <form action="modify_price.php" method="post">
            <label for="new_daily_rate">設定新的每日費率：</label>
            <input type="number" step="1" id="new_daily_rate" name="new_daily_rate" value="<?php echo htmlspecialchars($dailyRate); ?>" required>
            <br><br>
            <input type="submit" value="修改">
        </form>

    </div>
</body>
</html>
