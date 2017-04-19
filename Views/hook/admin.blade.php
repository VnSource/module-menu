@push('head')
<script type="text/ng-template" id="menu.html">
    <div ng-controller="MenuCtrl">
        <div class="container-fluid">
            <div vns-table="tableParams"></div>
        </div>
        <div class="content-btn">
            <button ng-disabled="isLoading" class="btn btn-default btn-sm" ng-click="tableParams.reload()"><i class="fa fa-refresh fa-fw"></i> {{ __('Reload') }}</button>
            <button class="btn btn-success btn-sm" ng-click="new()"><i class="fa fa-file-o fa-fw"></i> {{ __('New menu') }}</button>
        </div>
    </div>
</script>
<script type="text/ng-template" id="menu/new.html">
    <div class="modal-header">
        <h4 class="modal-title">{{ __('New menu') }}</h4>
    </div>
    <div class="modal-body">
        <table class="table table-striped table-bordered" style="margin-bottom: 0">
            <colgroup>
                <col width="25%">
                <col>
            </colgroup>
            <tbody>
            <tr>
                <td>{{__('Name')}}</td>
                <td>
                    <input class="form-control" type="text" ng-model="menu.name">
                </td>
            </tr>
            <tr>
                <td>{{__('Url')}}</td>
                <td>
                    <input class="form-control" type="text" ng-model="menu.slug">
                </td>
            </tr>
            <tr>
                <td>{{__('Title')}}</td>
                <td>
                    <input class="form-control" type="text" input-copy="menu.name" ng-model="menu.title">
                </td>
            </tr>
            <tr>
                <td>{{__('Target')}}</td>
                <td>
                    <select class="form-control" ng-model="menu.target">
                        <option value="_blank">_blank</option>
                        <option value="_parent">_parent</option>
                        <option value="_self">_self</option>
                        <option value="_top">_top</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td>{{__('Status')}}</td>
                <td>
                    <div class="btn-group">
                        <label class="btn btn-default" ng-model="menu.status" uib-btn-radio="true">{{__('Enabled')}}</label>
                        <label class="btn btn-default" ng-model="menu.status" uib-btn-radio="false">{{__('Disabled')}}</label>
                    </div>
                </td>
            </tr>
            <tr>
                <td>{{__('Parent menu')}}</td>
                <td>
                    <dropdown-select ng-model="menu.parent" options="menus" empty-label="{{__('Root menu')}}"></dropdown-select>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-default" ng-click="save()">{{__('Save')}}</button>
        <button type="button" class="btn btn-primary" ng-click="close()">{{__('Close')}}</button>
    </div>
</script>
<script type="text/ng-template" id="menu/edit.html">
    <div class="modal-header">
        <h4 class="modal-title">{{ __('Edit menu') }}: @{{name}}</h4>
    </div>
    <div class="modal-body">
        <table class="table table-striped table-bordered" style="margin-bottom: 0">
            <colgroup>
                <col width="25%">
                <col>
            </colgroup>
            <tbody>
            <tr>
                <td>{{__('Name')}}</td>
                <td>
                    <input class="form-control" type="text" ng-model="menu.name">
                </td>
            </tr>
            <tr>
                <td>{{__('Url')}}</td>
                <td>
                    <input class="form-control" type="text" ng-model="menu.slug">
                </td>
            </tr>
            <tr>
                <td>{{__('Title')}}</td>
                <td>
                    <input class="form-control" type="text" ng-model="menu.title">
                </td>
            </tr>
            <tr>
                <td>{{__('Target')}}</td>
                <td>
                    <select class="form-control" ng-model="menu.target">
                        <option value="_blank">_blank</option>
                        <option value="_parent">_parent</option>
                        <option value="_self">_self</option>
                        <option value="_top">_top</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td>{{__('Status')}}</td>
                <td>
                    <div class="btn-group">
                        <label class="btn btn-default" ng-model="menu.status" uib-btn-radio="true">{{__('Enabled')}}</label>
                        <label class="btn btn-default" ng-model="menu.status" uib-btn-radio="false">{{__('Disabled')}}</label>
                    </div>
                </td>
            </tr>
            <tr>
                <td>{{__('Parent')}}</td>
                <td>
                    <dropdown-select ng-model="menu.parent" options="menus" empty-label="{{__('Root menu')}}"></dropdown-select>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-default" ng-click="save()">{{__('Save')}}</button>
        <button type="button" class="btn btn-primary" ng-click="close()">{{__('Close')}}</button>
    </div>
</script>
<script type="text/javascript">
    VnSapp.controller('MenuCtrl', function ($rootScope, $scope, $uibModal, $resource, $http, vnsTableParams, Dialog, Notification) {
        $rootScope.siteTitle = '{{__('Menus')}}';

        var Menu = $resource(API_URL + '/menu/:id', { id: '@id' }, {
            update: {
                method: 'PUT'
            }
        });

        var tableParams = $scope.tableParams = new vnsTableParams({
            columns: {
                id: {
                    label: '{{__('Id')}}',
                    type: 'fixed',
                    dragShow: true
                },
                name: {
                    label: '{{__('Name')}}',
                    dragShow: true
                },
                slug: {
                    label: '{{__('Url')}}'
                },
                order: {
                    label: '{{__('Order')}}',
                    order: API_URL + '/menu/sort'
                },
                status: {
                    label: '{{__('Status')}}',
                    type: 'status'
                }
            },
            actions: [
                {
                    label: '{{__('View')}}',
                    icon: 'fa fa-eye fa-fw',
                    callback: function (row) {
                        $scope.view(row);
                    }
                },
                {
                    label: '{{__('Edit')}}',
                    icon: 'fa fa-pencil fa-fw',
                    callback: function (row) {
                        $scope.edit(row);
                    }
                },
                'divider',
                {
                    label: '{{__('Clear cache')}}',
                    icon: 'fa fa-eraser fa-fw',
                    callback: function (row) {
                        $scope.cache(row);
                    }
                },
                {
                    label: '{{__('Delete')}}',
                    icon: 'fa fa-trash-o fa-fw',
                    callback: function (row) {
                        $scope.delete(row);
                    }
                }
            ],
            breadcrumb: {
                root: {id: 0, name: '{{__('Root menu')}}'}
            },
            getData: function (params) {
                return Menu.query(params.url(), function (data) {
                    return data;
                });
            }
        });

        $scope.view = function (row) {
            $scope.tableParams.breadcrumbAdd(row);
        };

        $scope.toggleStatus = function (row) {
            var $menu = angular.copy(row);
            $menu.status = !row.status;
            $menu.toggleStatus = true;
            $menu.$update(function (res) {
                row.status = !row.status;
                Notification.success('{{__('Saved successfully')}}');
            }, function (xhr) {
                if (xhr.status == 422) {
                    var validatorError = [];
                    for (key in xhr.data) {
                        validatorError.push(key + ': ' + (typeof xhr.data[key] =='string'?xhr.data[key]:xhr.data[key][0]));
                    }
                    Notification.error(validatorError.join('<br>'));
                }
            });
        };

        $scope.new = function () {
            $uibModal.open({
                animation: true,
                templateUrl: 'menu/new.html',
                controller: function ($scope, $uibModalInstance, menus) {
                    $scope.menu = {
                        name: '',
                        slug: '',
                        title: '',
                        target: '',
                        parent: currentMenu,
                        status: true
                    };
                    $scope.menus = menus;
                    $scope.save = function () {
                        var $menu = new Menu($scope.menu);
                        $menu.$save(function (res) {
                            tableParams.reload();
                            $uibModalInstance.dismiss('close');
                            Notification.success('{{__('Saved successfully')}}');
                        }, function (xhr) {
                            if (xhr.status == 422) {
                                var validatorError = [];
                                for (key in xhr.data) {
                                    validatorError.push(key + ': ' + (typeof xhr.data[key] =='string'?xhr.data[key]:xhr.data[key][0]));
                                }
                                Notification.error(validatorError.join('<br>'));
                            }
                        });
                    };
                    $scope.close = function () {
                        $uibModalInstance.dismiss('close');
                    };
                },
                backdrop: 'static',
                windowClass: 'modal-full',
                resolve: {
                    menus: function () {
                        return allMenu;
                    }
                }
            });
        };

        $scope.edit = function (row) {
            Menu.get({id: row.id}, function(data) {
                $uibModal.open({
                    animation: true,
                    templateUrl: 'menu/edit.html',
                    controller: function ($scope, $uibModalInstance) {
                        $scope.menu = data;
                        $scope.name = angular.copy(data.name);
                        $scope.save = function () {
                            var $menu = angular.copy($scope.menu);
                            $menu.$update(function (res) {
                                row.name = angular.copy($scope.menu.name);
                                row.slug = angular.copy($scope.menu.slug);
                                row.status = angular.copy($scope.menu.status);
                                $uibModalInstance.dismiss('close');
                                Notification.success('{{__('Saved successfully')}}');
                            }, function (xhr) {
                                if (xhr.status == 422) {
                                    var validatorError = [];
                                    for (key in xhr.data) {
                                        validatorError.push(key + ': ' + (typeof xhr.data[key] =='string'?xhr.data[key]:xhr.data[key][0]));
                                    }
                                    Notification.error(validatorError.join('<br>'));
                                }
                            });
                        };
                        $scope.close = function () {
                            $uibModalInstance.dismiss('close');
                        };
                    },
                    backdrop: 'static',
                    windowClass: 'modal-full'
                });
            });

        };

        $scope.cache = function (row) {
            Dialog.confirm(__('Are you sure you want to clear cache <b>:name</b>?', {name: row.name}))
                    .result.then(function () {
                $http.post(API_URL + '/cache/clear/gadgetMenu_'+row.slug).then(function(respone) {
                    if(respone.data.success) {
                        Notification.success('{{__('Clear successfully')}}');
                    } else {
                        Notification.error(respone.data.message);
                    }
                });
            });
        };

        $scope.delete = function (row) {
            Dialog.confirm(__('Are you sure you want to delete <b>:name</b>?', {name: row.name}))
                    .result.then(function () {
                row.$delete(function (res) {
                    tableParams.reload();
                    Notification.success('{{__('Delete successfully')}}');
                })
            });
        };
    });
</script>
@endpush
@navbarcpanel([
    'icon' => 'fa fa-list fa-fw',
    'label' => 'Menus',
    'permission' => 'menu',
    'name' => 'root.menu',
    'url' => 'menu',
    'template' => 'menu.html'
])
