<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<title>mission_3-3</title>
</head>
<body>
<form action="" method="post">
【投稿フォーム】<br>
お名前：
<input type="text" name="name"><br>
コメント：
<input type="text" name="comment"><br>
<input type="submit" name="submit"><br>
【削除フォーム】<br>
削除対象番号：
<input type="text" name="deletenumber"><br>
<input type="submit" name="delete" value="削除">
</form>

<?php
$filename = "mission_3-3.txt";
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
    $deleteNumber = $_POST["deletenumber"];
    
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
</body>
</html>