<div class="body">
    <form action="http://scripts.codeglamour.com/ci_material_admin/auth/login" class="login-form"  method="post" accept-charset="utf-8">
		<input type="hidden" name="csrf_test_name" value="fae9286a4da153098025841e60017994" />                                                     
        <div class="msg">Sign in to start your session</div>
        <div class="input-group">
            <span class="input-group-addon">
                <i class="material-icons">person</i>
            </span>
            <div class="form-line">
                <input type="text" class="form-control" name="email" placeholder="Email" required autofocus>
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
        <div class="row">
            <div class="col-xs-7">
                <input type="checkbox" name="rememberme" id="rememberme" class="filled-in chk-col-pink">
                <label for="rememberme">Remember Me</label>
            </div>
            <div class="col-xs-5 text-right">
                <a  href="http://scripts.codeglamour.com/ci_material_admin/auth/forgot_password">Forgot password?</a>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <input type="submit" name="submit" id="submit" class="btn btn-block btn-success waves-effect" value="Submit">
            </div>
        </div>
        <div class="m-t-25 align-center">
            <a href="http://scripts.codeglamour.com/ci_material_admin/auth/register">Don't have an account? Sign Up</a>
        </div>
    </form>            
</div>