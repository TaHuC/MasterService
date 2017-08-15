let remote = (() => {
    function getParams(url, method, values) {
        if(method === 'get') return get(url, values);
        else if (method === 'post') return post(url, values);
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

    return {
        getParams
    }
})();