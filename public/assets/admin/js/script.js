$(() => {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        }
    });

    const $isBanned = $(`#is_banned`);

    $isBanned.click(function () {
        if ($(this).is(`:checked`)) {
            $isBanned.prop(`checked`, true);
            $isBanned.val(1);
        } else {
            $isBanned.prop(`checked`, false);
            $isBanned.val(0);
        }
    })
});
