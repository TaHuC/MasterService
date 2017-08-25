let remote = (() => {
    function getParams(url, method, values) {
        if(method === 'get') return get(url, values);
        else if (method === 'post') return post(url, values);
        else if (method === 'put') return put(url, values);
    }
    
    function makeRequest(method, url, values = '') {
        return req = {
            url: url + values,
            method
        }
    }
    
    function get(url, values) {
        return $.ajax(makeRequest('GET', url, values))
            .error(() => {
                Materialize.toast('The "Problem" field is required', 2500);
            });
    }
    
    function post(url, values) {
        return $.post(url, values);
    }

    function put(url, values) {
        return $.ajax({
            method: 'PUT',
            url,
            data: values,
        }).error((err) => {
                Materialize.toast(err, 2500);
            });
    }

    return {
        getParams
    }
})();