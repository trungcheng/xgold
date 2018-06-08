var app = angular.module('app', ['ja.qr', 'ui.bootstrap', 'angularMoment', 'as.sortable','ngclipboard']);

$.ajaxSetup({
    dataType: 'json',
    error: function (xhr, status, error) {
        loading.hide();
        if (xhr.status == 403) {
            bootbox.alert('403');
        } else {
            bootbox.alert(error);
        }
    }
});

var loading = {};

loading.show = function () {
    if ($('#loading').length <= 0) {
        $('body').append('<div id="loading" style="display:none;" class="loading"></div>');
    }
    $('#loading').show();
};

loading.hide = function () {
    $('#loading').hide();
};

yii.confirm = function (message, ok, cancel) {
    bootbox.confirm(
            {
                message: message,
                callback: function (confirmed) {
                    if (confirmed) {
                        !ok || ok();
                    } else {
                        !cancel || cancel();
                    }
                }
            }
    );
    return false;
};

$(document).ready(function () {

    ga('require', 'ecommerce');
    setInterval(function () {
        $.ajax({
            url: baseUrl + '/site/ping',
            method: 'GET',
            success: function (resp) {
            }
        });
    }, 900000);

    $("i.fa-fa").removeClass("fa-fa");

    var copyTextareaBtn = document.querySelector('#referral_copy');
    if (typeof copyTextareaBtn != 'undefined' && copyTextareaBtn != null) {
        copyTextareaBtn.addEventListener('click', function (event) {
            var copyTextarea = document.querySelector('#referral_text');
            copyTextarea.select();
            try {
                var successful = document.execCommand('copy');
                var msg = successful ? 'successful' : 'unsuccessful';
                console.log('Copying text command was ' + msg);
            } catch (err) {
                console.log('Oops, unable to copy');
            }
        });
    }
});