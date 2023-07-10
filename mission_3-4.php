<?php
$filename = "mission_3-4.txt";
$lines = file($filename, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

$editNumber = '';
$editName = '';
$editComment = '';

$filename = "mission_3-4.txt";
if (isset($_POST["submit"])) {
    $name = $_POST["name"];
    $comment = $_POST["comment"];
    $date = date('Y/m/d H:i:s');
    
    if (!empty($name) && !empty($comment)) {
        $lines = file($filename, FILE_IGNORE_NEW_LINES);
        $fp = fopen($filename, "a");
        
        if (count($lines) > 0) {
            $lastLine = end($lines);
            $lastId = explode("<>", $lastLine)[0];
            $newId = $lastId + 1;
        } else {
            $newId = 1;
        }
        
        fwrite($fp, $newId . "<>" . $name . "<>" . $comment . "<>" . $date . PHP_EOL);
        fclose($fp);
    }
}

if (isset($_POST["delete"])) {
    $deleteNumber = $_POST["deleteNumber"];
    
    if (!empty($deleteNumber) && file_exists($filename)) {
        $lines = file($filename, FILE_IGNORE_NEW_LINES);
        $fp = fopen($filename, "w");
        
        $id = 1;
        foreach ($lines as $line) {
            $parts = explode("<>", $line);
            $number = $parts[0];
            
            if ($number != $deleteNumber) {
                fwrite($fp, $id . "<>" . $parts[1] . "<>" . $parts[2] . "<>" . $parts[3] . PHP_EOL);
                $id++;
            }
        }
        
        fclose($fp);
    }
}


if (isset($_POST["edit"])) {
    foreach ($lines as $row) {
        $bbsRowData = explode("<>", $row);

        if ($bbsRowData[0] == $_POST["number"]) {
            $editNumber = $bbsRowData[0];
            $editName = $bbsRowData[1];
            $editComment = $bbsRowData[2];
            break;
        }
    }
} else if (isset($_POST["normal"])) {
    $writeData = ($_POST['edit_post'] ?: count($lines) + 1) . "<>" . $_POST['name'] . "<>" . $_POST['comment'] . "<>" . date('Y/m/d H:i:s'); // 日時を追加

    if ($_POST["edit_post"]) {
        foreach ($lines as &$row) {
            $bbsRowData = explode("<>", $row);

            if ($bbsRowData[0] == $_POST["edit_post"]) {
                $row = $writeData;
            }
        }
    } else {
        $lines[] = $writeData;
    }

    file_put_contents($filename, implode("\n", $lines));
}

?>
<!doctype html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>mission_3-4</title>
</head>

<body>
    <form action="" method="POST">
        【投稿フォーム】<br>
        お名前：
        <input type="hidden" name="edit_post" value="<?php echo $editNumber; ?>">
        <input type="text" name="name" value="<?php echo $editName; ?>">
        <br>
        コメント：
        <textarea name="comment"><?php echo $editComment; ?></textarea>
        <br>
        <input type="submit" name="normal" value="送信">
    </form>

    <form action="" method="POST">
        【削除フォーム】<br>
        削除対象番号：
        <input type="text" name="deleteNumber">
        <br>
        <input type="submit" name="delete" value="削除">
    </form>

    <form action="" method="POST">
        【編集フォーム】<br>
        編集対象番号：
        <input type="text" name="number" value="">
        <input type="submit" name="edit" value="送信">
    </form>
</body>

</html>

<?php
if (file_exists($filename)) {
    $lines = file($filename, FILE_IGNORE_NEW_LINES);
    
    foreach ($lines as $line) {
        $elements = explode("<>", $line);
        
        echo $elements[0] . " "; // 番号
        echo $elements[1] . " "; // 名前
        echo $elements[2] . " "; // コメント
        echo $elements[3] . "<br>"; // 日時
    }
}
?>