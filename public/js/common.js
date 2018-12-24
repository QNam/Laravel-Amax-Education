/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

Number.prototype.formatnum = function(n, x) {
    var re = '\\d(?=(\\d{' + (x || 3) + '})+' + (n > 0 ? '\\.' : '$') + ')';
    return this.toFixed(Math.max(0, ~~n)).replace(new RegExp(re, 'g'), '$&.');
};  

function _fomatStringToInt(string){
    str ="";

    if(string == 0) return Number(0);

    if (typeof string === 'string' || string instanceof String){
        var strArray = string.split(".");
        for (var i = 0; i < strArray.length; i++) {
            var str = str+strArray[i];
        }       
    }
    val= parseInt(str);
    return val;

}

function getResponseText(data) {
    return jQuery.parseJSON(data);
}
 function Modal(dom,state,title) 
{
  this.dom = dom;
  this.title = title;
  this.state = state;

  this.contruct = function() {
    $(this.dom).attr('data-state',this.state);
    $(this.dom + " .modal-title").text(this.title);
  }

  this.setModalTitle = function(title) {
    $(this.dom + ' .modal-title').val(title);
  }

  this.getState = function() {
    return $(this.dom).attr('data-state');
  }

  this.setState = function(state) {
    $(this.dom).attr('data-state',state);
    this.state = state;
  }

  this.setDefault = function() {

    $(this.dom + " input[type=text]").val("");
    $(this.dom + " textarea").val("");
    $(this.dom + " input[type=number]").val("");
    $(this.dom + " select").val("");
    $(this.dom + " input[type=checkbox]").prop('checked',false);
    $(this.dom + " .error").attr('display','none');
  }

}


function createModel(dom,state,title) 
{
    var modal = new Modal(dom,state,title);

    modal.contruct();

    if (modal.getState() == 'update') 
    {
        
        $(dom).on('hide.bs.modal', function () { 
            modal.setState("");
            modal.setDefault();   

        });
    }

    if (modal.getState() == 'add') 
    {
        $(dom).on('hide.bs.modal', function () { 
            modal.setState("");
            $(dom + " label.error").css('display', 'none');   

        });
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


function showNotify(title,text,addClass)
{    

    new PNotify({
        title: title,
        text: text,
        addclass: addClass,
        icon:'',
        delay: 1000
    })
}
