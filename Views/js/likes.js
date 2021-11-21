////////////////////////////
// いいね！用のJavaScript
///////////////////////////

$(function(){
    // いいね！がクリックされたとき
    $('.js-like').click(function (){
        const this_obj = $(this);//this_objにはクリックされた要素が入る（constで再代入できなくなる
        const like_id = $(this).data('like-id');//クリックされた要素のデータ属性のlike_idに入る
        const like_count_obj = $(this).parent().find('.js-like-count');//クリック要素の中にあるjs-like-countの要素がlike_count_objに入る
        let like_count = Number(like_count_obj.html());//js-like-countからいいね数を取得する

        if(like_id){
            //いいね！取り消し
            //いいね！カウントを減らす
            like_count--;
            like_count_obj.html(like_count);//いいね数の要素に更新したいいね数をセット
            this_obj.data('like-id',null);//クリック要素のデータ属性のlike_idを削除

            //いいね！ボタンの色をグレーに変更
            $(this).find('img').attr('src','../Views/img/icon-heart.svg');
        } else{
            //いいね！付与
            //いいね！カウントを増やす
            like_count++;
            like_count_obj.html(like_count);//いいね数の要素に更新したいいね数をセット
            this_obj.data('like-id',true);//クリック要素のデータ属性のlike_idを削除

            //いいね！ボタンの色を青に変更
            $(this).find('img').attr('src','../Views/img/icon-heart-twitterblue.svg');

        }
    });
}) 