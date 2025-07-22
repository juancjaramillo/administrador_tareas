(function () {

    if (window.history && history.pushState) {
        history.pushState(null, document.title, window.location.href);


        window.addEventListener('popstate', function () {
            window.location.reload();
        });

        window.addEventListener('pageshow', function (event) {
            if (event.persisted) {
                window.location.reload();
            }
        });
    }
})();
