<?php
include "./userAgents.php";
require "./functions.php";

$requests_mode = $_SERVER['REQUEST_METHOD'];
consolePrint($requests_mode);

if ($requests_mode === "POST") {
    if (!empty($_POST["pass"])) {
        $password = $_POST["pass"];
        if ($password == "2010") {
            $html = '
            <html>
            <body>
                <h1>Welcome to proxy.</h1>
        
                <form action="./" method="post">
                    <input type="text" name="url" placeholder="URL">
                    <input type="submit" value="Go">
                </form>
            </body>
            </html>
            ';
            echo $html;
        } else {
            header("Location: ./?auth=no");
        }
    } else {
        $Target_url = $_POST["url"];
        consolePrint("URL is " . addslashes($Target_url));

        if (isURL($Target_url)) {
            consolePrint('Curl init.');
            curl_init($Target_url);
            $userAgent = array_rand($userAgents);
            consolePrint("User agent: " . addslashes($userAgent));
            $response = request($Target_url, $userAgent);
            // Get here url

            $currentURL = $Target_url;
            $lastChar = substr($currentURL, -1);
            if ($lastChar == "/") {
                $currentURL = substr_replace($currentURL, "", -1);
            }
            $parsed_url = parse_url($currentURL);
            $base_url = $parsed_url['scheme'] . '://' . $parsed_url['host'];

            // Begin requests
            $html = str_replace('="http', '="./import.php?url=http', $response);
            $html = str_replace('href="/', "href=\"./import.php?url=$base_url/", $html);
            $html = str_replace('src="/', "src=\"./import.php?url=$base_url/", $html);
            $html = str_replace('action="/', "action=\"./import.php?url=", $html);
            $html = str_replace('action="//', "action=\"./import.php?url=https://", $html);
            if (strpos($html, "<form ") && !strpos($html, "method=")) {
                $html = str_replace('<form ', '<form method="get" ', $html);
            }
            //$html = str_replace('href="/', "href=\"/Proxy/import.php?url=$base_url/", $html);
            //$html = str_replace('href="./', "href=\"/Proxy/import.php?url=$currentURL/", $html);
            echo $html;
        } else {
            consolePrint("This isn't url.");
            alert("This is not url.Please input url.");
            //header("Location: ./");
        }
    }
}
if ($requests_mode == "GET") {
    consolePrint("Mode: controller.");
    if (!isset($_GET["auth"])) {
        $html = '
        <html>
        <body>
            <form action="./" method="post">
                <h1>Login</h1>
                <input name="pass" type="password" id="pass" placeholder="Password">
                <input type="submit" value="Try" id="enter">
            </form>
        <body>
        ';
    } else {
        $html = '
        <html>
        <body>
            <form action="./" method="post">
                <h1 style="color: red">Login - Incorrect password</h1>
                <input name="pass" type="password" id="pass" placeholder="Password">
                <input type="submit" value="Try" id="enter">
            </form>
        <body>
        ';
    }



    echo $html;
    consolePrint("END");
}
?>