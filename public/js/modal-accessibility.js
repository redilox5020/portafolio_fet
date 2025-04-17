$(document).ready(function () {
    let lastFocusedTrigger = null;

    $(document).on('click', '[data-toggle="modal"]', function () {
        lastFocusedTrigger = this;
    });

    $('.modal').on('hide.bs.modal', function () {
        document.activeElement.blur();
    });

    $('.modal').on('hidden.bs.modal', function () {
        if (lastFocusedTrigger) {
            setTimeout(() => {
                $(lastFocusedTrigger).focus();
            }, 10);
        }
    });
});
