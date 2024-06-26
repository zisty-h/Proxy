<?php
function request($url, $userAgent)
{
    // cURLセッションを初期化
    $ch = curl_init();

    // cURLオプションを設定
    curl_setopt($ch, CURLOPT_URL, $url); // リクエストするURLを設定
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // レスポンスを文字列で返すように設定
    curl_setopt($ch, CURLOPT_USERAGENT, $userAgent); // ユーザーエージェントを設定

    // リクエストを実行し、レスポンスを取得
    $response = curl_exec($ch);

    // エラーが発生した場合はエラーメッセージを表示
    if (curl_errno($ch)) {
        echo 'Error:' . curl_error($ch);
    }

    // cURLセッションを終了
    curl_close($ch);

    return $response;
}

function consolePrint($text)
{
    echo '<script>console.log("' . addslashes($text) . '");</script>';
    return;
}

function isURL($target)
{
    $needWords = [
        "http://",
        "https://",
    ];

    $isInclude = false;
    foreach ($needWords as $word) {
        if (strpos($target, $word) !== false) {
            $isInclude = true;
            break;
        }
    }
    consolePrint($isInclude);
    return $isInclude;
}

function alert($text)
{
    echo '<script>alert("' . addslashes($text) . '");</script>';
}

function post($target, $postData){
    $ch = curl_init($target);

    // cURLオプションを設定
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // レスポンスを文字列として返す
    curl_setopt($ch, CURLOPT_POST, true); // POSTリクエストを指定
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postData); // POSTデータを設定

    // リクエストを実行し、レスポンスを取得
    $response = curl_exec($ch);

    // エラーチェック
    if (curl_errno($ch)) {
        echo 'cURL error: ' . curl_error($ch);
    }

    // cURLセッションを終了
    curl_close($ch);

    return $response;
}
?>