<div class="hx-300 position-relative">
    <div class="background background--black">
        <img src="/images/visual/1.jpg" alt="비주얼 이미지">
    </div>
    <div class="position-center text-center mt-4">
        <div class="fx-7 text-white font-weight-bold">회원가입</div>
        <div class="fx-n1 text-gray mt-2">
            전주독서대전
            <i class="fa fa-angle-right"></i>
            회원가입
        </div>
    </div>
</div>


<div class="container py-5">
    <div class="col-6 mx-auto">
        <form id="sign-up" action="/sign-up" method="post">
            <div class="form-group">
                <label>이메일</label>    
                <input type="text" class="form-control" name="user_email" required>
            </div>
            <div class="form-group">
                <label>비밀번호</label>
                <input type="password" class="form-control" name="password" minlength="4" required>
            </div>
            <div class="form-group">
                <label>비밀번호 확인</label>
                <input type="password" class="form-control" name="passconf" required>
            </div>
            <div class="form-group">
                <label>이름</label>
                <input type="text" class="form-control" name="user_name" required>
            </div>
            <div class="form-group">
                <label>성별</label>
                <select name="gender" class="form-control" required>
                    <option value="남">남</option>
                    <option value="여">여</option>
                </select>
            </div>
            <div class="form-group">
                <label>나이</label>
                <input type="number" class="form-control" name="age" min="1" required>
            </div>
            <div class="form-group">
                <label>재학 학교</label>
                <select name="school" class="form-control" required>
                    <option value="초등학교">초등학교</option>
                    <option value="중학교">중학교</option>
                    <option value="고등학교">고등학교</option>
                </select>
            </div>
            <div class="form-group">
                <label>캡챠</label>
                <div class="w-100 border mb-2">
                    <img id="captcha" class="fit-cover">
                </div>
                <input type="text" id="input" class="form-control" required>
            </div>
            <div class="form-group mt-3 d-between">
                <p>이미 가입을 하셨나요? <a href="/sign-in">로그인</a></p>
                <button class="btn-filled">회원가입</button>
            </div>
        </form>
    </div>
</div>

<script>
    let canvas = document.createElement("canvas");
    canvas.width = 400;
    canvas.height = 50;
    let ctx = canvas.getContext("2d");
    
    let str = "qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM1234567890";
    let strlen = 5;
    let captcha = "";
    for(let i = 0; i < strlen; i ++){
        let idx = parseInt(Math.random() * (str.length - 1));
        captcha += str[idx];
    }   
    ctx.fillText(captcha, canvas.width / 2, canvas.height / 2);
    $("#captcha").attr("src", canvas.toDataURL("image/png"));
    
    $("#sign-up").on("submit", e => {
        e.preventDefault();

        if( $("#input").val() !== captcha ) {
            alert("캡챠를 잘못 입력하였습니다.");
            return;
        }

        $("#sign-up")[0].submit();
    });
</script>