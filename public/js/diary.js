$(document).on('click', '.js-like', function(){
    // alert('Clicked');


    // いいねされた日記のIDを取得
    // $(this) : 今回クリックされたiタグ（ハートマーク）
    // .siblings('XXX') : 兄弟要素の取得
    // .val() : inputタグのvalueの値を取得
    let diaryId = $(this).siblings('.diary-id').val();


        // alert(diaryId);
        // likeメソッドの実行
        like(diaryId, $(this));
   });

   function like(diaryId,clickedBtn) {

    $.ajax({
        url: 'diary/' + diaryId + '/like',
        type:'POST',
        dataType: 'json',
        // LaravelはもともとCSRF対策を持っているため、tokenを送信する 設定してなければ419のエラー表示が出現
        // headerの中のmeta name="csrf-token"
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    }).done((data) => {
        console.log(data);
        // いいねの数を増やす。
        // 1. 現在のいいね数を取得
        // text() : <a>XXX</a> XXXの部分を取得する。
        let num = clickedBtn.siblings('.js-like-num').text();

        // numを数値に変換する
        num = Number(num);

        // 2. 1プラスした結果を設定する
        // text(YYY) : <a>XXX</a> XXXの部分をYYYに置き換える。
        clickedBtn.siblings('.js-like-num').text(num + 1);



        // いいねのボタンのデザインを変更
        changeLikeBtn(clickedBtn);

    }).fail((error) => {
        console.log(error);
    });

}


    // btn : 色を変えたい、いいね!ボタン
    // toggleClassは、クラスの切り替え（あれば・・なければ。。。）
    function changeLikeBtn(btn) {
        btn.toggleClass('far').toggleClass('fas');
        btn.toggleClass('js-like').toggleClass('js-dislike');

    }




    //  いいね解除の処理
    $(document).on('click', '.js-dislike', function() {
        //  いいねされた日記のIDを取得。
        let diaryId = $(this).siblings('.diary-id').val();

        // dislikeメソッドの実行
        dislike(diaryId, $(this));


    });

    function dislike(diaryId, clickedBtn) {

        $.ajax({
            url: 'diary/' + diaryId + '/dislike',
            type:'POST',
            dataType: 'json',
            // CSRF対策のため、tokenを送信する 設定してなければ419のエラー表示が出現
            // headerの中のmeta name="csrf-token"
            headers: {
                'X-CSRF-TOKEN':
                $('meta[name="csrf-token"]').attr('content')
            }
        }).done((data) => {
            console.log(data);
            // いいねの数を増やす。
            // 1. 現在のいいね数を取得
            // text() : <a>XXX</a> XXXの部分を取得する。
            let num = clickedBtn.siblings('.js-like-num').text();
    
            // numを数値に変換する
            num = Number(num);
    
            // 2. 1マイナスした結果を設定する
            // text(YYY) : <a>XXX</a> XXXの部分をYYYに置き換える。
            clickedBtn.siblings('.js-like-num').text(num - 1);
    
    
    
            // いいねのボタンのデザインを変更
            changeLikeBtn(clickedBtn);
    
        }).fail((error) => {
            console.log(error);
        });
    
    }
