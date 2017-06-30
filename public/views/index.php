<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../public/css/vendor.css">
    <link rel="stylesheet" href="../public/css/app.css">
    <title>A ver che</title>
</head>
<body ng-app="miApp">
<nav ng-controller="NavController as nc" ng-include src="'views/components/navbar.html'"></nav>
<header></header>
<main>
    <div ng-controller="TestController as test" class="alert alert-success">
        <h1>{{test.variableDePrueba}}</h1>
    </div>
</main>
<footer></footer>
<script src="../public/js/vendor.js"></script>
<script src="../public/js/app.js"></script>
</body>
</html>