<div class="hx-300 position-relative">
    <div class="background background--black">
        <img src="/images/visual/1.jpg" alt="비주얼 이미지">
    </div>
    <div class="position-center text-center mt-4">
        <div class="fx-7 text-white font-weight-bold">예약 확인</div>
        <div class="fx-n1 text-gray mt-2">
            전주독서대전
            <i class="fa fa-angle-right"></i>
            예약 확인
        </div>
    </div>
</div>

<div class="container py-5">
    <hr class="bg-gold">
    <div class="title text-gold">예약 확인</div>
    <div class="t-head mt-4">
        <div class="cell-10">상태</div>
        <div class="cell-10">작가명</div>
        <div class="cell-20">예약 일시</div>
        <div class="cell-40">작가에게 바라는 점</div>
        <div class="cell-20">-</div>
    </div>
    <?php foreach($reserves as $reserve):?>
        <!-- 데이터 행 -->
        <div class="t-row" data-toggle="modal" data-target="#view-modal-<?=$reserve->id?>">
            <div class="cell-10"><?= $reserve->status ? "예약" : "대기중" ?></div>
            <div class="cell-10"><?= $reserve->writer_name ?></div>
            <div class="cell-20"><?= $reserve->rdate ?> <?= $reserve->rtime ?></div>
            <div class="cell-40"><?= enc($reserve->content) ?></div>
            <div class="cell-20">
                <button class="btn-filled" data-toggle="modal" data-target="#edit-modal-<?=$reserve->id?>">수정</button>
                <a href="/delete/reserves/<?=$reserve->id?>" class="btn-bordered">삭제</a>
            </div>
        </div>
        <!-- /데이터 행 -->

        <!-- 수정하기 팝업 -->
        <form action="/update/reserves/<?=$reserve->id?>" method="post" id="edit-modal-<?=$reserve->id?>" class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <div class="fx-4">수정하기</div>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>예약 가능 시간</label>
                            <select name="rtime" class="form-control" required>
                                <?php foreach( getTimeLine($reserve->pos_time) as $time ):?>
                                    <option value="<?=$time?>" <?= $reserve->rtime == $time ? 'selected' :'' ?>><?=$time?></option>
                                <?php endforeach;?>
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
                            <textarea name="content" cols="30" rows="10" class="form-control" required><?=$reserve->content?></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn-filled">수정 완료</button>
                    </div>
                </div>
            </div>
        </form>
        <!-- /수정하기 팝업 -->

        <!-- 보기 팝업 -->
        <div id="view-modal-<?=$reserve->id?>" class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <div class="fx-4">상세 보기</div>
                    </div>
                    <div class="modal-body">
                        <div class="mb-2">
                            <span class="fx-n2 text-muted">만남 날짜</span>
                            <span class="ml-2 fx-n1"><?= $reserve->rdate ?></span>
                        </div>
                        <div class="mb-2">
                            <span class="fx-n2 text-muted">만남 시간</span>
                            <span class="ml-2 fx-n1"><?= $reserve->rtime ?></span>
                        </div>
                        <div class="mb-2">
                            <span class="fx-n2 text-muted">작가명</span>
                            <span class="ml-2 fx-n1"><?= $reserve->writer_name ?></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /보기 팝업 -->
    <?php endforeach;?>
</div>


<script>
    $("[data-toggle='modal']").on("click", e => {
        e.stopPropagation();
        $(e.currentTarget.dataset.target).modal("show");
    });
</script>