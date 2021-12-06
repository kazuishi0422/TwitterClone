<!DOCTYPE html>
<html lang="ja">
 
<head>
    <?php include_once('../Views/common/head.php'); ?>
    <title>ホーム画面 / Twitterクローン</title>
    <meta name="description" content="ホーム画面です">
</head>
 
<body class="home">
    <div class="container"><!--レスポンシブデザインが適用される-->
        <?php include_once('../Views/common/side.php');?>
        <div class="main">
            <div class="main-header">
                <h1>ホーム</h1>
            </div>

            <!-- つぶやき投稿エリア -->
            <div class="tweet-post">
                <div class="my-icon">
                    <img src="<?php echo htmlspecialchars($view_user['image_path']) ?>" alt="">
                </div>
                <div class="input-area">
                    <form action="post.php" method="post" enctype="multipart/form-data">
                        <textarea name="body" placeholder="いまどうしてる？" maxlength="140"></textarea>
                        <div class="bottom-area">
                            <div class="mb-0">
                                <input type="file" name="image" class="form-control form-control-sm">
                            </div>
                            <button class="btn" type="submit">つぶやく</button>
                        </div>
                    </form>
                </div>
            </div>
            <!-- 仕切りエリア -->
            <div class="ditch"></div>

            <!-- つぶやき一覧エリア -->
            <?php if(empty($view_tweets)) : ?>
                <p class="p-3">ツイートがありません</p>
            <?php else: ?>
                
                    <div class="tweet-list">
                    <?php foreach($view_tweets as $view_tweet): ?>
                        <?php include('../Views/common/tweet.php'); ?><!--foreach内で一度しか適用しなくなるのでonceを外す-->
                    <?php endforeach; ?>
                    </div>
            <?php endif; ?>
        </div>
    </div>
    <?php include_once('../Views/common/foot.php');?>
</body>

</html>