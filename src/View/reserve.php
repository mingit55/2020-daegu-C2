<style>
    .calender {
        width: 100%;
        display: flex;
        flex-wrap: wrap;
        border-left: 1px solid #ddd;
        border-top: 1px solid #ddd;
    }
    .calender__head,
    .calender__item {
        width: calc(100% / 7);
        height: 100px;
        position: relative;
        border-right: 1px solid #ddd;
        border-bottom: 1px solid #ddd;
    }
    .calender__head {
        text-align: center;
        line-height: 40px;
        height: 40px;
        font-size: 0.9em;
    }
    .calender__item:disabled { background-color: #f7f7f7; pointer-events: none; }
    .calender__item.active { transform: scale(1.05); border: 5px solid #d6a348; }

    .calender__item span {
        position: absolute;
        left: 0.5em;
        top: 0.5em;
    }
</style>


<div class="hx-300 position-relative">
    <div class="background background--black">
        <img src="/images/visual/1.jpg" alt="비주얼 이미지">
    </div>
    <div class="position-center text-center mt-4">
        <div class="fx-7 text-white font-weight-bold">예약하기</div>
        <div class="fx-n1 text-gray mt-2">
            전주독서대전
            <i class="fa fa-angle-right"></i>
            예약하기
        </div>
    </div>
</div>

<div class="container py-5">
    <div class="row">
        <div class="col-lg-8">
            <div class="d-between align-items-end border-bottom pb-3 mb-3">
                <div>
                    <hr class="bg-gold">
                    <div class="title text-gold"><?=$year?>년 <?=$month?>월</div>
                </div>
                <div>
                    <a href="/reserve?year=<?= date("Y", $t_prev) ?>&month=<?= date("m", $t_prev) ?>" class="btn-bordered">이전 달</a>
                    <a href="/reserve?year=<?= date("Y", $t_next) ?>&month=<?= date("m", $t_next) ?>" class="btn-bordered">다음 달</a>
                </div>
            </div>
            <div class="calender">
                <div class="calender__head">일</div>
                <div class="calender__head">월</div>
                <div class="calender__head">화</div>
                <div class="calender__head">수</div>
                <div class="calender__head">목</div>
                <div class="calender__head">금</div>
                <div class="calender__head">토</div>
        
                <?php for($i = 0; $i < date("w", $t_firstDay); $i++):?>
                    <div class="calender__item" disabled></div>
                <?php endfor;?>
        
                <?php for($i = date("d", $t_firstDay); $i <= date("d", $t_lastDay); $i++):?>
                    <div class="calender__item" data-value="<?="$year-$month-$i"?>">
                        <span><?= (int)$i ?></span>
                    </div>
                <?php endfor;?>
        
                <?php for($i = 0; $i < 6 - date("w", $t_lastDay); $i++):?>
                    <div class="calender__item" disabled></div>
                <?php endfor;?>
            </div>
        </div>
        <div class="col-lg-4">
            <form id="reserve-form">
                <div class="form-group">
                    <label>작가 리스트</label>
                    <select name="mid" id="mid" class="form-control" required>
                        <option value>예약 일자를 선택하세요</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>예약 가능 시간</label>
                    <select name="rtime" id="rtime" class="form-control" required>
                        <option value>작가를 선택하세요</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>회원 명</label>
                    <input type="text" class="form-control" value="<?=user()->user_name?>" readonly>
                </div>
                <div class="form-group">
                    <label>성별</label>
                    <input type="text" class="form-control" value="<?=user()->gender?>" readonly>
                </div>
                <div class="form-group">
                    <label>나이</label>
                    <input type="text" class="form-control" value="<?=user()->age?>" readonly>
                </div>
                <div class="form-group">
                    <label>학교</label>
                    <input type="text" class="form-control" value="<?=user()->school?>" readonly>
                </div>
                <div class="form-group">
                    <label>작가에게 바라는 점</label>
                    <textarea name="content" id="content" cols="30" rows="10" class="form-control" required></textarea>
                </div>
                <div class="form-group mt-3 text-right">
                    <button class="btn-filled">예약하기</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div id="reserve-modal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <div class="fx-4">예약하기</div>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>작가 리스트</label>
                    <input type="text" id="v_mid" class="form-control" readonly required>
                </div>
                <div class="form-group">
                    <label>예약 가능 시간</label>
                    <input type="text" id="v_rtime" class="form-control" readonly required>
                </div>
                <div class="form-group">
                    <label>회원 명</label>
                    <input type="text" class="form-control" value="<?=user()->user_name?>" readonly>
                </div>
                <div class="form-group">
                    <label>성별</label>
                    <input type="text" class="form-control" value="<?=user()->gender?>" readonly>
                </div>
                <div class="form-group">
                    <label>나이</label>
                    <input type="text" class="form-control" value="<?=user()->age?>" readonly>
                </div>
                <div class="form-group">
                    <label>학교</label>
                    <input type="text" class="form-control" value="<?=user()->school?>" readonly>
                </div>
                <div class="form-group">
                    <label>작가에게 바라는 점</label>
                    <textarea id="v_content" cols="30" rows="10" class="form-control" readonly required></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn-reserve btn-filled">예약하기</button>
            </div>
        </div>
    </div>
</div>

<script>
    let meeting = <?= json_encode($meeting, JSON_UNESCAPED_UNICODE) ?>;
    let mid = () => $("#mid").val();
    let rdate = null;
    let rtime = () => $("#rtime").val();
    let content = () => $("#content").val();
    let status = "INPUT";

    $(".calender__item").on("click", function(){
        let value =  $(this).data("value");
        rdate = new Date(value);

        let list = meeting.filter(item => item.pos_week == rdate.getDay());
        if(list.length > 0){
            $("#mid").html('<option value>예약 일자를 선택하세요</option>');
            $("#rtime").html('<option value>작가를 선택하세요</option>');
            
            list.forEach(mt => {
                $("#mid").append(`<option value="${mt.id}">${mt.writer_name}</option>`);
            });
        } else {
            $("#mid").html(`<option value>작가를 찾을 수 없습니다</option>`);
        }
    });

    $("#mid").on("change", function(e){
        let mt = meeting.find(mt => mt.id == this.value);
        let t_start = parseInt(mt.pos_time.substr(0, 2));
        let t_end = parseInt(mt.pos_time.substr(6, 8));

        
        $("#rtime").html('<option value>작가를 선택하세요</option>');
        for(let i = t_start; i <= t_end; i++){
            $("#rtime").append(`<option value="${i}:00">${i}:00</option>`);
        }
    });

    $("#reserve-form").on("submit", e => {
        e.preventDefault();

        $("#v_mid").val( mid() );
        $("#v_rtime").val( rtime() );
        $("#v_content").val( content() );
        
        $("#reserve-modal").modal("show");
    });

    $(".btn-reserve").on("click", e => {
        if(status === "INPUT"){
            fetch("/insert/reserves", {method: "post", body: JSON.stringify({
                mid: mid(), 
                rtime: rtime(), 
                content: content(), 
                rdate: rdate})
            })
            .then(res => res.text())
            .then(res => {
                status = "SEND";
                $(".btn-reserve").text("다시 예약하기");
            });
        } else {
            status = "INPUT";
            $(".btn-reserve").text("예약하기");   
            $("#reserve-modal").modal("hide");

            $("#mid").html('<option value>예약 일자를 선택하세요</option>');
            $("#rtime").html('<option value>작가를 선택하세요</option>');
            $("#content").val('');
        }
    });

</script>