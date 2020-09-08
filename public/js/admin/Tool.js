class Tool {
    constructor(editor){
        this.editor = editor;
        this.canvas = editor.canvas;        
        this.ctx = this.canvas.getContext("2d");
    }

    get page(){
        return this.editor.page;
    }

    update(){
        this.editor.update();
    }

    getXY({pageX, pageY}){
        let {left, top} = this.editor.$workspace.offset();
        let width = this.editor.$workspace.width();
        let height = this.editor.$workspace.height();

        let x = pageX - left < 0 ? 0 : pageX - left > width ? width : pageX - left;
        let y = pageY - top < 0 ? 0 : pageY - top > height ? height : pageY - top;

        return [x, y];
    }
}