<style>
    *{
        margin:0;
        padding:0;
        font-family: Nunito;
    }

    #calculator-container {
        width: 400px;
        max-width: 98%;
        margin: 20vh auto;
        margin-bottom: 0;
        border:1px solid rgba(0,0,0,0.35);
        padding: 10px;
        border-radius: 5px;
        background: rgba(241, 243, 244,0.3);
    }

    .expression-view {
        text-align:right;
        min-height: 25px;
        font-weight:bold;
    }

    .result-view {
        padding: 8px 10px;
        border: 1px solid rgba(17, 15, 17,0.4);
        text-align:right;
        margin-top: 10px;
        font-size: 16px;
        font-weight:bold;
        min-height: 40px;
        border-radius: 3px;
        display: block;
        width: 100%;
        box-sizing: border-box;
        background: transparent;
        cursor: text;
        word-break: break-all;
        letter-spacing: 2px;
    }

    .button-container {
        margin-top: 10px;
    }

    .button-container .row {
        width: 100%;
        margin-bottom: 5px;
    }

    .button-container .row:last-child {
        margin-bottom: 0;
    }

    .button-container .row button {
        width: 24%;
        height: 40px;
        text-align: center;
        font-weight: 700;
        font-size: 16px;
        cursor:pointer;
        background: rgb(244, 244, 244);
        outline: 1px solid transparent !important;
        border: 1px solid rgba(0,0,0,0.15);
    }

    .button-container .row button:active {
        transform: translateY(2px);
    }

    .button-container .row button.btn-dark {
        background: rgb(208, 208, 208);
        border: 1px solid rgba(0,0,0,0.1);
    }

    .button-container .row button.btn-result {
        background: rgb(72, 137, 240);
        border: 1px solid rgba(0,0,0,0.1);
        color:white;
        font-size: 18px;
    }
</style>