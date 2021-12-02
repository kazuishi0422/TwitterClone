<?php
///////////////////////////////////////
// ユーザーデータを処理
///////////////////////////////////////

/**
 * ユーザーを作成
 *
 * @param array $data
 * @return bool
 */
function createUser(array $data)
{
    // DB接続 $mysqliに接続結果のオブジェクトが入ってくる
    $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

    // 接続エラーがある場合->処理停止
    if($mysqli->connect_errno){
        echo 'MySQLの接続に失敗しました。:'. $mysqli->connect_error . "\n";//$mysqli->connect_errorでエラー表示する
        exit;//強制終了
    }

    // 新規登録のSQLクエリを作成
    $query = 'INSERT INTO users (email, name, nickname, password) VALUES (?, ?, ?, ?)';//(?, ?, ?, ?)プレースホルダーあとで値を入れられる　SQLインジェクション対策をしている

    // プロペアドステーメントに、作成したクエリを登録
    $statement = $mysqli->prepare($query);

    // パスワードをハッシュ値に変換
    $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);//password_hash＝パスワードを暗号のような文字列に変換する（データを覗かれてもわからないようにする）

    // クエリのプレースホルダ（？の部分）にカラム値を紐付け
    $statement->bind_param('ssss', $data['email'], $data['name'], $data['nickname'], $data['password']);//'ssss'=ストリング型になる(１つ目が第二引数、２つ目が第三引数・・となる)27行目の$statementの$queryのプレースホルダーに値を入れる

    // クエリを実行
    $response = $statement->execute();//executeメソッドで返る値はbool値になる

    // 実行に失敗した場合->エラー表示
    if($response === false){
        echo 'エラーメッセージ:' . $mysqli->error . "\n";
    }

    // DB接続を解放
    $statement->close();
    $mysqli->close();

    return $response;
}

/**
 * ユーザー情報取得：ログインチェック
 *
 * @param string $email
 * @param string $password
 * @return array|false
 */
function findUserAndCheckPassword(string $email, string $password)
{
    // DB接続
    $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

    // 接続エラーがある場合->処理停止
    if ($mysqli->connect_errno) {
        echo 'MySQLの接続に失敗しました。：' . $mysqli->connect_error . "\n";
        exit;
    }

    // 入力値をエスケープ
    $email = $mysqli->real_escape_string($email);//real_escape_stringで$emailにSQL関数が入っていても実行されないようにする

    // SQLクエリを作成
    // - 外部からのリクエストは何が入ってくるかわからないので、必ず、エスケープしたものをクオートで囲む(real_escape_string)
    $query ='SELECT * FROM users WHERE email = "' . $email . '"';//$emailで条件を絞ってSELECTする

    // クエリ実行
    $result = $mysqli->query($query);

    // クエリ実行に失敗した場合->retun
    if (!$result){
        // mySQL処理中にエラー発生
        echo 'エラーメッセージ: ' . $mysqli->error . "\n";
        $mysqli->close();
        return false;
    }

    // ユーザー情報を取得
    $user = $result->fetch_array(MYSQLI_ASSOC);//fetch_arrayメソッドはレコードを１件取得する
    // ユーザーが存在しない場合->return
    if (!$user){
        $mysqli->close();
        return false;
    }

    // パスワードチェック、不一致の場合->return
    if (!password_verify($password, $user['password'])){//$password_verify関数で入力されたパスワードとデータベースに保存されてあったパスワードのハッシュ値を比較して一致するかどうかチェックしている
        $mysqli->close();
        return false;
    }

    // DB接続を解放(上記全てをクリアしたら)
    $mysqli->close();

    return $user;
}