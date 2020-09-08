<?php
namespace Controller;

use App\DB;

class ViewController {
    function main(){
        view("main");
    }

    function overview(){
        view("overview");
    }

    function admin(){
        view("admin");
    }

    // 사용자 관리
    function signIn(){
        view("sign-in");
    }

    function signUp(){
        view("sign-up");
    }

    // 에약 관리자
    function reserveAdmin(){
        $search_type = isset($_GET['search_type']) ? $_GET['search_type'] : null;
        $keyword = isset($_GET['keyword']) ? $_GET['keyword'] : null;

        $whereSQL = " WHERE 1";
        $params = [];
        if($keyword && array_search($search_type, ["book_name", "writer_name"]) !== false){
            $whereSQL .= " AND $search_type LIKE ?";
            $params[] = "%{$keyword}%";
        }

        view("reserve-admin", [
            "keyword" => $keyword,
            "search_type" => $search_type,
            "reserves" => DB::fetchAll("SELECT DISTINCT R.*, book_name, writer_name, user_name
                                        FROM reserves R
                                        LEFT JOIN users U ON U.id = R.uid
                                        LEFT JOIN meeting M ON M.id = R.mid
                                        $whereSQL", $params)
        ]);
    }

    // 예약하기
    function reserve(){
        $year = isset($_GET['year']) ? $_GET['year'] : date("Y");
        $month = isset($_GET['month']) ? $_GET['month'] : date("m");
        $day = isset($_GET['day']) ? $_GET['day'] : 1;

        $t_firstDay = strtotime("$year-$month-1");
        $t_lastDay = strtotime("-1 Day", strtotime("+1 Month", $t_firstDay));

        $t_prev = strtotime("-1 Month", $t_firstDay);
        $t_next = strtotime("+1 Month", $t_firstDay);

        $meeting = DB::fetchAll("SELECT * FROM meeting");

        view("reserve", compact("year", "month", "day", "t_firstDay", "t_lastDay", "t_prev", "t_next", "meeting"));
    }

    // 예약 확인
    function reserveList(){
        
        view("reserve-list", [
            "reserves" => DB::fetchAll("SELECT R.*, writer_name, pos_time
                                        FROM reserves R
                                        LEFT JOIN meeting M ON M.id = R.mid
                                        WHERE R.uid = ?", [user()->id])
        ]);
    }    

    // 예약 상세보기
    function reserveDetail($id){
        $reserve = DB::fetch("SELECT R.*, writer_name, user_name, school
                                FROM reserves R
                                LEFT JOIN users U ON U.id = R.uid
                                LEFT JOIN meeting M ON M.id = R.mid
                                WHERE R.id = ?", [$id]);
        if(!$reserve) back("대상을 찾을 수 없습니다.");
        view("reserve-detail", ["reserve" => $reserve]);
    }

    // 예약 그래프
    function reserveGraph(){
        $data = [];
        $type = isset($_GET['type']) ? $_GET['type'] : "writer_name";

        if($type == "writer_name"){
            $data = DB::fetchAll("SELECT COUNT(*) count, writer_name name
                                    FROM reserves R
                                    LEFT JOIN users U ON U.id = R.uid
                                    LEFT JOIN meeting M ON M.id = R.mid
                                    GROUP BY writer_name");
        }
        else {
            $data = DB::fetchAll("SELECT COUNT(*) count, school name
                            FROM reserves R
                            LEFT JOIN users U ON U.id = R.uid
                            LEFT JOIN meeting M ON M.id = R.mid
                            GROUP BY school");
        }
        view("reserve-graph", compact("data", "type"));
    }
}