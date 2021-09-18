<style>
    .player {
        overflow: hidden;
        z-index: 1;
    }

    .player-video {
        border-radius: 10px;
        width: 762px;
        height: 400px
    }

    /* ***************** */
    /* Responsive device */
    /* ***************** */
    @media only screen and (max-width: 420px) {
        .player-video {
            border-radius: 10px;
            width: 268px;
            height: 190px
        }
    }
    @media (min-width: 420px)  and (max-width: 780px) {
        .player-video {
            border-radius: 10px;
            width: 426px;
            height: 240px
        }
    }
    @media (min-width: 780px) and (max-width: 920px) {
        .player-video {
            border-radius: 10px;
            width: 426px;
            height: 240px
        }
    }
</style>