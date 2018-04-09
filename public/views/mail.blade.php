<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }
    .mail-container {
        max-width: 48rem;
        background-color: #fbfcff;
        position: relative;
        color: gray;
        font-weight: lighter;
        font-family: sans-serif;
        overflow: hidden;
    }
    .mail-header {
        padding-top: 25%;
        width: 100%;
        min-width: 33rem;
    }
    .mail-bg-top {
        background: url('https://lh3.google.com/u/0/d/1Lx2RC67jG7d2-DWKpJncFqk8nVmuxpcf=w1920-h948-iv2');
        background-size: contain;
        background-repeat: no-repeat;
    }
    /* .mail-logo {
        min-width: 10rem;
        width: 40%;
        height: 10rem;
        position: absolute;
        top: 1rem;
        left: 1rem;
    }
    .mail-logo-bg {
        background: url('https://lh3.google.com/u/0/d/1L2uLoNGurVCa9yDtDM0sjGCQojpFFl2I=w1920-h948-iv1');
        background-size: contain;
        background-repeat: no-repeat;
    } */
    .mail-body {
        padding: 3rem 1.5rem 4rem 1.5rem;
    }
    .mail-body-content {
        padding-top: 1rem;
    }
    .mail-footer {

    }
    .mail-footer-bg {
        background: url('https://lh3.google.com/u/0/d/1h0Vfanv2P7uzbV-BPjKKspYHn87Omb17=w1920-h948-iv1');
        background-size: contain;
        background-repeat: no-repeat;
        width: 100%;
        padding-top: 14.5%;
    }
    .mail-footer-disclaimer {
        color: white;
        background-color: #00d476;
        position: relative;
        top: -0.2rem;
        padding: 2rem;
    }
</style>
<body>
    <div class="mail-container">
        <div class="mail-header mail-bg-top">
            <!-- <div class="mail-logo mail-logo-bg"></div> -->
        </div>
        <div class="mail-body">
            <h2 class="mail-body-title">{{ $title }}</h2>
            <p class="mail-body-content">{!! $content !!}</p>
        </div>
        <div class="mail-footer">
            <div class="mail-footer-bg"></div>
            <p class="mail-footer-disclaimer"></p>
        </div>
    </div>
</body>
</html>