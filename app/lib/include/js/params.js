Adianti.registerState = false;
if (typeof history.replaceState != 'undefined') {
    var baseurl = window.location.pathname.replace(/index\.php.*/,'');
    var stateObj = { url: baseurl };
    history.replaceState(stateObj, '', baseurl);
}