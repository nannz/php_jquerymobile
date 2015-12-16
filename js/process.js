
// left: 37, up: 38, right: 39, down: 40,
// spacebar: 32, pageup: 33, pagedown: 34, end: 35, home: 36
var keys = {37: 1, 38: 1, 39: 1, 40: 1};
var scrollState = true;
function preventDefault(e)
{
    e = e || window.event;
    if (e.preventDefault)
        e.preventDefault();
    e.returnValue = false;
}
function preventDefaultForScrollKeys(e)
{
    if (keys[e.keyCode])
    {
        preventDefault(e);
        return false;
    }
}


//Global variable list
var poetry="\
    [00:29.40]Two roads <span>diverged</span> in a yellow wood,\
    [00:34.79]And sorry I could not travel both\
    [00:38.39]And be one traveler, long I stood\
    [00:42.80]And looked down one as far as I could\
    [00:47.40]To where it <span>bent</span> in the undergrowth;\
    [00:53.20]Then took the other, as just as <span>fair</span>,\
    [00:57.39]And having perhaps <span>the better claim</span>,\
    [01:00.80]Because it was <span>grassy</span> and <span>wanted wear</span>;\
    [01:04.59]Though as for that the passing there  Had really <span>worn</span> them about the same,<br>\
    [01:15.90]And both that morning equally lay\
    [01:20.90]In leaves no step had <span>trodden</span> black.\
    [01:26.00]Oh, I kept the first for another day!\
    [01:32.00]Yet knowing how way leads on to way,  I doubted if I <span>should</span> ever come back.<br>\
    [01:43.39]I shall be telling this with a <span>sigh</span>\
    [01:46.00]Somewhere ages and ages hence:\
    [01:51.60]Two roads diverged in a wood, and I-\
    [01:57.20]I took the one less traveled by,\
    [02:03.00]And that has made all the difference.<br>";

//sessionStorage from HTML5
if(!sessionStorage.time)
{
    sessionStorage.time=0;
}
var $body = $('body');
var timeArray=new Array();
var lyricsArray=new Array();
//use scrollState to manage scrolling gesture and avoid multiple input

//Parse the lyrics and separate time and lyrics
//Put time into timeArray and access by timeArray[i]
//Put lyrics into lyricsArray and access by lyricsArray[i]
//Lyrics format [00:00.00]
function parse(lrc)
{
    str=lrc.split("[");
    //str[0]=""
    //str[1]="xx:xx.xx]lyrics1"
    //str[2]="yy:yy.yy]lyrics2"
    //Skip str[0]
    for(var i=1;i<str.length;i++)
    {
        //str[i] format is 00:11.22]x
        //time format is 00:11.22
        var time=str[i].split(']')[0];
        //lyrics format is "x"
        var lyrics=str[i].split(']')[1];
        var minute=time.split(":")[0];
        var second=time.split(":")[1];
        //xx:xx.xx is converted into total seconds
        var sec=parseInt(minute)*60+parseInt(second);
        //save total seconds
        timeArray[i-1]=sec-sessionStorage.time;
        //save lyrics
        lyricsArray[i-1]=lyrics;
    }
    var allLyrics=document.getElementById("poemContent");
    var counter = 0;
    for(var i=0;i<timeArray.length;i++) {
        allLyrics.innerHTML += '<p class="sentence" id="' + i + '">' + lyricsArray[i] + '</p>';

    }


}



//pausing() pause the audio and change the button picture and enable scroll
function pausing()
{
    //enableScroll();
    var btn = document.getElementById('playBtn');
    var $audio = document.getElementById('poemAudio');
    $audio.pause();
    btn.src = "image/play.svg";
}
//showSentence() controls the tabs and cards of poetry sentence
function showSentence()
{

    var i = getCurrent();
    if($('#'+i).find('span'))
    {
        var sentence = $('#'+i);
        var word,keyword;
        //sentence.find('span').each(function()
        //{
        //    keyword = $(this).text();
        //    word = keyword.charAt(0).toUpperCase() + keyword.slice(1);
        //    var index = wordList.indexOf(word);
        //    $('#tab'+index).show();
        //});
        $('.tab').click(function ()
        {
            clearTimeout($.data(this,'clickTimer'));
            var tabId = $(this).attr("id");
            tabId = tabId.slice(tabId.length-1);
            var cardId = '#card' + tabId;
            $.data(this,'clickTimer',setTimeout(function()
            {
                if($(cardId).is(':visible'))
                {

                    $('.card').hide();
                    $('.tab').removeClass('active');
                }
                else
                {
                    pausing();

                    $('.tab').removeClass('active');
                    $('#tab'+tabId).addClass('active');
                    $('.card').hide();
                    $(cardId).show();
                }
            },100));
        });
    }
}
//showSection() controls the tabs and cards of section comment
function showSection()
{

    var index = $('.flag.active').attr('id').slice(4);
    var $tab = $('#sectab'+index);
    $tab.show();
    $tab.click(function()
    {
        clearTimeout($.data(this,'clickTimer2'));
        $.data(this,'clickTimer2',setTimeout(function()
        {
            var cardId = '#seccard'+index;
            if($(cardId).is(':visible'))
            {

                $('.secCard').hide();
                $tab.removeClass('active');
            }
            else
            {
                pausing();

                $('.secTab').removeClass('active');
                $tab.addClass('active');
                $('.secCard').hide();
                $(cardId).show();
            }
        },100));
    });
}
function update()
{
    var audio = document.getElementById('poemAudio');
    //tap true stands for user has tapped a sentence
    $('.sentence,.sentence span').click(function(event)
    {
        var index = ($(event.target).is('span')) ? $(event.target).parent().attr('id') : event.target.id;
        var time = timeArray[index];
        pausing();
        audio.currentTime = time;
        highlight($('#'+index));
        setCenter($('#'+index));
        showSentence();
    });
    $('.flag').click(function(event)
    {
        pausing();
        highlight($(this));
        setCenter($(this));
        showSection();
    });
    //get the current sentence and highlight
    var i = getCurrent();
    //when audio paused it's always in the reading mode
    if (audio.paused)
    {
        $('.sentence, .sentence span').click(function(event)
        {
            var index = ($(event.target).is('span')) ? $(event.target).parent().attr('id') : event.target.id;
            var time = timeArray[index];
            pausing();
            audio.currentTime = time;
            highlight($('#'+index));
            setCenter($('#'+index));
            showSentence();
        });
        $('.flag').click(function(event)
        {
            highlight($(this));
            setCenter($(this));
            showSection();
        });
    }
    //when audio is playing, detect the scrolling gesture
    else
    {

        highlight($('#'+i));
        setCenter($('#'+i));
        showSentence();
    }
    $('.sentence').onclick = null;


}
function highlight($target)
{
    $('.sentence').removeClass('active');
    $('.flag').removeClass('active');
    if($target !== null)
    {
        $target.addClass('active');
    }
}
//center the playing sentence on screen
function setCenter($target)
{
    //$(window).scrollTo(0,($target.offset().top - window.innerHeight / 2));
    if($target.length>0)
    {
        $body.stop().animate
        (
            {'scrollTop': ($target.offset().top - window.innerHeight / 2)},
            600, "linear"
        );
    }
}
//Sidebar button controlling the audio
function btnControl()
{
    var $audio = document.getElementById('poemAudio');
    if($audio.paused === false)
    {
        pausing();
    }
    else
    {
        var btn = document.getElementById('playBtn');
        $audio.play();
        btn.src = "image/pause.gif";
    }
}
//Compare the audio time with lyrics time and get current lyrics
function getCurrent()
{
    var au=document.getElementById("poemAudio");
    var allLyrics=document.getElementById("poemContent");
    var i=0;
    if(au.currentTime>=timeArray[timeArray.length-1])
    {
        return timeArray.length-1;
    }
    if(timeArray[0]<=au.currentTime && timeArray[1]>=au.currentTime)
    {
        return 0;
    }
    for(i=1;i<timeArray.length;i++)
    {
        if(timeArray[i]>au.currentTime)
        {
            return i-1;
        }
    }
    return i-2;
}
//Run
$(function()
{
    parse(poetry);
    //Timer will update lyrics every 1 second
    setInterval(update,1000);
    //hide jquery mobile loading message
    $.mobile.loading( "hide");
    $.mobile.loading().hide();
});