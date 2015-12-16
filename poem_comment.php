<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>poem</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="http://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.css" />
    <link rel="stylesheet" href="style.css" />
    <!--<script src="js/process.js"></script>-->
    <script src="http://code.jquery.com/jquery-2.1.4.min.js"></script>
    <script src="http://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.js"></script>
    <script>
        //swipe to open/close the panel
        $( document ).on( "pageinit", "#mainpage", function() {
            $( document ).on( "swipeleft swiperight", "#mainpage", function( e ) {
                // We check if there is no open panel on the page because otherwise
                // a swipe to close the left panel would also open the right panel (and v.v.).
                // We do this by checking the data that the framework stores on the page element (panel: open).
                if ( $.mobile.activePage.jqmData( "panel" ) !== "open" ) {
                    if ( e.type === "swipeleft"  ) {
                        $( "#right-panel" ).panel( "open" );
                    } else if ( e.type === "swiperight" ) {
                        $( "#left-panel" ).panel( "open" );
                    }
                }
            });
        });
    </script>
</head>
<body>
<div data-role="page" id="mainpage">
    <div data-role="header" data-theme="b" class="ui-header ui-bar-b" role="banner" id="header">
        <h1 class="ui-title" role="heading" aria-level="1">原诗森林</h1>
        <!-- the icon goes to the side-menu-->
        <a href="#left-panel" data-theme="b"  data-icon="arrow-l" data-iconpos="notext" data-shadow="false" data-iconshadow="false" class="ui-icon-nodisc ui-btn-left ui-btn ui-btn-up-d ui-btn-corner-all ui-btn-icon-notext" data-corners="true" data-wrapperels="span" title="Open left panel">
        <span class="ui-btn-inner">
            <span class="ui-btn-text">Open left panel</span>
            <span class="ui-icon ui-icon-arrow-l"> </span>
        </span>
        </a>
    </div><!--the header -->

    <div class="ui-content">
        <div id="title">
            <dl>
                <dt>The Road Not Taken</dt>
                <dd>—Robert Frost</dd>
            </dl>
        </div><!-- title-->

        <audio id="poemAudio" controls loop>
            <source src="audio/TheRoadNotTaken.mp3" type="audio/mpeg">
        </audio>

        <div class="btn">
            <img id="playBtn" src="image/play.svg" onclick="btnControl()">
        </div>

        <div id="poemContent">
            <!--<p>-->
                <!--Two roads diverged in a yellow wood,<br>-->
                <!--And sorry I could not travel both<br>-->
                <!--And be one traveler, long I stood<br>-->
                <!--And looked down one as far as I could<br>-->
                <!--To where it bent in the undergrowth;<br>-->
                <!--<br>-->
                <!--Then took the other, as just as fair,<br>-->
                <!--And having perhaps the better claim,<br>-->
                <!--Because it was grassy and wanted wear;<br>-->
                <!--Though as for that the passing there<br>-->
                <!--Had worn them really about the same,<br>-->
                <!--<br>-->
                <!--And both that morning equally lay<br>-->
                <!--In leaves no step had trodden black.<br>-->
                <!--Oh, I kept the first for another day!<br>-->
                <!--Yet knowing how way leads on to way,<br>-->
                <!--I doubted if I should ever come back.<br>-->
                <!--<br>-->
                <!--I shall be telling this with a sigh<br>-->
                <!--Somewhere ages and ages hence:<br>-->
                <!--Two roads diverged in a wood, and I—<br>-->
                <!--I took the one less traveled by,<br>-->
                <!--And that has made all the difference.<br>-->
                <!--<br>-->
            <!--</p>-->
        </div>
        <div id="analysisContent">
            <div id="analysisTitle">Analysis</div>
            <p id="analysis">
                The speaker stands in the woods, considering a fork in the road. Both ways are equally worn and equally overlaid with un-trodden leaves. The speaker chooses one, telling himself that he will take the other another day. Yet he knows it is unlikely that he will have the opportunity to do so. And he admits that someday in the future he will recreate the scene with a slight twist: He will claim that he took the less-traveled road.
            </p>
        </div>

        <div id="backgroundContent">
            <div id="backgroundTitle">Background</div>
            <p id="background">
                作者简介：<br>
                Rober Frost<br>
                Robert Frost, 美国诗人。他高中毕业后开始同时干几份工作，教书，送报纸等等，但他始终认为写诗是他发自内心想做的事。
                Robert结婚后，他的祖父为他们买了一个农场。接下来的九年里，Robert一边管理农场，一边写诗。
                农场的生意并不好，Robert便又转做回教师，去英国教书。
                由于一战的缘故，Robert回到美国，也是在这时他写下了这篇The Road Not Taken。
            </p>
        </div>

        <div id="commentContent">
            <div id="commentTitle">Comments</div>
            <div id="form">
                <form id="myForm" method="post">
                    Name: <input id="name" type="text" name="name" />
                    Comment: <textarea id="comment" name="comment"></textarea>
                    <input id="submit" type="submit" value="Submit Comment" />
                </form>
            </div>
            <script>
                $("#submit").click(function(e){
                    console.log("submit");
                    console.log($('#name').val());
                    console.log($('#comment').val());

                    var formData = {
                        'name': $('#name').val(),
                        'comment': $('#comment').val()
                    };
                    console.log("formData ",formData);
                    $.ajax({
                        method: "POST",
                        url: "http://localhost:8888/rest/rest.php/message/",
                        data: formData
                    })
                    .done(function(msg) {
                        console.log("done "+msg);
                    });          
                    e.preventDefault();
                });
        
            </script>
            <div id="commentHistory">
                <?php include 'list-comments.php'; ?>
            </div>
        </div>


       




        <!-- <div data-role="footer">
            <h4>Footer</h4>
        </div> -->
        <footer>
            <p style="color:#fff">原诗森林</p>
            <img width="25%" src="image/team-logo.svg" />
        </footer>

    </div>

    <!--the side menu panel -->
    <div data-role="panel" id="left-panel" data-position-fixed="true" data-theme="b" class="ui-panel ui-panel-position-left ui-panel-display-reveal ui-body-b ui-panel-animate ui-panel-closed" >
        <div class="ui-panel-inner">
            <!--<h1 href="#poemContent">Poem</h1>-->
            <!--<h1 href="#analysis">Analysis</h1>-->
            <!--<h1>Background</h1>-->
            <ul>
                <li><a href="#poemContent">Poem</a></li>
                <li><a href="#analysis">Analysis</a></li>
                <li><a href="#background">Background</a></li>
                <li><a href="#comment">Comments</a></li>
            </ul>

        </div>
    </div><!-- /panel -->


</div>

<script src="js/process.js"></script>
</body>
</html>