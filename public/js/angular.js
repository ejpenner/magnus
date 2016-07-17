var app = angular.module('Magnus', [
    'infinite-scroll'
]).filter('boolean', function() {
    return function(input) {
        if (input == 1) {
            return 'Yes';
        } else {
            return 'No';
        }
    }
});

app.value('THROTTLE_MILLISECONDS', 1000);

//angular.module('infinite-scroll')
app.filter("sanitize", ['$sce', function($sce) {
    return function(htmlCode) {
        return $sce.trustAsHtml(htmlCode);
    }
}]);

app.controller('ScrollController', function($scope, Scroller) {
    $scope.scroller = new Scroller();
});

// Reddit constructor function to encapsulate HTTP and pagination logic
app.factory('Scroller', ['$http', '$location', function($http, $location, $scope) {
    var Scroller = function() {
        this.items = [];
        this.busy = false;
        this.after = 2;
    };

    Scroller.prototype.nextPage = function() {
        if (this.busy) return;
        this.busy = true;

        params = $location.search();
        params.page = this.after;
        var url = 'http://' + window.location.hostname + '/get' + window.location.pathname + '?page=' + this.after;
        console.log(url);
        console.log('params', params);
        $http.get(url)

        .success(function(data) {
            // var items = data.data.children;
            // console.log(angular.element('[ng-controller=ScrollController]'));
            //angular.element('[ng-controller=ScrollService]').scope().data.push(data);
            //this.items.push(data);

            this.items.push(data);


            // for (var i = 0; i < items.length; i++) {
            //     this.items.push(items[i].data);
            // }

            this.after++;
            this.busy = false;
        }.bind(this));
    };

    return Scroller;
}]);