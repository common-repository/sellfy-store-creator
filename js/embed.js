function SellfyEmbedListener() {
    var eventMethod = window.addEventListener ? 'addEventListener':'attachEvent',
    eventer = window[eventMethod],
    messageEvent = eventMethod === 'attachEvent' ? 'onmessage' : 'message';
    eventer(messageEvent, function (e) {
        var t = JSON.parse(e.data);
        if (t.sellfy_height) {
            var frames = document.getElementsByTagName('iframe');
            for (var i = 0; i < frames.length; i++) {
                if (frames[i].contentWindow === e.source) {
                    frames[i].height = t.sellfy_height;
                    break;
                }
            }
        }
    }, false);
}
if (!window.SellfyEmbed) {
    window.SellfyEmbed = new SellfyEmbedListener();
}
