(function($) {

    $(document).on('click', '.matat-stock-notify-submit', function (e) {
        e.preventDefault();

        var form = $('.matat-stock-notify-form');

        var message = form.next();
        var spinner = form.find('.spinner-border');
        var submit = form.find( '.submit' );
        var data = $(this).data();
        var stockPhone = $('#stock-phone').val();
        var isNum = /^\d+$/.test(stockPhone);

        var variationSelection = [];
        jQuery('.variations select').each(function(){
            var variationLabel = "";
            var variationName = "";
            var variationVal = "";
            var variationOptLabel = "";
            var obj = {};
            variationName = $(this).attr('name');
            variationLabel = $(this).parent('td').siblings('td.label').find('label').text();
            variationOptLabel = $(this).find('option:selected').text();
            variationVal = $(this).val();
            obj[variationName] = [variationLabel,variationOptLabel,variationVal];
            variationSelection.push(obj);
        });

        message.removeClass('alert-danger');
        spinner.toggleClass('hidden');
        $(this).attr( 'disabled', true );

        if ( ! stockPhone.startsWith('05') || stockPhone.length != 10 || ! isNum ) {
            spinner.toggleClass('hidden');
            submit.attr( 'disabled', false );

            message.attr('class', 'alert');
            message.addClass('alert-danger').html('מספר טלפון לא תקין.');

            return false;
        }

        data.phone = stockPhone;
        data.variationSelect = variationSelection;

        $.post( matat.ajaxurl, data, function (response) {
            spinner.toggleClass('hidden');
            submit.attr( 'disabled', false );

            var style = response.success ? 'alert-success' : 'alert-danger';
            message.attr('class', 'alert');
            message.addClass(style).html(response.data);

            if ( response.success ) {
                form.slideUp();

            }
        }, 'json');

    });

})(jQuery);
