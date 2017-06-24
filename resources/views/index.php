<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../public/css/vendor.css">
    <link rel="stylesheet" href="../public/css/app.css">
    <title>A ver che</title>
</head>
<body ng-app="miApp">
    <div ng-controller="TestController as test" class="alert alert-success">
        <h1 class="testo">{{test.variableDePrueba}}</h1>
    </div>

    <script src="../public/js/vendor.js"></script>
    <script src="../public/js/app.js"></script>
</body>
</html>