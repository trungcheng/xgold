<div class="container" ng-controller="UserController" ng-init="loadInit()">
    <div class="row">
        <div class="col-xs-12">
            <div class="page-title-box">
                <div class="pull-left">
                    <h4 class="page-title">USER</h4>                    
                    <div class="clearfix"></div>
                    <a ng-click="addUser()" style="margin-top:10px;" href="javascript:void(0)" class="btn btn-block btn-success btn-sm">
                        <i class="fa fa-plus"></i> 
                        Thêm user
                    </a>
                </div>
                <div class="pull-right price_box">
                    <p>
                        <i class="mdi mdi-gift"></i> Your TKC Balance: <span><b>0</b> TKC</span>
                    </p>
                    <!--<p class="text-right">
                        <a href="#" class="color_blue">Withdraw</a> TKC to MyEtherwallet
                    </p>-->
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12"></div>
    </div>        

    <div class="row">
        <div class="col-md-12">
            <table ng-cloak class="table table-hover table-striped">
                <thead>
                    <th>STT</th>
                    <th>Email</th>
                    <th>Address</th>
                    <th>Mobile</th>
                    <th>Role</th>
                    <th>Option</th>
                </thead>
                <tbody>
                    <tr ng-cloak ng-repeat="user in users track by $index">
                        <td>{{ $index + 1 }}</td>
                        <td>{{ user.email }}</td>
                        <td>{{ user.address }}</td>
                        <td>{{ user.mobile }}</td>
                        <td>{{ (user.is_admin) ? 'Admin' : 'User' }}</td>
                        <td>
                            <button ng-click="editUser(user)" class="btn btn-primary btn-xs" style="margin-right:5px;">
                                <a href="javascript:void(0)">
                                    <i class="fa fa-pencil" aria-hidden="true" style="color:#fff;"></i> 
                                </a>
                            </button>
                            <button ng-click="deleteUser(user)" class="btn btn-danger btn-xs">
                                <a href="javascript:void(0)">
                                    <i class="fa fa-trash" aria-hidden="true" style="color:#fff;"></i> 
                                </a>
                            </button>
                        </td>
                    </tr>

                    <div ng-if="loading">
                        <i style="font-size:40px;position:fixed;left:50%;top:35%;z-index:99;" class="fa fa-spinner fa-spin"></i>
                    </div>

                    <div ng-if="!loading && users.length === 0">
                        <h5 style="font-size:17px;color:#f00;margin-bottom:30px;margin-top:10px;">Oops! Không tìm thấy user!</h5>
                    </div>

                </tbody>
            </table>
        
        </div>

    </div>

</div> <!-- container -->

<script type="text/ng-template" id="popup-add.html">
    <div class="modal-header">
        <button type="button" class="close" ng-click="close()">&times;</button>
        <h3 class="modal-title">Add user</h3>
    </div>
    <div class="modal-body">
        <div class="form-group">
            <label>Email</label>
            <input type="text" ng-model="userModalAdd.email" class="form-control">
        </div>
        <div class="form-group">
            <label>Address</label>
            <input type="text" ng-model="userModalAdd.address" class="form-control">
        </div>
        <div class="form-group">
            <label>Mobile</label>
            <input type="text" ng-model="userModalAdd.mobile" class="form-control">
        </div>
        <div class="form-group">
            <label>Role</label>
            <select class="form-control" ng-model="userModalAdd.selectedOption">
                <option ng-repeat="value in ['Admin','User']">{{ value }}</option>
            </select>
        </div>
    </div>
    <div class="modal-footer">
        <button ng-click="add()" type="button" class="btn btn-primary">Add</button>
        <button ng-click="close()" type="button" class="btn btn-default">Close</button>
    </div>
</script>

<script type="text/ng-template" id="popup-edit.html">
    <div class="modal-header">
        <button type="button" class="close" ng-click="close()">&times;</button>
        <h3 class="modal-title">Edit user</h3>
    </div>
    <div class="modal-body">
        <div class="form-group">
            <label>Email</label>
            <input type="text" ng-model="userModal.email" class="form-control">
        </div>
        <div class="form-group">
            <label>Address</label>
            <input type="text" ng-model="userModal.address" class="form-control">
        </div>
        <div class="form-group">
            <label>Mobile</label>
            <input type="text" ng-model="userModal.mobile" class="form-control">
        </div>
        <div class="form-group">
            <label>Role</label>
            <select class="form-control" ng-model="userModal.selectedOption">
                <option ng-repeat="value in ['Admin','User']">{{ value }}</option>
            </select>
        </div>
    </div>
    <div class="modal-footer">
        <button ng-click="update()" type="button" class="btn btn-primary">Update</button>
        <button ng-click="close()" type="button" class="btn btn-default">Close</button>
    </div>
</script>