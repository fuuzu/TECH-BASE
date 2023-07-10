 <!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<title>mission_2-4</title>
</head>
<body>
<form action="" method="post">
    <input type="text" name="comment" placeholder="コメント">
    <input type="submit" name="submit">
</form>
<?php
$comment = $_POST["comment"];
    $filename="mission_2-4.txt";
    $fp=fopen($filename,"a");
    fwrite($fp, $comment. PHP_EOL);
    fclose($fp);
$comment = array("イチゴ","トマト","レンコン","キュウリ");
      foreach($items as $item);
    echo $comment[0] . "<br/>";
    echo $comment[1] . "<br/>";
    echo $comment[2] . "<br/>";
    echo $comment[3] . "<br/>";

?>
</body>
</html>