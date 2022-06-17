var alertList = document.querySelectorAll('.alert');
alertList.forEach(function (alert) {
    new bootstrap.Alert(alert);
})

if ( window.history.replaceState ) {
    window.history.replaceState( null, null, realLocation );
}