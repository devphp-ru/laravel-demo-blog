$(() => {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        }
    });

    $('.select2').select2()

    const $isBanned = $(`#is_banned`);

    $isBanned.click(function () {
        if ($(this).is(`:checked`)) {
            $isBanned.prop(`checked`, true);
            $isBanned.val(1);
        } else {
            $isBanned.prop(`checked`, false);
            $isBanned.val(0);
        }
    });

    const $isActive = $(`#is_active`);

    $isActive.click(function () {
        if ($(this).is(`:checked`)) {
            $isActive.prop(`checked`, true);
            $isActive.val(1);
        } else {
            $isActive.prop(`checked`, false);
            $isActive.val(0);
        }
    });

    $(document).on(`click`, `.change-status`, function () {
        const id = parseInt($(this).data(`id`));
        const table = $(this).data(`table`);
        const field = $(this).data(`field`);
        const value = parseInt($(this).data(`value`));
        if (!isNaN(id) && (id > 0)) {
            $.ajax({
                url: `/api/v1/change-status`,
                method: `put`,
                dataType: `json`,
                cache: false,
                data: {id, table, field, value},
                success: function (data) {
                   if (data.status === `error`) {
                       alert(`Ошибка сохранения.`);
                   } else {
                       const td = $(`#td${id}`);
                       td.removeData(`value`);
                       td.text(data.value === 1 ? `нет` : `да`);
                       td.attr(`data-value`, data.value);
                       alert('Успешно изменено.');
                   }
                }
            });
        }
    });

    $(document).on(`click`, `.delete-comment`, function () {
        const id = parseInt($(this).data('id'));
        if (!isNaN(id) && id > 0) {
            $.ajax({
                url: `/api/v1/delete-comment`,
                method: `DELETE`,
                dataType: `json`,
                cache: false,
                data: {id},
                success: function (data) {
                    if (!data.status) {

                    } else {
                        $(`#tr${id}`).remove();
                    }
                }
            })
        }
    });
});
