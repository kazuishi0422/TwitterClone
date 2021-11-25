<div class="side">
            <div class="side-inner">
                <ul class="nav flex-column"><!--nav=メニューに適したレイアウトが適用される　flex-column=子要素を上から下に並べる-->
                    <li class="nav-item"><a href="home.php" class="nav-link"><img src="<?php echo HOME_URL;?>Views/img/logo-twitterblue.svg" alt="サイトロゴ画像" class="icon"></a></li><!--メニュー項目に適したレイアウトが適用される-->
                    <li class="nav-item"><a href="home.php" class="nav-link"><img src="<?php echo HOME_URL;?>Views/img/icon-home.svg" alt=""></a></li><!--メニュー項目に適したレイアウトが適用される-->
                    <li class="nav-item"><a href="search.php" class="nav-link"><img src="<?php echo HOME_URL;?>Views/img/icon-search.svg" alt=""></a></li><!--メニュー項目に適したレイアウトが適用される-->
                    <li class="nav-item"><a href="notification.php" class="nav-link"><img src="<?php echo HOME_URL;?>Views/img/icon-notification.svg" alt=""></a></li><!--メニュー項目に適したレイアウトが適用される-->
                    <li class="nav-item"><a href="profile.php" class="nav-link"><img src="<?php echo HOME_URL;?>Views/img/icon-profile.svg" alt=""></a></li><!--メニュー項目に適したレイアウトが適用される-->
                    <li class="nav-item"><a href="post.php" class="nav-link"><img src="<?php echo HOME_URL;?>Views/img/icon-post-tweet-twitterblue.svg" alt="" class="post-tweet"></a></li><!--メニュー項目に適したレイアウトが適用される-->
                    <li class="nav-item my-icon"><img src="<?php echo HOME_URL;?>Views/img_uploaded/user/sample-person.jpg" alt="" class="js-popover"
                     data-bs-container="body" data-bs-toggle="popover" data-bs-placement="right" data-bs-html="true"
                     data-bs-content="<a href='profile.php'>プロフィール</a><br><a href='sign-out.php'>ログアウト</a>"
                    ></li><!--↑オプションdata-bs-container=bodyは親要素の影響を受けにくくなる,toggke=popoverは初期化,placement=rightはpopoverを右側に出す,html=trueは後に書く文をhtml化する-->
                </ul>
            </div>
        </div>
