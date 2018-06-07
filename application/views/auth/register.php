<div class="body">
    <form action="http://scripts.codeglamour.com/ci_material_admin/auth/register" class="login-form"  method="post" accept-charset="utf-8">
        <input type="hidden" name="csrf_test_name" value="fae9286a4da153098025841e60017994" />
        
        <div class="msg">Create a Account</div>
        <div class="input-group">
            <span class="input-group-addon">
                <i class="material-icons">person</i>
            </span>
            <div class="form-line">
                <input type="text" class="form-control" name="firstname" placeholder="First Name" required autofocus>
            </div>
        </div>
        <div class="input-group">
            <span class="input-group-addon">
                <i class="material-icons">person</i>
            </span>
            <div class="form-line">
                <input type="text" class="form-control" name="lastname" placeholder="Last Name" required autofocus>
            </div>
        </div>
        <div class="input-group">
            <span class="input-group-addon">
                <i class="material-icons">email</i>
            </span>
            <div class="form-line">
                <input type="text" class="form-control" name="email" placeholder="email" required autofocus>
            </div>
        </div>
        <div class="input-group">
            <span class="input-group-addon">
                <i class="material-icons">lock</i>
            </span>
            <div class="form-line">
                <input type="password" class="form-control" name="password" placeholder="Password" required>
            </div>
        </div>
        <div class="input-group">
            <span class="input-group-addon">
                <i class="material-icons">lock</i>
            </span>
            <div class="form-line">
                <input type="password" class="form-control" name="confirm_password" placeholder="Confirm Password" required>
            </div>
        </div>
        <div class="form-group">
            <input type="checkbox" name="terms" id="terms" class="filled-in chk-col-pink">
            <label for="terms">I read and agree to the <a href="javascript:void(0);">terms of usage</a>.</label>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <input type="submit" name="submit" id="submit" class="btn btn-block btn-success waves-effect" value="Register">
            </div>
        </div>
        <div class="m-t-25 align-center">
            <a href="http://scripts.codeglamour.com/ci_material_admin/auth/login">You already have a account?</a>
        </div>
    </form>            
</div>
