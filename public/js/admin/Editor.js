class Editor {
    constructor(book){
        this.$root = this.getLayout();
        this.$workspace = this.$root.find(".workspace");
        this.book = book;

        this.canvas = document.createElement("canvas");
        this.canvas.classList.add("page__item");
        this.canvas.width = 1000;
        this.canvas.height = 800;
        this.canvas.style.left = "0";
        this.canvas.style.top = "0";
        

        this.pages = [];
        this.index = 0;

        this.tools = {
            line: new Line(this),
            rect: new Rect(this),
            triangle: new Triangle(this),
            circle: new Circle(this),
            text: new Text(this),
            eraser: new Eraser(this),
        }
        this.selected = null;
        
        this.init().then(() => {
            this.setEvents();
        });
    }
    get styleColor(){
        return $("#styleColor").val();
    }
    get fontSize(){
        return $("#fontSize").val();
    }
    get lineWidth(){
        return $("#lineWidth").val();
    }
    get width(){
        return this.$workspace.width();
    }
    get height(){
        return this.$workspace.height();
    }
    get page(){
        return this.pages[this.index];
    }
    get tool(){
        return this.tools[this.selected];
    }

    async init(){
        // 책 커버 페이지
        let page__image = new Page(this);
        let cover_url = "./images/books/" + this.book.image;
        let image = await new Promise(res => {
            let img = new Image();
            img.src = cover_url;
            img.onload = () => res(img);
        });
        page__image.addImage( cover_url, this.width / 2 - image.width / 2, this.height / 2 - image.height / 2 );

        this.pages.push(page__image);

        // 책 소개 페이지
        let page__intro = new Page(this);
        let intro_url = "./images/intro.jpg";
        page__intro.addImage( intro_url, 0, 0 );

        this.pages.push(page__intro);

        // 동영상 페이지
        let page__video = new Page(this);
        page__video.addVideo("./video/ex.mp4", 0, 0);

        this.pages.push(page__video);
    }

    // 화면 업데이트
    update(){
        if(!this.page) return;
        this.$workspace.html(this.page.outerHTML);
        this.$workspace[0].append(this.canvas);
        $(".page__count").text(`페이지 ${this.index + 1}/${this.pages.length}`);
    }

    // 열기
    open(){
        $(".editor").remove();
        $(document.body).append(this.$root);
    }

    // 닫기
    close(){
        $(".editor").remove();
    }

    // 이벤트 설정
    setEvents(){
        // 도구 선택
        this.$root.on("click", "[data-role].tool__item", e => {
            this.selected = e.currentTarget.dataset.role;

            $(".tool__item.active").removeClass("active");
            $(e.currentTarget).addClass("active");
        });

        // 팝업창 닫기
        this.$root.on("click", ".btn-close", this.close);

        // 이전 페이지 이동
        this.$root.on("click", ".btn-prev", e => {
            this.index = this.index - 1 <= 0 ? 0 : this.index - 1;
            this.update();
        });

        // 다음 페이지 이동
        this.$root.on("click", ".btn-next", e => {
            this.index = this.index + 1 >= this.pages.length ? this.pages.length - 1 : this.index + 1;
            this.update();
        });

        // 페이지 생성
        this.$root.on("click", ".btn-create", e => {
            this.pages.push(new Page(this));
            this.index = this.pages.length - 1;
            this.update();
        });

        // 마우스 이벤트
        this.$workspace.on("mousedown", e => {
            if(this.imageURL){
                this.page.addImage(this.imageURL, e.offsetX, e.offsetY)
                this.imageURL = null;
            } 
            else if(this.videoURL){
                this.page.addVideo(this.videoURL, e.offsetX, e.offsetY);
                this.videoURL = null;
            }
            else if(e.which === 1 && this.tool && this.tool.onmousedown){
                this.tool.onmousedown(e);
            }
        });
        this.$workspace.on("mousemove", e => {
            if(e.which === 1 && this.tool && this.tool.onmousemove){
                this.tool.onmousemove(e);
            }
        });
        $(window).on("mouseup", e => {
            if(e.which === 1 && this.tool && this.tool.onmouseup){
                this.tool.onmouseup(e);
            }
        });

        // 파일 이벤트
        this.$root.on("change", "#upload__image", e => {
            this.selected = null;
            $(".tool__item").removeClass("active");

            let file = e.target.files.length > 0 ? e.target.files[0] : null;
            if(file){
                let reader = new FileReader();
                reader.onload = () => {
                    this.imageURL = reader.result;
                };
                reader.readAsDataURL(file);
            }
            e.target.value = ""
        });
        this.$root.on("change", "#upload__video", e => {
            this.selected = null;
            $(".tool__item").removeClass("active");
            
            let file = e.target.files.length > 0 ? e.target.files[0] : null;
            if(file){
                let reader = new FileReader();
                reader.onload = () => {
                    this.videoURL = reader.result;
                };
                reader.readAsDataURL(file);
            }
            e.target.value = ""
        });


        // HTML 다운로드
        this.$root.on("click", ".btn-download", e => {
            let htmlPages = this.pages.map(item => item.outerHTML);

            let html = `<!DOCTYPE html>
                            <html lang="en">
                            <head>
                                <meta charset="UTF-8">
                                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                                <title>Document</title>
                                <style>
                                    .page {
                                        position: relative;
                                        overflow: hidden;
                                        width: 1000px;
                                        height: 800px;
                                    }
                                    .page__item {
                                        position: absolute;
                                        pointer-events: none;
                                    }
                            
                                    .page__video {
                                        position: relative;
                                        background-color: #000;
                                    }
                                    .page__video video {
                                        max-width: 100%;
                                        max-height: 100%;
                                    }
                                    .page__video input {
                                        position: absolute;
                                        right: 1em; bottom: 1.5em;
                                        width: calc(100% - 80px - 3em);
                                    }
                                    .page__video button {
                                        position: absolute;
                                        left: 1em; bottom: 1em;
                                        background-color: #fff;
                                        font-size: 0.9em;
                                        text-align: center;
                                        line-height: 40px;
                                        width: 80px;
                                        height: 40px;
                                    }
                                </style>
                            </head>
                            <body>
                                ${htmlPages.join('')}
                            </body>
                            </html>`;
            let blob = new Blob([html], {type: "text/html"});
            let a = document.createElement("a");
            a.href = URL.createObjectURL(blob);
            a.download = this.book.name + ".html";
            a.click();
        });
    }

    getLayout(){
        return $(` <div class="editor">
                        <div class="d-between p-3 mb-3 border-bottom">
                            <div>
                                <span class="page__count">페이지 1/3</span>
                                <button class="btn-create btn-bordered ml-3">새 페이지</button>
                                <button class="btn-prev btn-filled ml-1">이전</button>
                                <button class="btn-next btn-filled ml-1">다음</button>
                            </div>
                            <button class="btn-close btn-filled">닫기</button>
                        </div>
                        <div class="p-3">
                            <div class="tool">
                                <button class="tool__item" data-role="line">선</button>
                                <button class="tool__item" data-role="rect">사각형</button>
                                <button class="tool__item" data-role="circle">원형</button>
                                <button class="tool__item" data-role="triangle">삼각형</button>
                                <button class="tool__item" data-role="text">텍스트</button>
                                <button class="tool__item" data-role="eraser">지우개</button>
                                <label class="tool__item" for="upload__image">사진선택</label>
                                <label class="tool__item" for="upload__video">영상선택</label>
                                <input type="file" id="upload__image" accept="image/*" hidden>
                                <input type="file" id="upload__video" accept="video/*" hidden>
                            </div>
                            <div class="align-center py-3 fx-n2">
                                <div class="mr-4">
                                    <span class="mr-2">색상</span>
                                    <input type="color" id="styleColor" class="border">
                                </div>
                                <div class="mr-4">
                                    <span class="mr-2">선두께</span>
                                    <input type="number" id="lineWidth" value="1" class="border">
                                </div>
                                <div class="mr-4">
                                    <span class="mr-2">폰트크기</span>
                                    <input type="number" id="fontSize" value="16" class="border">
                                </div>
                            </div>
                            <div class="workspace mt-4">
                    
                            </div>
                        </div>
                        <div class="p-3">
                            <button class="btn-download btn-filled">html문서로저장</button>
                            <button class="btn-borderd ml-2">pdf문서로저장</button>
                        </div>
                    </div>`);
    }
}