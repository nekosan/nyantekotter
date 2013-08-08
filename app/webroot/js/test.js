
$.getJSONP = function(url, callback, param){
    return $.ajax({
        url: url,
        cache: false,
        dataType: "jsonp",
        success: callback,
    });
}

function update(){
    $.getJSONP('/nyantekotter/users/get_latest_tl', function(d){
        var html = "";
        console.log(d);
        for(var i = 0; i < d.tweets.length; i++){
            html += '<div class="tweet"><div class="tweetheader">';
            html += '<a href="/nyantekotter/users/profile/' + d['tweets'][i]['UserPost']['username'] + '">@' + d['tweets'][i]['UserPost']['username'] + '</a> ';
            html += '<b>' + d['tweets'][i]['UserPost']['name'] + '</b></div>';
            html += '<div class="tweet_content">' + d['tweets'][i]['Post']['content'] + '</div>';
            html += '<div class="tweet_time">' + d['tweets'][i]['Post']['time'] + '</div></div>';
        }

        $(".tweet_field").prepend(html);
    });
}

function get_old_post(){
    $.getJSONP('/nyantekotter/users/get_old_tl', function(d){
        var html = "";
        console.log(d);
        for(var i = 0; i < d.tweets.length; i++){
            html += '<div class="tweet"><div class="tweetheader">';
            html += '<a href="/nyantekotter/users/profile/' + d['tweets'][i]['UserPost']['username'] + '">@' + d['tweets'][i]['UserPost']['username'] + '</a> ';
            html += '<b>' + d['tweets'][i]['UserPost']['name'] + '</b></div>';
            html += '<div class="tweet_content">' + d['tweets'][i]['Post']['content'] + '</div>';
            html += '<div class="tweet_time">' + d['tweets'][i]['Post']['time'] + '</div></div>';
        }

        $(".tweet_field").append(html);
    });
}


$(function(){
    $(".postfield").bind("change keyup", function(){
        var count = 140 - $(this).val().length;
        $(".textnum").text(count);
    });

    $(".postform").submit(function(){
        var d = {content : $('.postfield').val()};

        $.ajax({
            type: 'POST',
            url: '/nyantekotter/users/tweetpost',
            data: d,
            cache: false,
            success: function(data, dataType) {
                $('.postfield').val('');
                $(".textnum").text(140);
                console.log(data);
                update();
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                alert('Error:' + errorThrown);
            }
        });

        return false;
    });

    $("div.get_old_post").on("click", (function(){
        get_old_post();
    }));

    setInterval(update, 5000);
});
