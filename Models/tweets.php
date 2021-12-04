<?php
///////////////////////////////////////
// ツイートデータを処理
///////////////////////////////////////

/**
 * ツイート作成
 *
 * @param array $data
 * @return bool
 */
function createTweet(array $data)//引数＝データ
{
    // DB接続
    $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    // 接続エラーがある場合->処理停止
    if ($mysqli->connect_errno) {
        echo 'MySQLの接続に失敗しました。：' . $mysqli->connect_error . "\n";
        exit;
    }

    // 新規登録のSQLクエリを作成
    $query = 'INSERT INTO tweets (user_id, body, image_name) VALUES (?,?,?)';//ユーザーidとbody（本文）とimage_name（画像のファイル名）をセット

    // プリペアドステートメントにクエリを登録
    $statement = $mysqli->prepare($query);

    // プレースホルダにカラム値を紐付け(i=int, s=string)
    $statement->bind_param('iss',$data['user_id'], $data['body'], $data['image_name']);//user_idはint型、bodyとimage_nameはstring型にしたいのでissと入れる

    // クエリを実行
    $response = $statement->execute();
    if($response === false){
        echo 'エラーメッセージ:'. $mysqli->error . "\n";
    }

    // DB接続を解放
    $statement->close();
    $mysqli->close();
 
    return $response;
}