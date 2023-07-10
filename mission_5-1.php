<?php
// データベースへの接続
$dsn = 'mysql:dbname=データベース名;host=localhost';
$user = 'ユーザ名';
$password = 'パスワード';
$pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));

// テーブルの作成
$sql = "CREATE TABLE IF NOT EXISTS mission5 (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name char(32),
    comment TEXT,
    regi_date DATETIME,
    password char(10)
)";
$pdo->exec($sql);

// 変数の初期化
$editNumber = "";
$editName = "";
$editComment = "";

// 編集フォームの送信後の処理
if (isset($_POST["edit_post"])) {
    $editNumber = $_POST['edit_post'];
    $name = $_POST['name'];
    $comment = $_POST['comment'];
    $password = $_POST['password'];
    $date = date('Y/m/d H:i:s');

    if (!empty($name) && !empty($comment) && !empty($password)) {
        if ($editNumber) {
            $stmt = $pdo->prepare("UPDATE mission5 SET name = ?, comment = ?, regi_date = ?, password = ? WHERE id = ?");
            $stmt->execute([$name, $comment, $date, $password, $editNumber]);
            $editNumber = ""; // 編集後に編集対象番号をリセット
        } else {
            $stmt = $pdo->prepare("INSERT INTO mission5 (name, comment, regi_date, password) VALUES (?, ?, ?, ?)");
            $stmt->execute([$name, $comment, $date, $password]);
        }
    }
}

// 削除処理
if (isset($_POST["delete"])) {
    $deleteNumber = $_POST["deleteNumber"];
    $deletePassword = $_POST["deletePassword"];

    if (!empty($deleteNumber) && !empty($deletePassword)) {
        $stmt = $pdo->prepare("DELETE FROM mission5 WHERE id = ? AND password = ?");
        $stmt->execute([$deleteNumber, $deletePassword]);
    }

    // 削除後に番号を更新
    $stmt = $pdo->query("SET @id := 0");
    $stmt = $pdo->query("UPDATE mission5 SET id = (@id := @id + 1)");
    $stmt = $pdo->query("ALTER TABLE mission5 AUTO_INCREMENT = 1");
}

// 編集フォームの表示
if (isset($_POST["edit"])) {
    $editNumber = $_POST["number"];
    $editPassword = $_POST["editPassword"];

    if (!empty($editNumber) && !empty($editPassword)) {
        $stmt = $pdo->prepare("SELECT * FROM mission5 WHERE id = ? AND password = ?");
        $stmt->execute([$editNumber, $editPassword]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            $editName = $row["name"];
            $editComment = $row["comment"];
        }
    }
}
?>

<!doctype html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>mission_5-1</title>
</head>

<body>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
        【投稿フォーム】<br>
        お名前：
        <input type="hidden" name="edit_post" value="<?php echo $editNumber; ?>">
        <input type="text" name="name" value="<?php echo $editName; ?>">
        <br>
        コメント：
        <textarea name="comment"><?php echo $editComment; ?></textarea>
        <br>
        パスワード：
        <input type="text" name="password">
        <br>
        <input type="submit" name="normal" value="送信">
    </form>

    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
        【削除フォーム】<br>
        削除対象番号：
        <input type="text" name="deleteNumber">
        <br>
        パスワード：
        <input type="text" name="deletePassword">
        <br>
        <input type="submit" name="delete" value="削除">
    </form>

    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
        【編集フォーム】<br>
        編集対象番号：
        <input type="text" name="number" value="">
        <br>
        パスワード：
        <input type="text" name="editPassword">
        <br>
        <input type="submit" name="edit" value="送信">
    </form>

    <?php
    // 投稿の表示
    $stmt = $pdo->query("SELECT * FROM mission5");
    $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach ($posts as $post) {
        echo $post["id"] . " "; // 番号
        echo $post["name"] . " "; // 名前
        echo $post["comment"] . " "; // コメント
        echo $post["regi_date"] . "<br>"; // 日時
    }
    ?>
</body>

</html>

