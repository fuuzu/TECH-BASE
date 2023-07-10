<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<title>mission_3-2</title>
</head>
<body>
<form action = "" method = "post">
    お名前：<input type = "text" name = "name"><br>
    コメント：<input type = "text" name = "comment"><br>
    <input type = "submit" name = "submit">
</form>
<?php

$filename = "mission_3-2.txt";
$lines = file($filename, FILE_IGNORE_NEW_LINES); 
foreach($lines as $line){
    $elements = explode("<>", $line);
    for($i = 0 ; $i < count($elements); $i++){
        echo $elements[$i];
    }
    echo "<br>";
}

?>
</body>
</html>