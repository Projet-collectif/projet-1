$('.form-textarea').trumbowyg({ 
    lang: $('html').attr('lang'),
    btns: [
            ['undo', 'redo'],
            ['emoji'],
            ['table'],
            ['fontsize'],
            ['fontfamily'],
            ['lineheight'],
            ['historyUndo','historyRedo'],
            ['foreColor', 'backColor'],
            ['formatting'],
            ['link'],
            ['strong', 'em', 'del'],
            ['justifyLeft', 'justifyCenter', 'justifyRight', 'justifyFull'],
            ['unorderedList', 'orderedList'],
            ['horizontalRule'],
            ['removeformat'],
            ['viewHTML'],
            ['fullscreen']
        ],
});