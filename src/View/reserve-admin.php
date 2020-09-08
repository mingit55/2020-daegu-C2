<div class="hx-300 position-relative">
    <div class="background background--black">
        <img src="/images/visual/1.jpg" alt="비주얼 이미지">
    </div>
    <div class="position-center text-center mt-4">
        <div class="fx-7 text-white font-weight-bold">관리자</div>
        <div class="fx-n1 text-gray mt-2">
            전주독서대전
            <i class="fa fa-angle-right"></i>
            관리자
        </div>
    </div>
</div>

<div class="container py-5">
    <div class="row">
        <div class="col-lg-4">
            <hr class="bg-gold">
            <div class="title text-gold">작가와의 만남</div>
            <form action="/insert/meeting" method="post" enctype="multipart/form-data" class="mt-4">
                <div class="form-group">
                    <label>책 제목</label>
                    <input type="text" class="form-control" name="book_name" required>
                </div>
                <div class="form-group">
                    <label>책 사진</label>
                    <input type="file" class="form-control" name="book_image" accept="image/*" required>
                </div>
                <div class="form-group">
                    <label>작가</label>
                    <input type="text" class="form-control" name="writer_name" required>
                </div>
                <div class="form-group">
                    <label>독자 대상</label>
                    <input type="text" class="form-control" name="target" required>
                </div>
                <div class="form-group">
                    <label>도서 발매일</label>
                    <input type="date" class="form-control" name="created_at" required>
                </div>
                <div class="form-group">
                    <label>예약 가능 요일</label>
                    <select name="pos_week" class="form-control" required>
                        <option value="0">일요일</option>
                        <option value="1">월요일</option>
                        <option value="2">화요일</option>
                        <option value="3">수요일</option>
                        <option value="4">목요일</option>
                        <option value="5">금요일</option>
                        <option value="6">토요일</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>예약 가능 시간</label>
                    <div class="align-center">
                        <select name="pos_starttime" id="pos_starttime" class="form-control" style="width: calc(50% - 25px)" required>
                            <?php for($i = 0; $i <= 23; $i++):?>
                                <option value="<?=$i?>:00"><?=$i?>:00</option>
                            <?php endfor;?>
                        </select>
                        <div class="text-center" style="width: 50px;"> ~ </div>
                        <select name="pos_endtime" id="pos_endtime" class="form-control" style="width: calc(50% - 25px)" required>
                        <?php for($i = 0; $i <= 23; $i++):?>
                            <option value="<?=$i?>:00"><?=$i?>:00</option>
                        <?php endfor;?>
                        </select>
                    </div>
                </div>
                <div class="form-group mt-3 text-right">
                    <button class="btn-bordered">등록 완료</button>
                </div>
            </form>
        </div>
        <div class="col-lg-8">
            <hr class="bg-green">
            <div class="title text-green">예약 목록</div>
            <form id="search" class="bg-light border p-2 d-center rounded mt-4">
                <select name="search_type" class="form-control mr-2 fx-n2" style="width: auto;">
                    <option value="book_name" <?=$search_type == "book_name" ? "selected" : "" ?>>책 제목</option>
                    <option value="writer_name" <?=$search_type == "writer_name" ? "selected" : "" ?>>작가</option>
                </select>
                <input type="text" name="keyword" class="form-control fx-n2" placeholder="검색어를 입력하세요" value="<?=$keyword?>">
                <button class="icon ml-2 text-green">
                    <i class="fa fa-search"></i>
                </button>
            </form>
            <div class="t-head mt-4">
                <div class="cell-30">책 제목</div>
                <div class="cell-15">예약자 명</div>
                <div class="cell-15">작가 명</div>
                <div class="cell-20">예약일</div>
                <div class="cell-20">-</div>
            </div>
            <?php foreach($reserves as $reserve):?>
                <div class="t-row" onclick="location.href='/reserve-detail/<?=$reserve->id?>'">
                    <div class="cell-30"><?=enc($reserve->book_name)?></div>
                    <div class="cell-15"><?=$reserve->user_name?></div>
                    <div class="cell-15"><?=enc($reserve->writer_name)?></div>
                    <div class="cell-20"><?=$reserve->rdate?></div>
                    <div class="cell-20"><a href="/active/reserves/<?=$reserve->id?>" class="btn-filled"><?=$reserve->status ? '예약완료' : '대기중'?></a></div>
                </div>
            <?php endforeach;?>
        </div>
    </div>
</div>