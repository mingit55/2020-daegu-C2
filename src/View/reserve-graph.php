<style>
    .field {
        width: 578px;
        border: 1px solid #ddd;
        display: flex;
        flex-wrap: wrap;
    }
    .field__item {
        display: flex;
        line-height: 30px;
        padding: 10px;
    }
    .field__item .color {
        width: 30px;
        height: 30px;
        margin-right: 0.5em;
    }
</style>

<div class="hx-300 position-relative">
    <div class="background background--black">
        <img src="/images/visual/1.jpg" alt="비주얼 이미지">
    </div>
    <div class="position-center text-center mt-4">
        <div class="fx-7 text-white font-weight-bold">관리자 예약 현황</div>
        <div class="fx-n1 text-gray mt-2">
            전주독서대전
            <i class="fa fa-angle-right"></i>
            관리자 예약 현황
        </div>
    </div>
</div>

<div class="container py-5">
    <form class="d-between mb-5 align-items-start">
        <div class="field">
            
        </div>
        <select name="type" id="type" class="form-control" style="width: 200px;">
            <option value="writer_name" <?= $type == "writer_name" ? "active" : "" ?>>필터: 작가명</option>
            <option value="school" <?= $type == "school" ? "active" : "" ?>>필터: 학년별</option>
        </select>
    </form>
    <div class="fx-2 mb-2">막대 그래프</div>
    <div class="mt-2 w-100 mb-4">
        <img id="bar-graph" class="fit-contain border">
    </div>
    <div class="fx-2 mb-2">원형 그래프</div>
    <div class="mt-2 w-100 mb-4">
        <img id="circle-graph" class="fit-contain border">
    </div>
</div>

<script>
    $("#type").on("change", e => {
        $(e.target).closest("form").submit();
    });

    let data = <?= json_encode($data); ?>;
    data = data.map(item => ({...item, color: "#" + Math.floor(Math.random() * 0xffffff).toString(16)}));

    data.forEach(item => {
        addField(item.name, item.color);
    });

    let canvas = document.createElement("canvas");
    canvas.width = 1000;
    canvas.height = 500;
    let ctx = canvas.getContext("2d");

    // 막대 그래프
    ctx.clearRect(0, 0, canvas.width, canvas.height);

    let max = data.reduce((p, c) => Math.max(p, c.count), 0);
    let barWidth = 30;
    let barSpace = (canvas.width - barWidth * data.length) / (data.length + 1);
    for(let i = 0; i < data.length; i ++){
        let item = data[i];
        let barHeight = canvas.height * item.count / max;
        let x = (i + 1) * barSpace + i * barWidth;
        let y = canvas.height - barHeight;

        ctx.fillStyle = item.color;
        ctx.fillRect(x, y, barWidth, barHeight);
    }

    $("#bar-graph").attr("src", canvas.toDataURL("image/png"));

    // 원형 그래프
    ctx.clearRect(0, 0, canvas.width, canvas.height);
    let total = data.reduce((p, c) => p + parseInt(c.count), 0);

    let totalAngle = 0;
    for(let i = 0; i < data.length; i ++){
        let item = data[i];
        let angle = Math.PI * 2 * item.count / total;

        ctx.beginPath();
        ctx.fillStyle = item.color;
        ctx.moveTo(canvas.width / 2, canvas.height / 2);
        ctx.arc(canvas.width / 2, canvas.height / 2, canvas.height / 2, totalAngle, totalAngle + angle);
        ctx.fill();

        totalAngle += angle;
    }
    $("#circle-graph").attr("src", canvas.toDataURL("image/png"));

    function addField(text, color){
        $(".field").append(`<div class="field__item">
                                <div class="color" style="background-color: ${color};"></div>
                                <div class="text">${text}</div>
                            </div>`);
    }
</script>