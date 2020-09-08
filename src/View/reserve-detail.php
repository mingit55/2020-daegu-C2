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
    <hr>
    <div class="title">작가와의 만남</div>
    <div class="mt-4">
        <div class="mb-2">
            <span class="fx-n1 text-muted">만나고 싶은 작가</span>
            <span class="ml-2"><?=$reserve->writer_name?></span>
        </div>
        <div class="mb-2">
            <span class="fx-n1 text-muted">예약 날짜</span>
            <span class="ml-2"><?=$reserve->rdate?></span>
        </div>
        <div class="mb-2">
            <span class="fx-n1 text-muted">예약 시간</span>
            <span class="ml-2"><?=$reserve->rtime?></span>
        </div>
        <div class="mb-2">
            <span class="fx-n1 text-muted">회원 이름</span>
            <span class="ml-2"><?=$reserve->user_name?></span>
        </div>
        <div class="mb-2">
            <span class="fx-n1 text-muted">학년</span>
            <span class="ml-2"><?=$reserve->school?></span>
        </div>
        <div class="mt-3 text-line">
            <?=enc($reserve->content)?>
        </div>
    </div>
</div>