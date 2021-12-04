<?php
//////////////////////////////////////
// 便利な関数
//////////////////////////////////////

/**
 * 画像ファイル名から画像のURLを生成する
 * 
 * @param string $name 画像ファイル名
 * @param string $type user | tweet ユーザー名なのか呟きなのか識別する
 * @return string
 */
function buildImagePath(string $name = null, string $type)
{
    if($type === 'user' && !isset($name)){//タイプがユーザーでファイルが存在しない場合
        return HOME_URL . 'Views/img/icon-default-user.svg';//デフォルトの画像をかえす
    }

    return HOME_URL . 'Views/img_uploaded/' . $type . '/' . htmlspecialchars($name);//タイプ名がそのままディレクトリ名に

}

/**
 * 指定した日時からどれだけ経過したかを取得
 * 関数を作成する場合はドックコメントをかく
 * @param string $datetime 日時　
 * @return string
 */
function convertToDayTimeAgo(string $datetime)
{
    $unix = strtotime($datetime);//$unix関数　1970年１月１日０時からの経過秒数を取得　strtotime(エスティアールトゥタイム)関数で日時をunixタイムに変換
    $now = time();//time関数はunixタイム開始から現在までの秒数を返す
    $diff_sec = $now - $unix;//経過秒数を求める

    if ($diff_sec < 60){//経過秒数が６０秒未満の場合
        $time = $diff_sec;
        $unit = '秒前';//何秒前とかえす
    } elseif($diff_sec < 3600){//経過秒数が１時間未満の場合
        $time = $diff_sec / 60;
        $unit = '分前';//何分前とかえす
    } elseif($diff_sec < 86400){//経過秒数が２４時間未満の場合
        $time = $diff_sec / 3600;
        $unit = '時間前';//何時間前とかえす
    } elseif($diff_sec < 2764800){//経過秒数が３２日未満の場合
        $time = $diff_sec / 86400;
        $unit = '日前';//何日前とかえす
    } else{

        if (date('Y') !== date('Y', $unix)){//現在の年と投稿日時が!==(違う)場合は
            $time = date('Y年n月j日',$unix);//年月日をかえす
        } else{
            $time = date('n月j日',$unix);//現在と同じであれば月日をかえす
        }
        return $time;
    }

    return (int)$time . $unit;//(int)型キャスト　型を変換する処理intの場合はintで表せない値は０になり、小数点がある時は切り捨て
}
/**
 * ユーザー情報をセッションに保存
 *
 * @param array $user
 * @return void
 */
function saveUserSession(array $user)
{
    // セッションを開始していない場合
    if(session_status() === PHP_SESSION_NONE) {//session_statusで現在のセッションの状態を確認する　PHP_SESSION_NONE　セッションしていない時
        // セッション開始
        session_start();
    }

    $_SESSION['USER'] = $user;//引数のユーザー変数をセッションのユーザーのというキーのところに格納する
}

/**
 * ユーザー情報をセッションから削除
 *
 * @return void
 */
function deleteUserSession()
{
    // セッションを開始していない場合
    if(session_status() === PHP_SESSION_NONE){
        // セッション開始
        session_start();
    }

    // セッションのユーザー情報を削除
    unset($_SESSION['USER']);//unset関数でセッションの情報を削除できる
}

/**
 * セッションのユーザー情報を取得
 * 
 * @return array|false
 */
function getUserSession()
{
    // セッションを開始していない場合
    if(session_status() === PHP_SESSION_NONE){
        // セッション開始
        session_start();
}

    if(!isset($_SESSION['USER'])){
        // セッションにユーザー情報がない
        return false ;
    }

    $user = $_SESSION['USER'];

    // 画像のファイル名からファイルのURLを取得
    if(!isset($user['image_name'])){
        $user['image_name'] = null ;
    }
    $user['image_path'] = buildImagePath($user['image_name'],'user');

    return $user ;
}

/**
 * 画像をアップロード
 *
 * @param array $user
 * @param array $file
 * @param string $type
 * @return string 画像のファイル名
 */
function uploadImage(array $user, array $file, string $type)
{
    // 画像のファイル名から拡張子を取得（例：.png）
    $image_extension = strrchr($file['name'],'.');//strrchr(ストリアルキャラ)ファイル名の後ろから.(ドット)が来るまでの部分を抜き出す

    // 画像のファイル名を作成（YmdHis: 2021-01-01 00:00:00 ならば 20210101000000）
    $image_name = $user['id'] . '_' . date('YmdHis') . $image_extension;//接頭辞はユーザーidが入る　date('YmdHis')=今日の日付が入る

    // 保存先のディレクトリ
    $directory = '../Views/img_uploaded/' . $type . '/';//引数の$typeが入る→ユーザーかツイートという文字列が入る

    // 画像のパス 
    $image_path = $directory . $image_name;//$image_path=保存先のファイルパス

    // 画像を設置
    move_uploaded_file($file['tmp_name'],$image_path);//move_uploaded_file=アップロードされた一時ファイルを指定の場所に移動する

    // 画像ファイルの場合->ファイル名をreturn
    if(exif_imagetype($image_path)){//exif_imagetype=画像ファイルであれば
        return $image_name;//ファイル名をreturnする
    }

    // 画像ファイル以外の場合
    echo '選択されたファイルが画像ではないため処理を停止しました。';
    exit;

}