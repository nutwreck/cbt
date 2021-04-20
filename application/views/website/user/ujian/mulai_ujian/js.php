<script>
    function show_petunjuk(){
        document.getElementById("petunjuk").style.display = "";
    }
    function mulai_tes(){
        document.getElementById("info_mulai").style.display = "";
        document.getElementById("app").style.display = "";
        document.getElementById("mulai_tes").style.display = "none";
        startTimer();
    }
    function back_dashboard(){
        window.location.href = base_url + "dashboard";
    }

    // Credit Countdown By: Mateusz Rybczonec
    const FULL_DASH_ARRAY = 283;
    const WARNING_THRESHOLD = 6;
    const ALERT_THRESHOLD = 3;

    const COLOR_CODES = {
    info: {
        color: "green"
    },
    warning: {
        color: "orange",
        threshold: WARNING_THRESHOLD
    },
    alert: {
        color: "red",
        threshold: ALERT_THRESHOLD
    }
    };

    const TIME_LIMIT = 10;
    let timePassed = 0;
    let timeLeft = TIME_LIMIT;
    let timerInterval = null;
    let remainingPathColor = COLOR_CODES.info.color;

    document.getElementById("app").innerHTML = `
        <div class="base-timer">
        <svg class="base-timer__svg" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
            <g class="base-timer__circle">
            <circle class="base-timer__path-elapsed" cx="50" cy="50" r="45"></circle>
            <path
                id="base-timer-path-remaining"
                stroke-dasharray="283"
                class="base-timer__path-remaining ${remainingPathColor}"
                d="
                M 50, 50
                m -45, 0
                a 45,45 0 1,0 90,0
                a 45,45 0 1,0 -90,0
                "
            ></path>
            </g>
        </svg>
        <span id="base-timer-label" class="base-timer__label">${formatTime(
            timeLeft
        )}</span>
        </div>
    `;

    function onTimesUp() {
        clearInterval(timerInterval);
        document.getElementById("app").innerHTML = "<h5 class='text-center'>Mengalihkan</h5>";
        var id_sesi_pelaksana = document.getElementById("id_sesi_pelaksana").innerHTML;
        var enkrip = document.getElementById("enkrip").innerHTML;
        setTimeout(function(){ document.getElementById("app").innerHTML = "<h5 class='text-center'>Mengalihkan.</h5>"; }, 500);
        setTimeout(function(){ document.getElementById("app").innerHTML = "<h5 class='text-center'>Mengalihkan..</h5>"; }, 1000);
        setTimeout(function(){ document.getElementById("app").innerHTML = "<h5 class='text-center'>Mengalihkan...</h5>"; }, 1500);
        setTimeout(function(){ window.location.href = base_url + "ujian/" + id_sesi_pelaksana + "/" + enkrip; }, 1700);
    }

    function startTimer() {
        timerInterval = setInterval(() => {
            timePassed = timePassed += 1;
            timeLeft = TIME_LIMIT - timePassed;
            document.getElementById("base-timer-label").innerHTML = formatTime(
            timeLeft
            );
            setCircleDasharray();
            setRemainingPathColor(timeLeft);

            if (timeLeft === 0) {
                onTimesUp();
            }
        }, 1000);
    }

    function formatTime(time) {
        const minutes = Math.floor(time / 60);
        let seconds = time % 60;

        if (seconds < 10) {
            seconds = `0${seconds}`;
        }

        return `${minutes}:${seconds}`;
    }

    function setRemainingPathColor(timeLeft) {
        const { alert, warning, info } = COLOR_CODES;
        if (timeLeft <= alert.threshold) {
            document
            .getElementById("base-timer-path-remaining")
            .classList.remove(warning.color);
            document
            .getElementById("base-timer-path-remaining")
            .classList.add(alert.color);
        } else if (timeLeft <= warning.threshold) {
            document
            .getElementById("base-timer-path-remaining")
            .classList.remove(info.color);
            document
            .getElementById("base-timer-path-remaining")
            .classList.add(warning.color);
        }
    }

    function calculateTimeFraction() {
        const rawTimeFraction = timeLeft / TIME_LIMIT;
        return rawTimeFraction - (1 / TIME_LIMIT) * (1 - rawTimeFraction);
    }

    function setCircleDasharray() {
        const circleDasharray = `${(
            calculateTimeFraction() * FULL_DASH_ARRAY
        ).toFixed(0)} 283`;
        document
            .getElementById("base-timer-path-remaining")
            .setAttribute("stroke-dasharray", circleDasharray);
    }
</script>