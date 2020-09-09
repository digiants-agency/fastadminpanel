var timeout_loading = null

function request (path, params, callback, onerror) {

    loading(true)

    $.ajax({
        type: "POST",
        url: path,
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        data: params,
        success: function(data) {
            if (callback != undefined) 
                callback(data)
            loading(false)
        },
        error: function(data) {
            if (onerror != undefined) 
                onerror(data)
            loading(false)
        }
    });
}

function request_file (path, params, callback, onerror) {

    loading(true)

    return $.ajax({
        type: "POST",
        url: path,
        processData: false,
        contentType: false,
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        data: params,
        success: function(data) {
            if (callback != undefined) 
                callback(data)
            loading(false)
        },
        error: function(data) {
            if (onerror != undefined) 
                onerror(data)
            loading(false)
        }
    });
}

function loading (is_load) {
    if (is_load) {

        $('#loader').addClass('active')

    } else {

        if (timeout_loading != null)
            clearTimeout(timeout_loading)

        timeout_loading = setTimeout(()=>{
            
            $('#loader').removeClass('active')
        }, 200)
    }
}

function set_cookie (name,value,days) {
    if (days) {
        var date = new Date();
        date.setTime(date.getTime()+(days*24*60*60*1000));
        var expires = "; expires="+date.toGMTString();
    }
    else var expires = "";
    document.cookie = name+"="+value+expires+"; path=/";
}

function get_cookie (name) {
    var nameEQ = name + "=";
    var ca = document.cookie.split(';');
    for(var i=0;i < ca.length;i++) {
        var c = ca[i];
        while (c.charAt(0)==' ') c = c.substring(1,c.length);
        if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
    }
    return "";
}

function delete_cookie (name) {
    set_cookie(name,"",-1);
}

function is_cookie (name) {
    return get_cookie(name) != "";
}