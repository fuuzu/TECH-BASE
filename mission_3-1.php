<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<title>mission_3-1</title>
</head>
<body>
<form action = "" method = "post">
    お名前：<input type = "text" name = "name"><br>
    コメント：<input type = "text" name = "comment"><br>
    <input type = "submit" name = "submit">
</form>
<?php
$filename = "mission_3-1.txt";
$name = $_POST["name"];
$str = $_POST["comment"];
$date = date("Y/m/d h:i:s");

if(file_exists($filename)){
$num = count(file($filename)) + 1;
}else{
    $num = 1;
}
$comment = $num. "<>". $name. "<>". $str. "<>". $date;
$filename = "mission_3-1.txt";
$fp = fopen($filename, "a");
fwrite($fp, $comment. PHP_EOL);
fclose($fp);
?>
</body>
</html>