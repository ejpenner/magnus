@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="panel panel-default">
            <div class="panel-heading">
                Opus Lookup
            </div>
            <div class="panel-body">
                <div ng-controller="TableController" infinite-scroll="TableService.nextPage()">
                    <table class="table" ng-table="tableParams" show-filter="true">
                        <thead>
                        <tr>
                            <th>
                                ID
                                <i class="fa fa-search"
                                   ng-click="showId = !showId"></i>
                                <i class="fa fa-sort"
                                   ng-class="{
                                'fa-sort-asc': tableParams.isSortBy('id', 'asc'),
                                'fa-sort-desc': tableParams.isSortBy('id', 'desc')}"
                                   ng-click="tableParams.sorting({id: tableParams.isSortBy('id', 'asc') ? 'desc' : 'asc' })"></i>
                                <input type="text"
                                       ng-model="params.filter()['id']"
                                       ng-show="showId"
                                       ng-blur="showId = hideField($event)">
                            </th>
                            <th>
                                Name
                                <i class="fa fa-search"
                                   ng-click="showTitle = !showTitle"></i>
                                <i class="fa fa-sort"
                                   ng-class="{
                                'fa-sort-asc': tableParams.isSortBy('title', 'asc'),
                                'fa-sort-desc': tableParams.isSortBy('title', 'desc')}"
                                   ng-click="tableParams.sorting({title: tableParams.isSortBy('title', 'asc') ? 'desc' : 'asc' })"></i>
                                <input type="text"
                                       ng-model="params.filter()['title']"
                                       ng-show="showTitle"
                                       ng-blur="showTitle = hideField($event)">
                            </th>
                            <th>
                                User
                                <i class="fa fa-search"
                                   ng-click="showUsername = !showUsername"></i>
                                <i class="fa fa-sort"
                                   ng-class="{
                                'fa-sort-asc': tableParams.isSortBy('username', 'asc'),
                                'fa-sort-desc': tableParams.isSortBy('username', 'desc')}"
                                   ng-click="tableParams.sorting({username: tableParams.isSortBy('username', 'asc') ? 'desc' : 'asc' })"></i>
                                <input type="text"
                                       ng-model="params.filter()['username']"
                                       ng-show="showUsername"
                                       ng-blur="showUsername = hideField($event)">
                            </th>
                            <th>
                                Views
                                <i class="fa fa-search"
                                   ng-click="showViews = !showViews"></i>
                                <i class="fa fa-sort"
                                   ng-class="{
                                'fa-sort-asc': tableParams.isSortBy('views', 'asc'),
                                'fa-sort-desc': tableParams.isSortBy('views', 'desc')}"
                                   ng-click="tableParams.sorting({views: tableParams.isSortBy('views', 'asc') ? 'desc' : 'asc' })"></i>
                            </th>
                            <th>
                                Created at
                                <i class="fa fa-search"
                                   ng-click="showCreatedAt = !showCreatedAt"></i>
                                <i class="fa fa-sort"
                                   ng-class="{
                                'fa-sort-asc': tableParams.isSortBy('created_at', 'asc'),
                                'fa-sort-desc': tableParams.isSortBy('created_at', 'desc')}"
                                   ng-click="tableParams.sorting({created_at: tableParams.isSortBy('created_at', 'asc') ? 'desc' : 'asc' })"></i>
                                <input type="text"
                                       ng-model="params.filter()['created_at']"
                                       ng-show="showCreatedAt"
                                       ng-blur="showCreatedAt = hideField($event)">
                            </th>
                            <th>
                                Operations
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr ng-repeat="opus in $data">
                            <td data-title="'Id'" sortable="'id'">
                                @{{ opus.id }}
                            </td>
                            <td data-title="'Title'" sortable="'title'">
                                <a href="/opus/@{{ opus.slug }}">@{{ opus.title }}</a>
                            </td>
                            <td data-title="'Username'" sortable="'username'">
                                @{{ opus.username }} <a href="/profile/@{{ opus.user_slug }}">(Profile)</a>
                            </td>
                            <td data-title="'Email'" sortable="'email'">
                                @{{ opus.views }}
                            </td>
                            <td data-title="'Created At'" sortable="'created_at'">
                                @{{ opus.created_at }}
                            </td>
                            <td>
                                <a class="btn btn-info" href="/opus/@{{ opus.slug }}/edit">Edit</a>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection