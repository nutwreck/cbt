    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js" integrity="sha512-+NqPlbbtM1QqiK8ZAo4Yrj2c4lNQoGv8P79DPtKzj++l5jnN39rHA/xsqn8zE9l0uSoxaCdrOgFs6yjyfbBxSg==" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

    <!-- OFFLINE -->
    <script src="<?php echo config_item('_assets_general'); ?>offline/offline.min.js"></script>
    <link rel="stylesheet" href="<?php echo config_item('_assets_general'); ?>offline/themes/offline-theme-default.css">
    <link rel="stylesheet" href="<?php echo config_item('_assets_general'); ?>offline/themes/offline-language-english.css">

    <script>
        $(document).ready(function() {
            Offline.options = {
                // to check the connection status immediatly on page load.
                checkOnLoad: false,

                // to monitor AJAX requests to check connection.
                interceptRequests: true,

                // to automatically retest periodically when the connection is down (set to false to disable).
                reconnect: {
                    // delay time in seconds to wait before rechecking.
                    initialDelay: 3,

                    // wait time in seconds between retries.
                    delay: 10
                },

                // to store and attempt to remake requests which failed while the connection was down.
                requests: true
            };
        });
    </script>