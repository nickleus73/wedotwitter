<!DOCTYPE html>
<html>
    <head>
        <title>Laravel</title>

        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">

        <script src="https://code.jquery.com/jquery-2.2.4.min.js" integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.5.6/angular.min.js"></script>
        <script src="assert/app.js"></script>

        <style type="text/css">
            body {
                padding-top: 75px;
            }
        </style>

    </head>
    <body>
        <nav class="navbar navbar-inverse navbar-fixed-top">
            <div class="container">
                <div class="navbar-header">
                    <a class="navbar-brand" href="#">WE DO TWITTER</a>
                </div>
            </div>
        </nav>

        <div ng-controller="SearchCtrl" class="container">
            <div class="col-lg-offset-2 col-lg-8">
                <div ng-show="error" class="alert alert-danger">
                    <a href="#" class="close" ng-click="error=false">&times;</a>
                    <strong>Error!</strong> All field are required.
                </div>

                <form ng-submit="submitted()" name="form">
                    <div class="form-group has-danger">
                        <input ng-model="search" type="text" class="form-control input-lg" id="search" placeholder="Search..." required>
                    </div>
                    <button type="submit" class="btn btn-default" ng-disabled="form.$invalid">GO !</button>
                </form>

                <div ng-repeat="result in results">
                    <h4>@{{ result.user.name }}</h4>
                    <p>@{{ result.text }}</p>
                </div>
            </div>
        </div>
    </body>
</html>
