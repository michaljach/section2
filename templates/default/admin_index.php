<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, user-scalable=0">
        <title>section2 - Administration</title>
        <link rel="stylesheet" href="templates/<?=TEMPLATE?>/css/style_admin.css">
        <script type="text/javascript" src="http://code.jquery.com/jquery-1.11.1.min.js"></script>
        <script type="text/javascript">
        $(function(){
            $('#input-save').on('click', function(){
                $.post('', { title: $('#input-title').val(), text: $('#input-text').val() }, function(data){

                }, "json");
            });
        });
        </script>
    </head>
    <body>
        <header>
            <h1>§2</h1>
            <span><a href="logout">Logout</a></span>
        </header>
        <input id="input-title" type="text" value="Enter title...">
        <textarea id="input-text">Write something...</textarea>
        <button id="input-save">SAVE</button>
    </body>
</html>