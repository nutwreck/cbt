<!-- 
|
| CSS By Candra Aji Pamungkas
| candraajipamungkas@gmail.com
|
-->

<style>
    .box-head {
        border-radius: 25px;
        background: #ffffff;
        padding: 0.5%;
        margin:0.5%;
        width: 100%;
        height: auto;
    }
    .box {
        width:85%;
        height:auto;
        background:#FFF;
        margin:40px auto;
        padding-left: 5px;
        padding-right: 5px;
        padding-top: 10px;
        padding-bottom: 10px;
        background: rgb(9,165,255);
        background: -moz-linear-gradient(90deg, rgba(9,165,255,1) 0%, rgba(81,230,218,1) 100%);
        background: -webkit-linear-gradient(90deg, rgba(9,165,255,1) 0%, rgba(81,230,218,1) 100%);
        background: linear-gradient(90deg, rgba(9,165,255,1) 0%, rgba(81,230,218,1) 100%);
        filter: progid:DXImageTransform.Microsoft.gradient(startColorstr="#09a5ff",endColorstr="#51e6da",GradientType=1);
    }
    .effect-box
    {
        position: relative;
    }
    .effect-box:before, .effect-box:after
    {
        z-index: -1;
        position: absolute;
        content: "";
        bottom: 15px;
        left: 10px;
        width: 50%;
        top: 80%;
        max-width:300px;
        background: #777;
        -webkit-box-shadow: 0 15px 10px #777;
        -moz-box-shadow: 0 15px 10px #777;
        box-shadow: 0 15px 10px #777;
        -webkit-transform: rotate(-3deg);
        -moz-transform: rotate(-3deg);
        -o-transform: rotate(-3deg);
        -ms-transform: rotate(-3deg);
        transform: rotate(-3deg);
    }
    .effect-box:after
    {
        -webkit-transform: rotate(3deg);
        -moz-transform: rotate(3deg);
        -o-transform: rotate(3deg);
        -ms-transform: rotate(3deg);
        transform: rotate(3deg);
        right: 10px;
        left: auto;
    }
    .ls-1{
        letter-spacing: 1px;
    }
    .ls-2{
        letter-spacing: 2px;
    }
    .text-informasi{
        font-weight: 500;
        letter-spacing: 1px;
    }
    .bg-gradient-4 {
        
    }
    .rounded {
        border-radius: 1rem !important;
    }
    .base-timer {
        position: relative;
        left: 45%;
        margin-right: -45%;
        width: 100px;
        height: 100px;
    }

    .base-timer__svg {
        transform: scaleX(-1);
    }

    .base-timer__circle {
        fill: none;
        stroke: none;
    }

    .base-timer__path-elapsed {
        stroke-width: 7px;
        stroke: transparent;
    }

    .base-timer__path-remaining {
        stroke-width: 7px;
        stroke-linecap: round;
        transform: rotate(90deg);
        transform-origin: center;
        transition: 1s linear all;
        fill-rule: nonzero;
        stroke: currentColor;
    }

    .base-timer__path-remaining.green {
        color: rgb(65, 184, 131);
    }

    .base-timer__path-remaining.orange {
        color: orange;
    }

    .base-timer__path-remaining.red {
        color: red;
    }

    .base-timer__label {
        position: absolute;
        width: 100px;
        height: 100px;
        top: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 25px;
    }

    .text-card-header{
        font-size:17px;
    }

    .math{
        width:10%;
    }

    .button-round {
        display: inline-flex;
        position: relative;
        height: 50px;
        width: 50px;
        border-radius: 50%;
        margin: 2%;
        padding: 0;
        font-size: 100%;
        font-weight: bold;
        text-align: center;
        align-items: center;
        justify-content: center;
    }

    .button-round span{
        height: 100px;
    }

    .sisawaktu-title{
        margin-bottom:-2%;
    }

    .sisawaktu{
        font-size:2em;
        color: red;
    }

    .modal {
        display: none; /* Hidden by default */
        position: fixed; /* Stay in place */
        z-index: 1; /* Sit on top */
        left: 0;
        top: 0;
        width: 100%; /* Full width */
        height: 100%; /* Full height */
        overflow: hidden; /* Enable scroll if needed */
    }

    .modal-content {
        margin: 3% auto;
        padding: 20px;
        border: 1px solid #888;
        width: 80%;
        height: 80%;
    }

    #msg_title_away{
        font-size: 1.6em;
    }

    #msg_content_away #msg_footer_away{
        font-size: 1.2em;
    }

    /* ***************** */
    /* Responsive device */
    /* ***************** */
    @media only screen and (max-width: 420px) {
        .base-timer {left: 33%; margin-right: -33%;}
        .modal-content {margin: 50% auto;}
        .btn-nxt-brf-hrd {display: none;}
    }
    @media (min-width: 420px)  and (max-width: 780px) {
        .base-timer {left: 38%; margin-right: -38%;}
        .modal-content {margin: 30% auto;}
        .btn-nxt-brf-hrd {display: none;}
    }
    @media (min-width: 780px) and (max-width: 920px) {
        .base-timer {left: 42%; margin-right: -42%;}
        .btn-nxt-brf-hrd {display: none;}
    }
</style>