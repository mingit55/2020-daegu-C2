class App {
    constructor(){
        this.init();
    }

    async init(){
        this.books = await this.getBooks();
        this.keyword = "";

        this.render();
        this.setEvents();
    }
    
    get searchType(){
        return $("#search select").val();
    }


    // 도서 정보 가져오기
    getBooks(){
        return books.map((book, i) => ({...book, id: i + 1}));
        // return fetch("/json/book.json")
        //     .then(res => res.json())
        //     .then(books => books.map((book, i) => ({...book, id: i + 1})));
    }

    // 화면 업데이트
    render(){
        let viewList = this.books;

        if(this.keyword.length > 0){
            let regex = new RegExp( this.keyword );
            viewList = viewList.filter(item => regex.test(item[this.searchType]));
        }
        
        $("#content").html("");
        viewList.forEach(item => {
            $("#content").append(`<div class="col-lg-3 mb-4">
                                    <div class="item border bg-white p-2" data-id="${item.id}">
                                        <img src="./images/books/${item.image}" alt="책 표지" class="fit-contain hx-300">
                                        <div class="p-3">
                                            <div>
                                                <span class="fx-2">${item.name}</span>
                                            </div>
                                            <div class="mt-2">
                                                <span class="fx-n2 text-muted">카테고리</span>
                                                <span class="fx-n1 ml-2">${item.category}</span>
                                            </div>
                                            <div class="mt-2">
                                                <span class="fx-n2 text-muted">작가</span>
                                                <span class="fx-n1 ml-2">${item.writer}</span>
                                            </div>
                                            <div class="mt-2">
                                                <span class="fx-n2 text-muted">출판사</span>
                                                <span class="fx-n1 ml-2">${item.company}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>`);
        });
    }

    // 이벤트 설정
    setEvents(){
        // 검색 이벤트
        $("#search button").on("click", this.search);
        $("#search input").on("keydown", e => {
            if(e.keyCode === 13)
                this.search(e);
        });

        // 에디터 팝업 이벤트
        $("#content").on("click", ".item", e => {
            let book = this.books.find(book => book.id == e.currentTarget.dataset.id);
            let editor = new Editor(book);
            editor.open();
        });
    }

    // 검색
    search = e => {
        this.keyword = $("#search input").val()
            .replace(/([.+*?^$\(\)\[\]\\\\\\/])/g, "\\$1")
            .replace(/ㄱ/g, "[가-깋]")
            .replace(/ㄲ/g, "[까-낗]")
            .replace(/ㄴ/g, "[나-닣]")
            .replace(/ㄷ/g, "[다-딯]")
            .replace(/ㄸ/g, "[따-띻]")
            .replace(/ㄹ/g, "[라-맇]")
            .replace(/ㅁ/g, "[마-밓]")
            .replace(/ㅂ/g, "[바-빟]")
            .replace(/ㅃ/g, "[빠-삫]")
            .replace(/ㅅ/g, "[사-싷]")
            .replace(/ㅆ/g, "[싸-앃]")
            .replace(/ㅇ/g, "[아-잏]")
            .replace(/ㅈ/g, "[자-짛]")
            .replace(/ㅉ/g, "[짜-찧]")
            .replace(/ㅊ/g, "[차-칳]")
            .replace(/ㅋ/g, "[카-킿]")
            .replace(/ㅌ/g, "[타-팋]")
            .replace(/ㅍ/g, "[파-핗]")
            .replace(/ㅎ/g, "[하-힣]");
        this.render();
    }
}

$(function(){
    let app = new App();
});