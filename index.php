<!DOCTYPE html>
<html>
<head>
    <title>Forum</title>
    <script src="http://code.jquery.com/jquery-2.1.4.min.js"></script>
</head>
<body>
    

    <div>
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

    <div>
        <?php include 'list-comments.php'; ?>
    </div>

</body>
</html>