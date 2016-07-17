/**
 * AngularJS module
 */
var app = angular.module('Magnus', ['infinite-scroll']);

/**
 * Helpful for listing out all the god-forsaken permission columns
 */
app.filter('boolean', function() {
    return function(input) {
        if (input == 1) {
            return 'Yes';
        } else {
            return 'No';
        }
    }
});

/**
 * Throttle the API calls
 */
app.value('THROTTLE_MILLISECONDS', 300);

/**
 * Parse the HTML coming into the page
 */
app.filter("sanitize", ['$sce', function($sce) {
    return function(htmlCode) {
        return $sce.trustAsHtml(htmlCode);
    }
}]);

/**
 * Scroll controller
 */
app.controller('ScrollController', function($scope, Scroller) {
    $scope.scroller = new Scroller();
});

/**
 * Infinite scroll factory
 */
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
        //console.log(params);
        //$location.search('page', params.page - 1);

        var url = 'http://' + window.location.hostname + '/get' + window.location.pathname + '?page=' + this.after + window.location.search.replace(/\?/, '&');
        console.log('Fetching content from', url);
        //console.log('params', params);
        $http.get(url)
            .success(function(data) {
                // var items = data.data.children;
                // console.log(angular.element('[ng-controller=ScrollController]'));
                //angular.element('[ng-controller=ScrollService]').scope().data.push(data);
                //this.items.push(data);
                this.items.push(data);
                this.after++;
                this.busy = false;
            }.bind(this));
    };

    return Scroller;
}]);