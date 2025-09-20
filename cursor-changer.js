 jQuery(document).ready(function($) {
    var cursor = '';

    if (ccData.cursorImage) {
        // Use image cursor if provided
        cursor = 'url(' + ccData.cursorImage + '), auto';
    } else if (ccData.cursorColor) {
        // Use colored dot cursor
        var canvas = document.createElement('canvas');
        canvas.width = 16;
        canvas.height = 16;
        var ctx = canvas.getContext('2d');
        ctx.fillStyle = ccData.cursorColor;
        ctx.beginPath();
        ctx.arc(8, 8, 6, 0, Math.PI * 2);
        ctx.fill();
        cursor = 'url(' + canvas.toDataURL() + ') 8 8, auto';
    }

    if (cursor) {
        $('body, body *').css('cursor', cursor);
    }
});
