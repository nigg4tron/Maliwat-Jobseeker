<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form method="POST">
    <textarea name="comment"></textarea>
    <br>
    <button type="submit">Submit Comment</button>
</form>
</body>
</html>

<?php
if (isset($_POST['comment'])) {
    $comment = $_POST['comment'];

    $comment2 = htmlspecialchars($comment);
    echo $comment2;
}
?>


