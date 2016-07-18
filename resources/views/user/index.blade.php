@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="panel panel-default">
            <div class="panel-heading">
                User Lookup Table
            </div>
            <div class="panel-body">
                <div ng-controller="TableController" infinite-scroll="tableService.nextPage()">
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
                                   ng-click="showName = !showName"></i>
                                <i class="fa fa-sort"
                                   ng-class="{
                                'fa-sort-asc': tableParams.isSortBy('name', 'asc'),
                                'fa-sort-desc': tableParams.isSortBy('name', 'desc')}"
                                   ng-click="tableParams.sorting({name: tableParams.isSortBy('name', 'asc') ? 'desc' : 'asc' })"></i>
                                <input type="text"
                                       ng-model="params.filter()['name']"
                                       ng-show="showName"
                                       ng-blur="showName = hideField($event)">
                            </th>
                            <th>
                                Username
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
                                Email
                                <i class="fa fa-search"
                                   ng-click="showEmail = !showEmail"></i>
                                <i class="fa fa-sort"
                                   ng-class="{
                                'fa-sort-asc': tableParams.isSortBy('email', 'asc'),
                                'fa-sort-desc': tableParams.isSortBy('email', 'desc')}"
                                   ng-click="tableParams.sorting({email: tableParams.isSortBy('email', 'asc') ? 'desc' : 'asc' })"></i>
                                <input type="text"
                                       ng-model="params.filter()['email']"
                                       ng-show="showEmail"
                                       ng-blur="showEmail = hideField($event)">
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
                        </tr>
                        </thead>
                        <tbody>
                        <tr ng-repeat="user in $data">
                            <td data-title="'Id'" sortable="'id'">
                                @{{ user.id }}
                            </td>
                            <td data-title="'Name'" sortable="'name'">
                                @{{ user.name }}
                            </td>
                            <td data-title="'Username'" sortable="'username'">
                                <a href="profile/@{{ user.slug }}">@{{ user.username }}</a>
                            </td>
                            <td data-title="'Email'" sortable="'email'">
                                @{{ user.email }}
                            </td>
                            <td data-title="'Created At'" sortable="'created_at'">
                                @{{ user.created_at }}
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection