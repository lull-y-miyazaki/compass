$(function () {
    $('.search_conditions').click(function () {
        $('.search_conditions_inner').slideToggle();
    });

    $('.subject_edit_btn').click(function () {
        $('.subject_inner').slideToggle();
    });
});


$(function () {
    $('.toggle-subcategories').on('click', function () {
        // クリックされたトグルに最も近い .search_conditions_inner 要素を選択してトグル
        $(this).closest('li').next('.search_post_inner').slideToggle();

        // トグルアイコンのテキストを切り替える
        if ($(this).text() === 'V') {
            $(this).text('∧');
        } else {
            $(this).text('V');
        }
    });
});
