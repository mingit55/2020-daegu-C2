<div class="hx-300 position-relative">
    <div class="background background--black">
        <img src="/images/visual/1.jpg" alt="비주얼 이미지">
    </div>
    <div class="position-center text-center mt-4">
        <div class="fx-7 text-white font-weight-bold">로그인</div>
        <div class="fx-n1 text-gray mt-2">
            전주독서대전
            <i class="fa fa-angle-right"></i>
            로그인
        </div>
    </div>
</div>


<div class="container py-5">
    <div class="col-6 mx-auto">
        <form action="/sign-in" method="post">
            <div class="form-group">
                <label>이메일</label>    
                <input type="text" class="form-control" name="user_email" required>
            </div>
            <div class="form-group">
                <label>비밀번호</label>
                <input type="password" class="form-control" name="password" required>
            </div>
            <div class="form-group mt-3 d-between">
                <p>아직 회원이 아니신가요? <a href="/sign-up">회원가입</a></p>
                <button class="btn-filled">로그인</button>
            </div>
        </form>
    </div>
</div>