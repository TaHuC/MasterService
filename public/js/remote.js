let remote = (() => {
    function getParams(url, method, value) {
        if(method === 'get') return get(url, value);
    }
    
    function makeRequest(method, url, value) {
        return req = {
            url: url + value,
            method
        }
    }
    
    function get(url, value) {
        return $.ajax(makeRequest('GET', url, value))
            .error(() => {
                Materialize.toast('The "Problem" field is required', 2500);
            });
    }

    return {
        getParams
    }
})();