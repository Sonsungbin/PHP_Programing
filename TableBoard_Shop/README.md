# TableBoard_Shop
게시판-Shop 의 TODO 완성하기!

## 기존 파일
```
 .
├── css - board_form.php와 index.php 에서 사용하는 stylesheet
│   └── ...
├── fonts - 폰트
│   └── ...
├── images - 아이콘 이미지
│   └── ...
├── vender - 외부 라이브러리
│   └── ...
├── js - board_form.php와 index.php 에서 사용하는 javascript
│   └── ...
├── function
│   └── insert.php - 게시글 작성 기능 구현
│   └── update.php - 게시글 수정 기능 구현
│   └── delete.php - 게시글 삭제 기능 구현
├── board_form.php - 게시글 작성/수정 시 사용하는 form이 포함된 php 파일
├── index.php - 게시글 조회 기능 구현
```

## MySQL 테이블 생성!

[여기에 테이블 생성 시, 사용한 Query 를 작성하세요.]
Note: 
- table 이름은 tableboard_shop 으로 생성
- 기본키는 num 으로, 그 외의 속성은 board_form.php 의 input 태그 name 에 표시된 속성 이름으로 생성
- 각 속성의 type 은 자유롭게 설정 (단, 입력되는 값의 타입과 일치해야 함)
    - ex) price -> int
    - ex) name -> char or varchar
    
## index.php 수정
[여기에 index.php 를 어떻게 수정했는지, 설명을 작성하세요.]
```
(1) SQL Code
TABLE에 있는 모든 DB를 가져오는 SQL문을 작성했다. 
$numOfrow : 전체 DB의 갯수
<?php
    # TODO: MySQL 데이터베이스 연결 및 레코드 가져오기!
    // MySQL 데이터베이스 연결
    $connect = mysql_connect("localhost", "ssb", "1234");
    // DB 선택
    mysql_select_db("ssb_db", $connect);
    // sql 쿼리 string 생성
    $sql = "select * from tableboard_shop";
    // sql 쿼리 실행
    $result = mysql_query($sql);
    // 선택된 sql 갯수
    $numOfrow = mysql_num_rows($result);
?>

(2) HTML Code
반복문과 $row = mysql_fetch_row($result)구문을 이용하여 모든 DB를 받아왔고
받아올때마다 $row[index]를 이용해 DB의 값을 지정해주었다.
<?php
    # TODO : 아래 표시되는 내용을, MySQL 테이블에 있는 레코드로 대체하기!
    # Note : column6 에 해당하는 Total 은 Price 값과 Quantity 값의 곱으로 표시!
        for($i=0;$i<$numOfrow;$i++) {
                $row = mysql_fetch_row($result);
                echo '<tr onclick="location.href = (\'board_form.php?num='; echo $i+1;echo '\')">';
                echo '<td class="column1">'; echo $row[1]; echo '</td>';
                echo '<td class="column2">'; echo $row[2]; echo '</td>';
                echo '<td class="column3">'; echo $row[3]; echo '</td>';
                echo '<td class="column4">'; echo '$'; echo $row[4]; echo '</td>';
                echo '<td class="column5">'; echo $row[5]; echo '</td>';
                echo '<td class="column6">'; echo '$'; echo $row[4]*$row[5]; echo '</td>';
                echo '</tr>';
         }
?>
```

## function

### insert.php 수정
[여기에 insert.php 를 어떻게 수정했는지, 설명을 작성하세요.]
```
이전 수업에서 배웠던 insert 구문이라 쉽게 작성할 수 있었다.
각 value 값들은 $_POST를 이용해 값들을 받아 왔다.
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
```

### update.php 수정
[여기에 update.php 를 어떻게 수정했는지, 설명을 작성하세요.]
```
update문은 board_form구문에서 입력한 값들로 DB를 수정하는 SQL문을 작성했고
수정해야할 DB의 행을 찾기 위해 $_GET[num]를 이용하여 update문을 작성하였다.
<?php
/**
 * Created by PhpStorm.
 * User: kim2
 * Date: 2019-04-04
 * Time: 오전 9:39
 */

# TODO: MySQL DB에서, num에 해당하는 레코드를 POST로 받아온 내용으로 수정하기!
$connect = mysql_connect("localhost", "ssb", "1234");
// DB 선택
mysql_select_db("ssb_db", $connect);
// sql 쿼리 string 생성
$sql = "update tableboard_shop set date ='$_POST[date]',orderid ='$_POST[order_id]', name='$_POST[name]',price='$_POST[price]',quantity='$_POST[quantity]' where num = $_GET[num]";
// sql 쿼리 실행
$result = mysql_query($sql);
# 참고 : 에러 메시지 출력 방법
if(!$result) {
    echo "<script> alert('update - error message') </script>";
}

?>
```
### delete.php 수정
[여기에 delete.php 를 어떻게 수정했는지, 설명을 작성하세요.]
```
delete문이 조금 생각을 했어야했다.
primary Key인 num을 자동으로 증가시켜주는 AUTO_INCREMENT를 이용하였으나
삭제한 후 데이터를 insert 시키면 AUTO_INCREMENT의 값이 조금 이상하게 증가하는 현상이 생겨
이 현상을 해결하기 위해 data를 delete 시킨 후 SQL문 내에서 cnt 변수를 0으로 설정 후
DB의 num열을 cnt에 1을 더한 값으로 정렬을 한 후 auto_increment를 1로 설정했다.

<?php
/**
 * Created by PhpStorm.
 * User: kim2
 * Date: 2019-04-04
 * Time: 오전 9:39
 */

# TODO: MySQL DB에서, num에 해당하는 레코드 삭제하기!
$connect = mysql_connect("localhost", "ssb", "1234");
// DB 선택
mysql_select_db("ssb_db", $connect);
// sql 쿼리 string 생성
$sql = "delete from tableboard_shop where num = $_GET[num]";
// sql 쿼리 실행
$result = mysql_query($sql);

$sql2 = "set @cnt =0";
$sql3 =  "update tableboard_shop set tableboard_shop.num = @cnt:=@cnt+1";
$sql4 =  "alter table tableboard_shop auto_increment=1";

$result2 = mysql_query($sql2);
$result3 = mysql_query($sql3);
$result4 = mysql_query($sql4);
# 참고 : 에러 메시지 출력 방법

if(!$result || !$result2 || !$result3 || !$result4) {
    echo "<script> alert('delete - error message') </script>";
}

mysql_close();

?>
```
