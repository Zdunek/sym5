const $ = require('jquery');
const  _local = $('#form_local');
const  _dateFrom = $('#form_datetimeFrom');
const  _dateTo = $('#form_datetimeTo');
const url = window.location.href.split('?')[0];

const _change_url = function(){
    var params = {};
    if(_local.val() != ''){
        params['local'] = _local.val();
    }
    if(_dateFrom.val() != ''){
        params['dateFrom'] = _dateFrom.val();
    }
    if(_dateTo.val() != ''){
        params['dateTo'] = _dateTo.val();
    }
    p = new URLSearchParams(params);
    window.location  =url + '?' + p.toString();
};


var cleaning_buttons = function(elId){
    var _el = $('#' + elId);
    _el.after('<div class="closer">x</div>')
};

var cleaner = function(){
    $('body').on('click', '.closer', function(){
        $(this).parent().find('input').val('');
        $(this).hide();
        _change_url();
    });
}

$( document ).ready(function() {
    _local.change(_change_url);
    _dateFrom.change(_change_url);
    _dateTo.change(_change_url);
    cleaning_buttons('form_datetimeFrom');
    cleaning_buttons('form_datetimeTo');
    cleaner();
});