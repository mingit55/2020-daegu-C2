<?php
namespace Controller;

use App\DB;

class ActionController {
    // 데이터 초기화
    function init(){
        DB::query("DELETE FROM users");
        DB::query("INSERT INTO users (user_email, password, user_name) VALUES ('admin', '1234', '관리자')");


        DB::query("DELETE FROM meeting");

        $data = [
            ["페인트.jpg", "페인트",	"이희영",	"초등학생",	"2019-04-19",	"1",	"11:00~13:00"],
            ["체리새우.jpg", "체리새우",	"황영미",	"초등학생",	"2019-01-28",	"2",	"13:00~15:00"],
            ["시간을 파는 상점.jpg", "시간을 파는 상점",	"김선영",	"초등학생",	"2012-04-10",	"3",	"15:00~17:00"],
            ["아몬드.jpg", "아몬드",	"손원평",	"초등학생",	"2017-03-31",	"4",	"10:00~12:00"],
            ["완득이.jpg", "완득이",	"김려령",	"초등학생",	"2008-03-17",	"5",	"14:00~16:00"],
            ["단편소설 베스트35.jpg", "단편소설 베스트35",	"김형주",	"중학생",	"2015-07-13",	"1",	"11:00~13:00"],
            ["그들도 아이였다.jpg", "그들도 아이였다",	"김은우",	"중학생",	"2018-03-25",	"2",	"13:00~15:00"],
            ["십대를 위한 실패수업.jpg", "십대를 위한 실패수업",	"정화진",	"중학생",	"2019-06-12",	"3",	"15:00~17:00"],
            ["중학국어 비문학 독해 한권으로 끝내기.jpg", "중학국어 비문학 독해 한권으로 끝내기",	"정문경",	"중학생",	"2019-06-05",	"4",	"10:00~12:00"],
            ["바다소.jpg", "바다소",	"양태은",	"중학생",	"2018-06-10",	"5",	"14:00~16:00"],
            ["선생님과 함께 읽는 우리 소설.jpg", "선생님과 함께 읽는 우리 소설",	"권순긍",	"고등학생",	"2011-05-03",	"1",	"11:00~13:00"],
            ["스프링벅.jpg", "스프링벅",	"배유안",	"고등학생",	"2008-10-13",	"2",	"13:00~15:00"],
            ["생각한다는것.jpg", "생각한다는것",	"고병권",	"고등학생",	"2010-03-31",	"3",	"15:00~17:00"],
            ["개똥 세개.jpg", "개똥 세개",	"강수돌",	"고등학생",	"2013-07-30",	"4",	"10:00~12:00"],
            ["아이는 사춘기 엄마는 성장기.jpg", "아이는 사춘기 엄마는 성장기",	"이윤정",	"고등학생",	"2010-03-26",	"5",	"14:00~16:00"],
        ];
        
        foreach($data as $item){
            DB::query("INSERT INTO meeting(book_image, book_name, writer_name, target, created_at, pos_week, pos_time) VALUES (?, ?, ?, ?, ?, ?, ?)", $item);
        }
    }

    // 사용자 관리
    function signIn(){
        checkEmpty();
        extract($_POST);

        $user = DB::who($user_email);
        if(!$user || $user->password !== $password) back("아이디 혹은 비밀번호가 일치하지 않습니다.");

        $_SESSION['user'] = $user;
        go("/", "로그인 되었습니다.");
    }

    function signUp(){
        checkEmpty();
        extract($_POST);

        // 입력 정보 인증
        if(!preg_match("/^([a-zA-Z0-9]+)@([a-zA-Z0-9]+\.)+([a-zA-Z]{2,3})$/", $user_email)){
            back("올바른 이메일을 입력하세요.");
        }

        if(!preg_match("/^([ㄱ-ㅎㅏ-ㅣ가-힣]+)$/", $user_name)){
            back("올바른 이름을 입력하세요.");
        }

        if($password !== $passconf) {
            back("비밀번호와 비밀번호 확인이 일치하지 않습니다.");
        }

        DB::query("INSERT INTO users(user_email, password, user_name, gender, age, school) VALUES (?, ?, ?, ?, ?, ?)", [
            $user_email, $password, $user_name, $gender, $age, $school
        ]);

        go("/", "회원가입 되었습니다.");
    }

    function signOut(){
        unset($_SESSION['user']);
        go("/", "로그아웃 되었습니다.");
    }

    // 작가와의 만남
    function insertMeeting(){
        checkEmpty();
        extract($_POST);

        if(strtotime($pos_starttime) >= strtotime($pos_endtime)) {
            exit;
            back("올바른 예약 시간을 입력하세요.");   
        }
        
        $image = $_FILES['book_image'];
        $filename = time() . "-" . $image['name'];
        if(!checkimage($filename)) back("올바른 이미지를 선택하세요.");
        move_uploaded_file($image['tmp_name'], "". $filename);

        

        DB::query("INSERT INTO meeting(book_name, book_image, writer_name, target, created_at, pos_week, pos_time) VALUES (?, ?, ?, ?, ?, ?, ?)", [
            $book_name, $filename, $writer_name, $target, $created_at, $pos_week, "$pos_starttime~$pos_endtime"
        ]);

        go("/reserve-admin", "등록되었습니다.");
    }

    // 예약
    function insertReserve(){
        $input = (array)json_decode(file_get_contents("php://input"));
        extract( $input );

        DB::query("INSERT INTO reserves(uid, mid, rdate, rtime, content) VALUES (?, ?, ?, ?, ?)", [user()->id, $mid, $rdate, $rtime, $content]);
    }

    function updateReserve($id){
        $reserve = DB::find("reserves", $id);
        if(!$reserve || $reserve->uid != user()->id) back("대상을 찾을 수 없습니다.");

        checkEmpty();
        extract($_POST);              

        DB::query("UPDATE reserves SET rtime = ?, content = ? WHERE id = ?", [$rtime, $content, $id]);
        go("/reserve-list", "수정되었습니다.");
    }

    function deleteReserve($id){
        $reserve = DB::find("reserves", $id);
        if(!$reserve || $reserve->uid != user()->id) back("대상을 찾을 수 없습니다.");

        DB::query("DELETE FROM reserves WHERE id = ?", [$id]);
        go("/reserve-list", "삭제되었습니다.");
    }

    // 예약 활성화
    function activeReserve($id){
        $reserve = DB::find("reserves", $id);
        if(!$reserve) back("대상을 찾을 수 없습니다.");
        if($reserve->status) back("이미 예약이 완료되어 있습니다.");
        
        DB::query("UPDATE reserves SET status = 1 WHERE id = ?", [$id]);
        go("/reserve-admin", "예약이 완료되었습니다.");
    }
}