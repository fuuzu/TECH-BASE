<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<title>入力内容の確認│自己紹介</title>
</head>
<body>
<table border="1">
    <tr>
        <td>名前</td>
        <td><?php echo $_POST['name']; ?></td>
    <tr>
        <td>コメント</td>
        <td><?php echo $_POST['comment'];?></td>
    </tr>
</table>
</body>
</html>