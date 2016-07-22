/**
 * AngularJS module
 */
var app = angular.module('Magnus', ['infinite-scroll', 'ngTable', 'ngResource']);

/**
 * for listing out all the permission columns
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
 * Username decorator filter
 */
app.filter('username', function() {
    return function(input, role) {
        if (role == 'dev') {
            return "<span class=\"username role-developer\">" + input + "</span>";
        } else if (role == 'admin') {
            return "<span class=\"username role-administrator\">" + input + "</span>";
        } else if (role == 'gmod') {
            return "<span class=\"username role-globalModerator\">" + input + "</span>";
        } else if (role == 'mod') {
            return "<span class=\"username role-moderator\">" + input + "</span>";
        } else if (role == 'banned') {
            return "<span class=\"username role-banned\">" + input + "</span>";
        } else {
            return "<span class=\"username\">" + input + "</span>";
        }
    }
});

/**
 * Throttle the API calls
 */
app.value('THROTTLE_MILLISECONDS', 0);

/**
 * Parse the HTML coming into the page
 */
app.filter("sanitize", ['$sce', function($sce) {
    return function(htmlCode) {
        return $sce.trustAsHtml(htmlCode);
    }
}]);

app.controller('ScrollController', function($scope, ScrollService) {
    $scope.scroller = new ScrollService();
});

/**
 * Infinite scroll factory
 */
app.factory('ScrollService', ['$http', '$location', function($http, $location, $scope) {
    var Scroller = function() {
        this.items = [];
        this.busy = false;
        this.after = 1;
    };

    Scroller.prototype.nextPage = function() {
        if (this.busy) return;
        this.busy = true;

        params = $location.search();
        params.page = this.after;

        var url = window.location.pathname + window.location.search; //.replace(/\?/, '&');

        console.log('Fetching content from', url);
        console.log('params', params);
        $http.get(url, {
                params: params
            })
            .success(function(data) {
                var items = data.data;

                if (items.length > 0) {
                    for (var i = 0; i < items.length; i++) {
                        if (i % 6 == 0) {
                            this.items.push({
                                row: items.slice(i, i + 6)
                            });
                        }
                    }
                    console.log('Content fetched');
                    this.after++;
                    this.busy = false;
                } else {
                    console.log('ScrollService: aborted, end of list');
                }
            }.bind(this));
    };

    return Scroller;
}]);


/**
 * Fetches data for ngTables
 */
app.factory('TableService', ['$http', '$location',
    function($http, $location) {
        var Entry = function() {
            this.busy = false;
            this.after = 2;
        };

        Entry.prototype.nextPage = function() {
            if (this.busy) {
                return;
            }

            this.busy = true;

            params = $location.search();
            params.page = this.after;
            var url = window.location.pathname;

            $http.get(url, {
                params: params
            }).success(function(data) {
                var items = data.data;
                for (var i = 0; i < items.length; i++) {
                    angular.element('[ng-controller=TableController]').scope().tableParams.data.push(items[i]);
                }
                this.after++;
                this.busy = false;
            }.bind(this));
        };

        return Entry;
    }
]);

/**
 * Controller for ngTable pages
 */
app.controller('TableController', ['$scope', '$location', '$filter', '$resource', 'ngTableParams', 'TableService', '$rootScope',
    function($scope, $location, $filter, $resource, ngTableParams, TableService, $rootScope) {

        var Api = $resource(window.location.pathname);

        $rootScope.pathname = window.location.pathname;

        $scope.TableService = new TableService();

        $scope.tableParams = new ngTableParams(angular.extend({
            page: 1,
            count: 20
        }, $location.search()), {
            total: 0,
            counts: [],
            getData: function($defer, params) {
                $location.search(params.url());

                Api.get(params.url(), function(data) {
                    var orderedData = data.data;

                    params.total(orderedData.length);

                    $defer.resolve(orderedData);
                });
            }
        });

        $scope.hideField = function(e) {
            if (e.target.value == '') {
                return false;
            } else {
                return true;
            }
        }

    }
]);