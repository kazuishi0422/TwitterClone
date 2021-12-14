////////////////////////////
// いいね！用のJavaScript
///////////////////////////

$(function(){
    // いいね！がクリックされたとき
    $('.js-like').click(function (){
        const this_obj = $(this);//this_objにはクリックされた要素が入る（constで再代入できなくなる
        // tweet-idを取得
        const tweet_id = $(this).data('tweet-id');
        const like_id = $(this).data('like-id');//クリックされた要素のデータ属性のlike_idに入る
        const like_count_obj = $(this).parent().find('.js-like-count');//クリック要素の中にあるjs-like-countの要素がlike_count_objに入る
        let like_count = Number(like_count_obj.html());//js-like-countからいいね数を取得する

        if(like_id){
            //いいね！取り消し
            // 非同期通信
            $.ajax({
                url: 'like.php',
                type: 'POST',
                data:{
                    'like_id':like_id
                },
                timeout:10000
            })
            // 取り消しが成功 $.ajaxメソッドで通信エラーがなければdoneメソッドに書いてある処理を実行する
            .done(()=> {// doneメソッドには関数を指定する　今回のは名前のない関数（無名関数またはアロー関数という）一度しか使用しない関数はこういう書き方ができる
                //いいね！カウントを減らす
                like_count--;
                like_count_obj.html(like_count);//いいね数の要素に更新したいいね数をセット
                this_obj.data('like-id',null);//クリック要素のデータ属性のlike_idを削除

                //いいね！ボタンの色をグレーに変更
                $(this).find('img').attr('src','../Views/img/icon-heart.svg');
            })
            .fail((data)=> {// failフェイルメソッド=通信が正常に出来なかった時に実行される
                    alert('処理中にエラーが発生しました。');
                    console.log(data);
            });
        } else{
            //いいね！付与
            // 非同期処理
            $.ajax({
                url:'like.php',
                type:'POST',
                data:{
                    'tweet_id': tweet_id
                },
                timeout: 10000
            })
            // いいね！が成功
            .done((data) => {
                //いいね！カウントを増やす
                like_count++;
                like_count_obj.html(like_count);//いいね数の要素に更新したいいね数をセット
                this_obj.data('like-id',data['like_id']);//クリック要素のデータ属性のlike_idを削除
            
                //いいね！ボタンの色を青に変更
                $(this).find('img').attr('src','../Views/img/icon-heart-twitterblue.svg');
                })
            .fail((data)=> {// failフェイルメソッド=通信が正常に出来なかった時に実行される
                    alert('処理中にエラーが発生しました。');
                    console.log(data);
            });

        }
    });
}) 