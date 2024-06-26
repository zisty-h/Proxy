<?php
require "./userAgents.php";
require "./functions.php";


$file_url = $_GET["url"];

$response = request($file_url, array_rand($userAgents));
if (strpos($response, "<html") !== false){
    echo "
    <!DOCTYPE html>
    <html lang=\"en\">
    <head>
        <meta charset=\"UTF-8\">
        <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">
        <title>Redirecting...</title>
    </head>
    <body>
        <h1>Please waiting...</h1>
        <form id=\"postForm\" action=\"/Proxy/\" method=\"post\" style'display: none'>
            <input name=\"url\" value=\"$file_url\">
        </form>
        <script type=\"text/javascript\">
            document.getElementById('postForm').submit();
        </script>
    </body>
    </html>
    ";

} else {
    echo $response;
}
?>