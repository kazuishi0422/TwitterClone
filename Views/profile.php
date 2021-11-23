<!DOCTYPE html>
<html lang="ja">
 
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../Views/img/logo-twitterblue.svg">
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <link href="../Views/css/style.css" rel="stylesheet">
    <!-- JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous" defer></script>
    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous" defer></script>
    <!-- いいね！js -->
    <script src="../Views/js/likes.js" defer></script><!--defer JavaScriptよりHTMLの読み込みが優先される 読み込みが早くなる -->

    <title>プロフィール画面 / Twitterクローン</title>
    <meta name="description" content="プロフィール画面です">
</head>
 
<body class="home profile text-center"><!--bs text-center 中横揃え-->
    <div class="container"><!--レスポンシブデザインが適用される-->
        <div class="side">
            <div class="side-inner">
                <ul class="nav flex-column"><!--nav=メニューに適したレイアウトが適用される　flex-column=子要素を上から下に並べる-->
                    <li class="nav-item"><a href="home.php" class="nav-link"><img src="../Views/img/logo-twitterblue.svg" alt="サイトロゴ画像" class="icon"></a></li><!--メニュー項目に適したレイアウトが適用される-->
                    <li class="nav-item"><a href="home.php" class="nav-link"><img src="../Views/img/icon-home.svg" alt=""></a></li><!--メニュー項目に適したレイアウトが適用される-->
                    <li class="nav-item"><a href="search.php" class="nav-link"><img src="../Views/img/icon-search.svg" alt=""></a></li><!--メニュー項目に適したレイアウトが適用される-->
                    <li class="nav-item"><a href="notification.php" class="nav-link"><img src="../Views/img/icon-notification.svg" alt=""></a></li><!--メニュー項目に適したレイアウトが適用される-->
                    <li class="nav-item"><a href="profile.php" class="nav-link"><img src="../Views/img/icon-profile.svg" alt=""></a></li><!--メニュー項目に適したレイアウトが適用される-->
                    <li class="nav-item"><a href="post.php" class="nav-link"><img src="../Views/img/icon-post-tweet-twitterblue.svg" alt="" class="post-tweet"></a></li><!--メニュー項目に適したレイアウトが適用される-->
                    <li class="nav-item my-icon"><img src="../Views/img_uploaded/user/sample-person.jpg" alt="" class="js-popover"
                     data-bs-container="body" data-bs-toggle="popover" data-bs-placement="right" data-bs-html="true"
                     data-bs-content="<a href='profile.php'>プロフィール</a><br><a href='sign-out.php'>ログアウト</a>"
                    ></li><!--↑オプションdata-bs-container=bodyは親要素の影響を受けにくくなる,toggke=popoverは初期化,placement=rightはpopoverを右側に出す,html=trueは後に書く文をhtml化する-->
                </ul>
            </div>
        </div>
        <div class="main">
            <div class="main-header">
                <h1>太郎</h1>
            </div>

            <!-- プロフィールエリア -->
            <div class="profile-area">
                <div class="top">
                    <div class="user"><img src="../Views/img_uploaded/user/sample-person.jpg" alt=""></div>

                    <?php if(isset($_GET['user_id'])): ?><!--もしパラメータにuse_idがあれば-->
                        <!-- 相手のページ -->
                        <?php if(isset($_GET['case'])): ?>
                            <button class="btn btn-sm">フォローを外す</button>
                        <?php else: ?>
                            <button class="btn btn-sm btn-reverse">フォローする</button>
                        <?php endif;?>
                    <?php else: ?>
                        <!-- 自分のページ -->
                        <button class="btn btn-reverse btn-sm" data-bs-toggle="modal" data-bs-target="#js-modal">プロフィール編集</button><!--bs btn-sm ボタンを小さくする-->
                        <!-- ↑プロフィール編集ボタンにbsのデータ属性をつけてクリックされた時にモーダル機能を実行する（#js-modalのIDのモーダル）-->
                    <?php endif; ?>

                    <div class="modal fade" id="js-modal" tabindex="-1"　aria-hidden="true"><!-- bs modal fade フェードインしてモーダルが開かれる tabindex="-1"でタブ操作の対象から外す aria-hidden="ture"は端末の読み上げ機能等から無視する効果-->
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form action="profile.php" method="post" enctype="multipart/form-data">
                                    <div class="modal-header">
                                        <h5 class="modal-title">プロフィールを編集</h5>
                                        <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button><!-- aria-label端末の読み上げ機能-->
                                    </div>
                                    <div class="modal-body">
                                        <div class="user">
                                            <img src="../Views/img_uploaded/user/sample-person.jpg" alt="">
                                        </div>
                                        <div class="mb-3">
                                            <label for="" class="mb-1">プロフィール写真</label>
                                            <input type="file" class="form-control form-control-sm" name="image"><!-- form-controlフォームのテキストフォーム bs form-control-sm 高さを低くする -->
                                        </div>

                                        <input type="text" class="form-control mb-4"name="nickname" value="太郎" placeholder="ニックネーム" maxlength="50" required><!--maxlength=入力文字制限  required=入力必須 autofocus=読み込み時自動的にフォーカスを当てる-->
                                        <input type="text" class="form-control mb-4"name="name" value="taro" placeholder="ユーザー名" maxlength="50" required>
                                        <input type="email" class="form-control mb-4"name="email" value="taro@techis.jp" placeholder="メールアドレス" maxlength="254" required><!--type(email)=入力したものがメールアドレス形式でなければエラーでかえす-->
                                        <input type="password" class="form-control mb-4"name="password" value="" placeholder="パスワードを変更する場合ご入力ください" minlength="4" maxlength="128"><!--type(password)=入力時表示がアスタリスクになる-->

                                    </div>

                                    <div class="modal-footer">
                                        <button class="btn btn-reverse" data-bs-dismisss="modal">キャンセル</button>
                                        <button class="btn"　type="submit">保存する</button>
                                    </div>

                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="name">太郎</div>
                <div class="text-muted">@taro</div>

                <div class="follow-follower">
                    <div class="follow-count">1</div>
                    <div class="follow-text">フォロー中</div>
                    <div class="follow-count">1</div>
                    <div class="follow-text">フォロワー</div>
                </div>
            </div>

            <!-- 仕切りエリア -->
            <div class="ditch"></div>

            <!-- TODO: つぶやき一覧エリア -->
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded',function(){//addEventListener=第一引数にDOMContentLoadedを指定するとブラウザがHTMLの解析を完了したタイミングで第二引数が実行される
            $('.js-popover').popover();//JQueryを使用 js-popoverに.popover吹き出しが出るようにする
        },false);

    </script>
</body>
 
</html>