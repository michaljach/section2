<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
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
        <input id="input-title" type="text" value="Enter title...">
        <textarea id="input-text">Write something...</textarea>
        <button id="input-save">SAVE</button>
    </body>
</html>