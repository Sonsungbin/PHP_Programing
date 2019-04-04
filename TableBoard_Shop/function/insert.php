<?php
/**
 * Created by PhpStorm.
 * User: kim2
 * Date: 2019-04-04
 * Time: 오전 9:39
 */

# TODO: MySQL DB에서, POST로 받아온 내용 입력하기!
$connect = mysql_connect("localhost", "ssb", "1234");
// DB 선택
mysql_select_db("ssb_db", $connect);
// sql 쿼리 string 생성
$sql = "insert into tableboard_shop(date,orderid, name, price, quantity) 
             values('$_POST[date]','$_POST[order_id]','$_POST[name]','$_POST[price]','$_POST[quantity]')";
// sql 쿼리 실행
$result = mysql_query($sql);
# 참고 : 에러 메시지 출력 방법
if(!$result) {
    echo "<script> alert('ERROR!!'); </script>";
}
mysql_close();

?>

<script>
    location.replace('../index.php');
</script>
