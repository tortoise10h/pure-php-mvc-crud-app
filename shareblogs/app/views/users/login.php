<?php require APPROOT . '/views/inc/header.php' ?> 
    <div class="row">
        <div class="col-md-6 mx-auto">
            <div class="card card-body bg-light mt-5">
                <?php echo flash('register_success'); ?> 
                <h2 class="text-center">Login your account to join our community</h2>
                <p class="text-center">Please fill out this form to login</p>
                <form action="<?php echo URLROOT ?>/users/login" method="POST">              
                    <div class="form-group">
                        <label for="email">Email: <sup>*</sup></label>
                        <input type="text" name="email" class="form-control form-control-lg <?php echo (!empty($data['email_err'])) ? 'is-invalid' : '' ?>" value="<?php echo $data['email']; ?>">
                        <span class="invalid-feedback"><?php echo $data['email_err']; ?></span>
                    </div>
                    <div class="form-group">
                        <label for="password">Password: <sup>*</sup></label>
                        <input type="password" name="password" class="form-control form-control-lg <?php echo (!empty($data['password_err'])) ? 'is-invalid' : '' ?>" value="<?php echo $data['password']; ?>">
                        <span class="invalid-feedback"><?php echo $data['password_err']; ?></span>
                    </div>
                    
                    <div class="row">
                        <div class="col">
                            <input type="submit" name="submit" value="Login" class="btn btn-success btn-block">
                        </div>
                        <div class="col">
                            <a href="<?php echo URLROOT ?>/users/register" class="btn btn-default btn-block">No account? Register here</a>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
<?php require APPROOT . '/views/inc/footer.php' ?> 