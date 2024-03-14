<?php
//データベース接続
$dsn='mysql:dbname=step7;host=localhost;charset=utf8';
$user='root';
$password='root';

$dbh=new PDO($dsn,$user,$password);
$dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

//下の検索のためのクラス名等諸々の変更をする必要あり

//「検索」ボタン押下時
if (isset($_POST["search"])) {

    //「名前」だけ入力されている場合
    if (isset($_POST["search_name"]) && empty($_POST["search_makerName"])){
        $search_name = $_POST["search_name"];
        $search_makerName = '';
    }

    //「メーカー名」だけ入力されている場合
    if (empty($_POST["search_name"]) && isset($_POST["search_makerName"])){
        $search_name = '';
        $search_makerName = $_POST["search_makerName"];
    }

    //「名前」「メーカー名」両方が入力されている場合
    if (isset($_POST["search_name"]) && isset($_POST["search_makerName"])){
        $search_name = $_POST["search_name"];
        $search_makerName = $_POST["search_makerName"];
    }

    //実行
    $sql="SELECT * FROM step72 WHERE name like '%{$search_name}%' and makerName like '%{$search_makerName}%'";
    $rec = $dbh->prepare($sql);
    $rec->execute();
    $rec_list = $rec->fetchAll(PDO::FETCH_ASSOC);

}else{

        //「検索」ボタン押下してないとき
        $sql='SELECT * FROM step72 WHERE 1';
        $rec = $dbh->prepare($sql);
        $rec->execute();
        $rec_list = $rec->fetchAll(PDO::FETCH_ASSOC);
    }

//データベース切断
$dbh=null;
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
</head>
<body>

<!--検索-->
<form action="sample.php" method="POST">
<table border="1" style="border-collapse: collapse">
<tr>
<th>名前</th>
<td><input type="text" name="search_fname" value="<?php if( !empty($_POST['search_fname']) ){ echo $_POST['search_fname']; } ?>"></td></td>
<th>産地</th>
<td><input type="text" name="search_fsanchi" value="<?php if( !empty($_POST['search_fsanchi']) ){ echo $_POST['search_fsanchi']; } ?>"></td>
<td><input type="submit" name="search" value="検索"></td>
</tr>
</table>
</form>
<br />

<!--検索解除-->
<?php if (isset($_POST["search"])) {?>
<a href="http://localhost/sample.php">検索を解除</a><br />
<?php } ?>

<table border="1" style="border-collapse: collapse">
<tr>
<th>ID</th>
<th>名前</th>
<th>値段</th>
<th>産地</th>
</tr>

<!--MySQLデータを表示-->
<?php foreach ($rec_list as $rec) { ?>
<tr>
<td><?php echo $rec['f_id'];?></td>
<td><?php echo $rec['f_name'];?></td>
<td><?php echo $rec['f_price'];?></td>
<td><?php echo $rec['f_sanchi'];?></td>
</tr>
<?php } ?>
</table>

</body>
</html>