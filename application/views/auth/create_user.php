<div class="row">
      <div class="col-sm-10 col-md-8 col-lg-6 mx-auto d-table h-100">
            <div class="d-table-cell align-middle">

                  <div class="text-center mt-4">
                        <h1 class="h2">Signup</h1>
                        <p class="lead">
                              Signup by entering your information.
                        </p>
                  </div>

                  <div class="card">
                        <div class="card-body">
                              <div class="m-sm-4">

                                    <?php if(strlen($message)) { ?>
                                          <div class="alert alert-danger"><div class="alert-message"><?=$message?></div></div>
                                    <?php } ?>

                                    <form method="post" action="<?= site_url('auth/create_user') ?>">
                                          <div class="mb-3">
                                                <label class="form-label">Name</label>
                                                <input class="form-control form-control-lg" type="text" name="name" placeholder="Enter your name" value="" />
                                          </div>
                                          <div class="mb-3">
                                                <label class="form-label">Company</label>
                                                <input class="form-control form-control-lg" type="text" name="company" placeholder="Enter your company name" value="" />
                                          </div>
                                          <div class="mb-3">
                                                <label class="form-label">Address</label>
                                                <input class="form-control form-control-lg" type="text" name="address" placeholder="Enter your address" value="" />
                                          </div>
                                          <div class="mb-3">
                                                <label class="form-label">City</label>
                                                <input class="form-control form-control-lg" type="text" name="city" placeholder="Enter your city" value="" />
                                          </div>
                                          <div class="mb-3">
                                                <label class="form-label">State</label>
                                                <input class="form-control form-control-lg" type="text" name="state" placeholder="Enter your state" value="" />
                                          </div>
                                          <div class="mb-3">
                                                <label class="form-label">Zip</label>
                                                <input class="form-control form-control-lg" type="text" name="zip" placeholder="Enter your postal code" value="" />
                                          </div>
                                          <div class="mb-3">
                                                <label class="form-label">Country</label>
                                                <input class="form-control form-control-lg" type="text" name="country" placeholder="Enter your country" value="" />
                                          </div>
                                          <div class="mb-3">
                                                <label class="form-label">Email</label>
                                                <input class="form-control form-control-lg" type="email" name="email" placeholder="Enter your email" value="" />

                                          </div>
                                          <div class="mb-3">
                                                <label class="form-label">Password</label>
                                                <input class="form-control form-control-lg" type="password" name="password" placeholder="Enter password" value="" />
                                                
                                          </div>
                                          <div class="mb-3">
                                                <label class="form-label">Password</label>
                                                <input class="form-control form-control-lg" type="password" name="password_confirm" placeholder="Enter password again" value="" />
                                                
                                          </div>
                                          <div class="text-center mt-3">
                                                <button type="submit" class="btn btn-lg btn-primary">Sign up</button>
                                          </div>
                                    </form>
                              </div>
                        </div>
                  </div>

            </div>
      </div>
</div>