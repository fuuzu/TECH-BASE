<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<title>mission_1-27</title>
</head>
<body>
<form action="" method="post">
    <input type="number" name="num">
    <input type="submit" name="submit">
    
</form>
 <?php
  $filename = "mission_1-27.txt";
  $num = $_POST["num"];
  
  function fizzbuzz($n) {
    if ($n % 3 == 0 && $n % 5 == 0) {
      return "FizzBuzz";
    } elseif ($n % 3 == 0) {
      return "Fizz";
    } elseif ($n % 5 == 0) {
      return "Buzz";
    } else {
      return $n;
    }
  }
  
  $fp = fopen($filename, "a");
  fwrite($fp, $num . PHP_EOL);
  fclose($fp);
  
  if (file_exists($filename)) {
    $lines = file($filename, FILE_IGNORE_NEW_LINES);
    foreach ($lines as $line) {
      echo fizzbuzz($line) . "<br>";
    }
  }
  
  ?>
</body>
</html>