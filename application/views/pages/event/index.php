<div class="container" ng-controller="EventController" ng-init="loadInit()">
    <div class="row">
        <div class="col-xs-12">
            <div class="page-title-box">
                <div class="pull-left">
                    <h4 class="page-title">EVENT</h4>                    
                    <div class="clearfix"></div>
                    <a ng-click="addEvent()" style="margin-top:10px;" href="javascript:void(0)" class="btn btn-block btn-success btn-sm">
                        <i class="fa fa-plus"></i> 
                        Thêm event
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
                    <th>Name</th>
                    <th>From date</th>
                    <th>To date</th>
                    <th>Bonus (%)</th>
                    <th>Active</th>
                    <th>Option</th>
                </thead>
                <tbody>
                    <tr ng-cloak ng-repeat="event in events track by $index">
                        <td>{{ $index + 1 }}</td>
                        <td>{{ event.name }}</td>
                        <td>{{ event.from_date }}</td>
                        <td>{{ event.to_date }}</td>
                        <td>{{ event.bonus }}%</td>
                        <td>{{ (event.is_selected) ? 'Yes' : 'No' }}</td>
                        <td>
                            <button ng-click="editEvent(event)" class="btn btn-primary btn-xs" style="margin-right:5px;">
                                <a href="javascript:void(0)">
                                    <i class="fa fa-pencil" aria-hidden="true" style="color:#fff;"></i> 
                                </a>
                            </button>
                            <button ng-click="deleteEvent(event)" class="btn btn-danger btn-xs">
                                <a href="javascript:void(0)">
                                    <i class="fa fa-trash" aria-hidden="true" style="color:#fff;"></i> 
                                </a>
                            </button>
                        </td>
                    </tr>

                    <div ng-if="loading">
                        <i style="font-size:40px;position:fixed;left:50%;top:35%;z-index:99;" class="fa fa-spinner fa-spin"></i>
                    </div>

                    <div ng-if="!loading && events.length === 0">
                        <h5 style="font-size:17px;color:#f00;margin-bottom:30px;margin-top:10px;">Oops! Không tìm thấy event!</h5>
                    </div>

                </tbody>
            </table>
        
        </div>

    </div>

</div> <!-- container -->

<script type="text/ng-template" id="popup-add.html">
    <div class="modal-header">
        <button type="button" class="close" ng-click="close()">&times;</button>
        <h3 class="modal-title">Add event</h3>
    </div>
    <div class="modal-body">
        <div class="form-group">
            <label>Name</label>
            <input type="text" ng-model="eventModalAdd.name" class="form-control" placeholder="Event name...">
        </div>
        <div class="form-group col-md-6" style="padding-left:0px">
            <label>From date</label>
            <input placeholder="Event time start..." type="text" ng-model="eventModalAdd.from_date" class="form-control datetimepicker">
        </div>
        <div class="form-group col-md-6" style="padding-right:0px;">
            <label>To date</label>
            <input placeholder="Event time end..." type="text" ng-model="eventModalAdd.to_date" class="form-control datetimepicker">
        </div>
        <div class="form-group">
            <label>Bonus</label>
            <input placeholder="Event bonus..." type="text" ng-model="eventModalAdd.bonus" class="form-control">
        </div>
        <div class="form-group">
            <label>Kích hoạt</label>
            <select class="form-control" ng-model="eventModalAdd.selectedOption">
                <option ng-repeat="value in ['Yes','No']">{{ value }}</option>
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
        <h3 class="modal-title">Edit event</h3>
    </div>
    <div class="modal-body">
        <input type="hidden" ng-model="eventModal.event_id">
        <div class="form-group">
            <label>Name</label>
            <input type="text" ng-model="eventModal.name" class="form-control" placeholder="Event name...">
        </div>
        <div class="form-group">
            <label>From date</label>
            <input placeholder="Event time start..." type="text" ng-model="eventModal.from_date" class="form-control datetimepicker">
        </div>
        <div class="form-group">
            <label>To date</label>
            <input placeholder="Event time end..." type="text" ng-model="eventModal.to_date" class="form-control datetimepicker">
        </div>
        <div class="form-group">
            <label>Bonus</label>
            <input placeholder="Event bonus..." type="text" ng-model="eventModal.bonus" class="form-control">
        </div>
        <div class="form-group">
            <label>Kích hoạt</label>
            <select class="form-control" ng-model="eventModal.selectedOption">
                <option ng-repeat="value in ['Yes','No']">{{ value }}</option>
            </select>
        </div>
    </div>
    <div class="modal-footer">
        <button ng-click="update()" type="button" class="btn btn-primary">Update</button>
        <button ng-click="close()" type="button" class="btn btn-default">Close</button>
    </div>
</script>