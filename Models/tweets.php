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

/**
 * ツイート一覧を取得
 * 
 * @param array $user ログインしているユーザー情報
 * @return array|false
 */
function findTweets(array $user)
{
        // DB接続
        $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        // 接続エラーがある場合->処理停止
        if ($mysqli->connect_errno) {
            echo 'MySQLの接続に失敗しました。：' . $mysqli->connect_error . "\n";
            exit;
        }
    
        // ログインユーザーIDをエスケープ
        $login_user_id = $mysqli->real_escape_string($user['id']);

        // 検索のSQLクエリを作成 SQLが長いときはヒアドキュメントを使う（<<<〇〇〇）テーブル名の後にASをつけると別名をつけることができる(tweetsの別名T)
        $query = <<<SQL
            SELECT
                T.id AS tweet_id,
                T.status AS tweet_status,
                T.body AS tweet_body,
                T.image_name AS tweet_image_name,
                T.created_at AS tweet_created_at,
                U.id AS user_id,
                U.name AS user_name,
                U.nickname AS user_nickname,
                U.image_name AS user_image_name,
                -- ログインユーザーがいいね！したか（いいね！している場合、値が入る）
                L.id AS like_id,
                -- いいね！数 外側に紐づく値があるサブクエリを送還サブクエリという 外側で取得したレコードの数だけサブクエリが実行されるので処理が遅くなる可能性がある
                (SELECT COUNT(*) FROM likes WHERE status = 'active' AND tweet_id = T.id) AS like_count
            FROM
                tweets AS T 
                -- ユーザーテーブルをusers.idとtweets.user.idで紐付ける
                JOIN
                users AS U ON U.id = T.user_id AND U.status = 'active'
                -- いいね！テーブルをlikes.tweet_idとtweets_idで紐づける
                LEFT JOIN
                likes AS L ON L.tweet_id = T.id AND L.status = 'active' AND L.user_id = '$login_user_id'
            WHERE
                T.status = 'active'
        SQL;

        // クエリ実行
        $result = $mysqli->query($query);
        if($result){
            //データを配列で受け取る fetch_allメソッド= 実行結果から全てのレコードを取得するメソッド
            $response = $result->fetch_all(MYSQLI_ASSOC);
        } else{
            $response = false;
            echo 'エラーメッセージ: ' . $mysqli->error . "\n";
        }

        $mysqli->close();

        return $response;
}
