(function($) {

    $( '.matat-stock-notify-reset' ).on( 'click', function (e) {
        e.preventDefault();

        var spinner = $(this).find( '.spinner' );
        var r = confirm("האם למחוק את כל מספרי הטלפון בטבלה?");
        if (! r ) {
            return;
        }

        var post_id = $(this).data('post_id');
        var dIndex = [];
        $(".individual_num:checked").each(function(){
            dIndex.push($(this).attr('data-index'));
        });

        if(dIndex==null){
            alert("אנא בחר מספרי טלפון למחיקה. ");
            return false;
        }
        var data = {
            post_id: post_id,
            dIndex: dIndex,
            security: $('#security').val(),
        };

        spinner.toggleClass('is-active').show();
        $.post( ajaxurl, { action: 'matat_stock_notify_reset', data:data, security: data.security},function (result) {
            spinner.toggleClass('is-active').hide();
            //$('.matat-stock-notify-list').remove();
            $('.individual_num:checked').parents('tr').remove();
            alert(result);
        });

    });

    $('.matat-stock-notify-sms').on('click', function (e) {
        e.preventDefault();

        var post_id = $(this).data('post_id');
        var dIndex = [];
        $(".individual_num:checked").each(function(){
            dIndex.push($(this).attr('data-index'));
        });

        if(dIndex==null){
            alert("אנא בחר מספרי טלפון למחיקה. ");
            return false;
        }

        var sms = [];
        $(".individual_num:checked").each(function(){
            sms.push($(this).val());
        });
        var spinner = $(this).find( '.spinner' );

        $( "#sms-dialog" ).dialog({
            resizable: false,
            height: "auto",
            width: 600,
            modal: true,
            show: {
                effect: "fade",
                duration: 1000
            },
            hide: {
                effect: "fade",
                duration: 1000
            },
            buttons: [
                {
                    text: 'שליחה',
                    click: function () {

                        var data = {
                            post_id: post_id,
                            dIndex: dIndex,
                            sms: sms,
                            message: $( '#sms-body').val(),
                            security: $('#security').val()
                        };

                        spinner.toggleClass('is-active').show();
                        $.post( ajaxurl, {action: 'send_bulk_sms', data: data, security: data.security}, function(result) {
                            spinner.toggleClass('is-active').hide();
                            alert(result);
                            $('.individual_num:checked').parents('tr').remove();
                        });
                        $(this).dialog('close');
                    }
                },
                {
                    text: 'ביטול',
                    click: function () {
                        $(this).dialog('close');
                    }
                },
                {
                    text: 'שליחת ניסיון',
                    click: function () {
                        var testNum = prompt("יש להקליד מספר טלפון נייד לשליחת בדיקה.");

                        if (testNum == null || testNum == "") {
                            return;
                        } else {
                            var data = {
                                post_id: post_id,
                                message: $( '#sms-body').val(),
                                security: $('#security').val(),
                                sms: [testNum]
                            };

                            spinner.toggleClass('is-active').show();
                            $.post( ajaxurl, {action: 'send_bulk_sms', data: data, security: data.security}, function(result) {
                                spinner.toggleClass('is-active').hide();
                                alert(result)
                            });
                        }
                        $(this).dialog('close');
                    }
                }
            ]
        });
    });

    jQuery('.select_all_num').click(function(){ 
        var checkedStatus = this.checked; 
        jQuery('.individual_num').prop('checked', checkedStatus);
    });
    jQuery('.individual_num').click(function(){ 
        var checkedStatus = this.checked; 
        jQuery('.select_all_num').prop('checked', false);
    });

})(jQuery)