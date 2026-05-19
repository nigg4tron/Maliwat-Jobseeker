<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form method="POST">
    <input type="url" name="url" required>
    <button type="submit">Check URL</button>
</form>
</body>
</html>
<?php
if (isset($_POST['url'])) {
    $url = $_POST['url'];

    if (filter_var($url, FILTER_VALIDATE_URL) &&
        (str_starts_with($url, "http://") || str_starts_with($url, "https://"))) {
        echo "Valid URL";
    } else {
        echo "Invalid URL (must start with http or https)";
    }
}
?>

