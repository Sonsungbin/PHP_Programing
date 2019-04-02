# boardz
게시판 검색 기능 완성하기

## 기존 파일
```
 .
├── css
│   └── style.css
├── src
│   └── boardz.css
├── board.html
```

## 추가 및 수정된 파일
```
 .
├── css
│   └── style.css
├── src
│   └── boardz.css
├── board.php (수정)
```

## board.php(Query)(수정 : 2019_04_02)
```
<?php
/**
 * Created by PhpStorm.
 * User: Sungbin
 * Date: 2019-03-30
 * Time: 오후 1:20
 */

// MySQL 데이터베이스 연결
$connect = mysql_connect("localhost", "ssb", "1234");
// DB 선택
mysql_select_db("ssb_db", $connect);
// sql 쿼리 string 생성
$sql = "select * from boardz where title like '%$_POST[search]%'";
// sql 쿼리 실행
$result = mysql_query($sql);
// 선택된 sql 갯수
$numOfrow = mysql_num_rows($result);
?>

```
## board.php(Solution)
```
******************** 구현방법 ********************  
빈칸 검색 : Button의 Action을 board.php로 설정.

나머지 검색 : $data = mysql_result($result, i_index, j_index) 이용 원하는 row,column 값을 적용
├── (1) 먼저 빈칸검색과 나머지검색을 나누기 위해 if문을 이용하여 numOfrow의 갯수가 쿼리의 갯수이면 
       즉 빈칸검색이면 기존의 HTML File을 불러옴.
├── (2) 그렇지 않다면 Ul이 총 3개로 구성되어 있기 때문에 numOfrow의 갯수를 확인하여 Ul 활성화
        - (numOfrow > 0) 1번째 Ul 활성화
        - (numOfrow > 1) 1번째 Ul 활성화, 2번째 Ul 활성화
        - (numOfrow > 2) 1번째 Ul 활성화, 2번째 Ul 활성화, 3번째 Ul 활성화
├── (3) 그 다음으로 검색되 쿼리의 Primary Key인 Num의 순서에 따라 →방향으로 순차적으로 생성 3번째 Ul을 
       넘어가게 되면 1번째 Ul로 이동하는 방식을 사용
├── (4) Title 및 image를 불러오는 과정에서 
        - 1번째 Ul은 1,4,7,10 즉 3으로 나눈 나머지가 1일 경우
        - 2번째 Ul은 2,5,8,11 즉 3으로 나눈 나머지가 2일 경우         
        - 3번째 Ul은 3,6,9,12 즉 3으로 나눈 나머지가 0일 경우
        로 생각하고 for문을 이용해 numOfrow의 갯수만큼 반복을 시키고 i%3값이 0,1,2일때로 분리하여
        각각의 Ul에 생성시키는 방법을 사용함.                   
```

## board.php(Source Code)
```
빈칸검색 부분은 기존의 HTML Code를 복사해서 그냥 넣은 것이기 때문에 생략함. numOfrow의 갯수가 7개이면 기존
HTML Code 실행

else {
        if($numOfrow>0)
        {
            echo '<ul>';
            for($i=0;$i<$numOfrow;$i++) {
                 if($i%3==0) {
                    echo '<li>';
                        echo '<h1>'; $data = mysql_result($result, $i, title); echo $data; echo '</h1>';
                        echo '<img src="';$data = mysql_result($result, $i, image_url); echo $data; echo '" alt="demo image"/>';
                    echo '</li>';
                 }
            }
            echo '</ul>';
        }

        if($numOfrow>1)
        {
            echo '<ul>';
            for($i=0;$i<$numOfrow;$i++) {
                if($i%3==1) {
                    echo '<li>';
                        echo '<h1>'; $data = mysql_result($result, $i, title); echo $data; echo '</h1>';
                        echo '<img src="';$data = mysql_result($result, $i, image_url); echo $data; echo '" alt="demo image"/>';
                    echo '</li>';
                }
            }
            echo '</ul>';
        }

        if($numOfrow>2)
        {
            echo '<ul>';
            for($i=0;$i<$numOfrow;$i++) {
                if($i%3==2) {
                    echo '<li>';
                        echo '<h1>'; $data = mysql_result($result, $i, title); echo $data; echo '</h1>';
                        echo '<img src="';$data = mysql_result($result, $i, image_url); echo $data; echo '" alt="demo image"/>';
                    echo '</li>';
                  }
            }
            echo '</ul>';
        }
        }
```