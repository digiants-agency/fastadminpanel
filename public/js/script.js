var timeout_loading = null

// ajax request START
let load_count = 0

const serialize = function(obj, prefix) {
    var str = [], p;
    for (p in obj) {
        if (obj.hasOwnProperty(p)) {
        var k = prefix ? prefix + "[" + p + "]" : p,
            v = obj[p];
            str.push((v !== null && typeof v === "object") ?
            serialize(v, k) :
            encodeURIComponent(k) + "=" + encodeURIComponent(v));
        }
    }
    return str.join("&");
}

const formdata = function(obj) {

    let formData = new FormData()

    for (const i in obj) {

        formData.append(i, obj[i])
    }

    return formData
}

async function post(endpoint, obj, is_file = false, is_loader = true) {

    try {

        if (is_loader) {
            load_count++
            document.getElementById('loader').classList.add('active')
            // document.dispatchEvent(new CustomEvent('loading', { 'detail': load_count }))
        }

        const url = endpoint

        let headers = {
            'Accept': 'application/json',
            'X-CSRF-Token': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }

        if (is_file) {

            // headers['Content-Type'] = 'multipart/form-data'

            var response = await fetch(url, {
                method: 'POST',
                headers: headers,
                body: formdata(obj)
            })

        } else {

            headers['Content-Type'] = 'application/x-www-form-urlencoded'

            var response = await fetch(url, {
                method: 'POST',
                headers: headers,
                body: serialize(obj)
            })
        }
        
        let json = []

        try {

            json = await response.json()

        } catch (error) {}

        if (is_loader) {
            load_count--
            if (load_count == 0) {
                document.getElementById('loader').classList.remove('active')
                // document.dispatchEvent(new CustomEvent('loading', { 'detail': load_count }))
            }
        }

        if (!json.data) {
            return {
                success: false,
                message: "Fatal error",
                data: json,
            }
        }

        return json

    } catch (error) {

        console.error(error)
    }

    return {success: false, message: "Fatal error", data: {}}
}
// ajax request END

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