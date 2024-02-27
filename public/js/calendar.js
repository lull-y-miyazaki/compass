// document.addEventListener('DOMContentLoaded', function () {
//     document.querySelectorAll('.js-open-modal').forEach(button => {
//         button.addEventListener('click', function () {
//             // 予約に関連するデータをボタンから取得
//             var reserveDate = this.getAttribute('data-reserve_date');
//             var reservePart = this.getAttribute('data-reserve_part');

//             //Jsからmodalにアクセス
//             var modal = document.getElementById('delete_modal');
//             //modalからfoamの取得
//             // var deleteForm = modal.querySelector('form');
//             //.display-reserve-dateを持つ要素をモーダルから検索し、それをdateDisplay変数に格納
//             //表示に使用
//             var dateDisplay = modal.querySelector('.display-reserve-date');
//             var partDisplay = modal.querySelector('.display-reserve-part');

//             // テキストとしてデータを表示
//             dateDisplay.textContent = '予約日: ' + reserveDate;
//             partDisplay.textContent = '予約時間: リモ' + reservePart + '部';

//             // var idField = deleteForm.querySelector('input[name="id"]');
//             // idField.value = reserveDate;

//             // モーダルを表示
//             modal.style.display = 'block';


//             //キャンセルのための処理
//             //キャンセルボタンにイベントリスナーを追加
//             modal.querySelector('.js-cancel-reservation').addEventListener('click', function () {
//                 //foamをcancelForm格納
//                 var cancelForm = modal.querySelector('form');
//                 //reserve_dateの名前のinput要素を探し、valueにreserveDate変数として設定
//                 cancelForm.querySelector('input[name="reserve_date"]').value = reserveDate;
//                 cancelForm.querySelector('input[name="reserve_part"]').value = reservePart;
//                 //formを送信
//                 cancelForm.submit();
//             });


//             // モーダルを閉じる処理
//             modal.querySelectorAll('.js-modal-close').forEach(closeButton => {
//                 closeButton.addEventListener('click', function () {
//                     modal.style.display = 'none';
//                 });
//             });
//         });
//     });
// });

$(function () {
    //混乱してきたのでjQueryで
    $('.modal_open').on('click', function () {
        $('.delete_modal').show(); //slideDown()もおもろい

        //クリックされた要素のreserve_part属性の値を取得し、reservePart変数に保存
        var reservePart = $(this).attr('reserve_part');
        var reserveDate = $(this).attr('reserve_date');

        //クラスがreserve_partの入力要素に、reservePart変数の値を設定
        $('.reserve_part').val(reservePart);
        $('.reserve_date').val(reserveDate);

        //クラスがreserve_dateの要素にreserveDate変数の値をテキストとして設定
        $('.reserve_date').text('予約日：' + reserveDate);
        $('.reserve_part').text('時間：リモ' + reservePart + '部');
    });


    $('.modal_close').on('click', function () {
        $('.delete_modal').hide();
    });
});
