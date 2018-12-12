/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
var searchBody = 0;
function getResponseText(data) {
    return jQuery.parseJSON(data);
}
function getErrorMessage(errors) {
    var message = "";
    if ($.isArray(errors)) {
        $.each(errors, function (index, value) {
            message += value + "\n";
        });
    } else {
        message = errors;
    }
    return message;
}

function changeText(elem,val)
{
    $(elem).text(val);
}
        
function getDayOfWeekLable(day) {
    switch (day) {
        case 0:
            return "Thứ 2";
            break;
        case 1:
            return "Thứ 3";
            break;
        case 2:
            return "Thứ 4";
            break;
        case 3:
            return "Thứ 5";
            break;
        case 4:
            return "Thứ 6";
            break;
        case 5:
            return "Thứ 7";
            break;
        case 6:
            return "Chủ nhật";
        default:
            return "Ngày không hợp lệ"
    }
}

function showSuccessMessages(messages) {
    var html = '<div id="messages">' +
            '<div id="message-success" class="message message-success">' + messages +
            '</div></div>';
    $("#messages").remove();
    $('#content').prepend(html);
}
function showErrorMessages(messages) {
    var html = '<div id="messages">' +
            '<div id="message-error" class="message message-error">' + messages +
            '</div></div>';
    $("#messages").remove();
    $('#content').prepend(html);
}
function goBack() {
    window.history.back();
}
// (function ($) {
//     $.fn.datepicker.dates['vi'] = {
//         days: ["Chủ nhật", "Thứ 2", "Thứ 3", "Thứ 4", "Thứ 5", "Thứ 6", "Thứ 7"],
//         daysShort: ["CN", "Thứ 2", "Thứ 3", "Thứ 4", "Thứ 5", "Thứ 6", "Thứ 7"],
//         daysMin: ["CN", "T2", "T3", "T4", "T5", "T6", "T7"],
//         months: ["Tháng 1", "Tháng 2", "Tháng 3", "Tháng 4", "Tháng 5", "Tháng 6", "Tháng 7", "Tháng 8", "Tháng 9", "Tháng 10", "Tháng 11", "Tháng 12"],
//         monthsShort: ["Th1", "Th2", "Th3", "Th4", "Th5", "Th6", "Th7", "Th8", "Th9", "Th10", "Th11", "Th12"],
//         today: "Hôm nay",
//         clear: "Xóa",
//         format: "DD, dd/mm/yy",
//         weekStart: 1,
//     };
//     $.fn.datepicker.defaults.autoclose = true;
//     $.fn.datepicker.defaults.language = 'vi';
// }(jQuery));
$(document).ready(function () {
    if (getCookie("hide_menu") == 1) {
        hideMenuLeft();
    }
});
function preventParentEvent(event) {
    event.stopPropagation();
}
function hideCollapse(id) {
    $(id).collapse('hide');
    return false;
}
function toggleCollapse(id) {
    if ($(id).is(':visible')) {
        $(id).collapse('hide');
    } else {
        $(".resv-row-data").each(function (index, element) {
            if ($(element).is(':visible')) {
                $(element).collapse('hide');
            }
        });
        $(id).collapse('show');
    }

}
function showLargeLoading(containter) {
    var html = '</div><div id="overlay_loading"  class="overlay" style="display:block">' +
            '<div class="large-loading"></div>' +
            '</div>';
    $('#content').append('<div class="light-layer">');
    // $(containter).css({
    //     'opacity': '0.3',
    //     'filter': 'alpha(opacity=30)'
    // });
    $(containter).append(html);
}
function showSmallLoading(containter) {
    var html = '<div id="overlay_loading"  class="overlay" style="display:block">' +
            '<div class="small-loading"></div>' +
            '</div>';
    $(containter).css({
        'opacity': '0.3',
        'filter': 'alpha(opacity=30)'
    });
    $(containter).append(html);
}
function hideOverLoading(containter) {
    $("#overlay_loading").remove();
    $(containter + " .light-layer").remove();
    $('#content .light-layer').remove();
    $(containter).css({
        'opacity': '1',
        'filter': 'alpha(opacity=1)'
    });
}
function toggleMenuLeft() {
    var isHide = $('#column-left').data('hide_menu');
    if (isHide == 1) {
        showMenuLeft();
        setCookie("hide_menu", 2);
    } else {
        hideMenuLeft();
        setCookie("hide_menu", 1);
    }
}

function hideMenuLeft() {
    $('#column-left').addClass('folded');
    $('#column-left').data('hide_menu', 1);
}
function showMenuLeft() {
    $('#column-left').removeClass('folded');
    $('#column-left').data('hide_menu', 2);
}
function getCookie(cname) {
    var name = cname + "=";
    var ca = document.cookie.split(';');
    for (var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}
function setCookie(cname, cvalue, exdays) {
    var expires = "";
    if (exdays) {
        var date = new Date();
        date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
        expires = "; expires=" + date.toGMTString();
    }
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}
function scrollMenuLeft() {
    if (searchBody == 0) {
        searchBody = $(window).height() - $('#search_result .panel-heading').height() - 50;
    }
    $('.search-data').slimScroll({
        height: searchBody,
        color: '#0059fc',
    });
}
function searchEnterInMenu(event) {
    if (event.which == 13) {
        searchInMenu();
    }
}
function searchEnterInForm(event) {
    if (event.which == 13) {
        searchInForm();
    }
}

function searchInMenu() {
    var value = $('#menu_search_input').val();
    if(value.trim() == ''){
        return;
    }
    hideMenuLeft();
    $('#search_result').show();
    $('#search_input').val(value);
    searchAllinfo(value);
}
function searchInForm() {
    var value = $('#search_input').val();
    if(value.trim() == ''){
        return;
    }
    searchAllinfo(value);
}
function searchAllinfo(term) {
    showLargeLoading('#search_content');
    $.ajax({
        method: "GET",
        url: base_url + "/search?area=adminres",
        data: {
            term: term
        },
        error: function () {

        },
        success: function (data)
        {
            var response = getResponseText(data);
            if (response.success) {
                var htmls = response.data;
                $('#all_data').html(htmls.all);
                $('#reservation_data').html(htmls.reservations);
                $('#customer_data').html(htmls.customers);
                $('#deal_data').html(htmls.deals);
                scrollMenuLeft();
            }
            hideOverLoading('#search_content');
        }
    });
}

function closeBox(id) {
    $(id).hide();
}
function removeElm(id){
    $(id).remove();
}
function formatPrice(x) {
    return isNaN(x)?"0 đ":x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")+" đ";
}