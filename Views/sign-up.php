<!DOCTYPE html>
<html lang="ja">
 
<head>
    <?php include_once('../Views/common/head.php'); ?>    
    <title>会員登録画面 / Twitterクローン</title>
    <meta name="description" content="会員登録画面です">
</head>
<body class="signup text-center">
    <main class="form-signup">
        <form action="sign-up.php" method="post">
            <img src="<?php echo HOME_URL;?>Views/img/logo-white.svg" alt="" class="logo-white">
            <h1>アカウントを作る</h1>
            <input type="text" class="form-control"name="nickname"placeholder="ニックネーム" maxlength="50" required autofocus><!--maxlength=入力文字制限  required=入力必須 autofocus=読み込み時自動的にフォーカスを当てる-->
            <input type="text" class="form-control"name="name"placeholder="ユーザー名、例)techis132" maxlength="50" required>
            <input type="email" class="form-control"name="email"placeholder="メールアドレス" maxlength="254" required><!--type(email)=入力したものがメールアドレス形式でなければエラーでかえす-->
            <input type="password" class="form-control"name="password"placeholder="パスワード" minlength="4" maxlength="50" required autofocus><!--type(password)=入力時表示がアスタリスクになる-->
            <button class="w-100 btn btn-lg"　type="submit">登録する</button><!--W-100=bsでwidthが100%になる btn-lg=ボタンが大きくなる-->
            <p class="mt-3 mb-2"><a href="sign-in.php">ログインする</a></p><!--bs mt-3=margintop１rem　mb-2=marginbottom０.５rem-->
            <p class="mt-2 mt-3 text-muted">&copy; 2021</p><!--bs text-muted=文字を灰色にする-->
        </form>
    </main>
    <?php include_once('../Views/common/foot.php');?>
</body>
</html>