<div class="row">
      <div class="col-sm-10 col-md-8 col-lg-6 mx-auto d-table h-100">
            <div class="d-table-cell align-middle">

                  <div class="text-center mt-4">
                        <h1 class="h2">Recover Password</h1>
                  </div>
                  <div class="card">
                        <div class="card-body">
                              <div class="m-sm-4">

                                    <form method="post" action="<?= site_url('update/password') ?>">

                                          <div class="mb-3">
                                                <label class="form-label">New Password</label>
                                                <input type="password" name="password" required="" class="form-control">
                                                <?php
                                                if ($_SESSION['update_pass_error']) {
                                                      echo form_update_pass_error('password');
                                                }
                                                ?>

                                                <label class="form-label">Confirm Password</label>
                                                <input type="password" name="conf_pass" required="" class="form-control">
                                                <?php
                                                if ($_SESSION['update_pass_error']) {
                                                      echo form_error('conf_pass');
                                                }
                                                ?>

                                                <input type="hidden" name="id" value="<?=$id?>">
                                          <div class="text-center mt-3">
                                                <button type="submit" class="btn btn-lg btn-primary">Update Password</button>
                                          </div>
                                    </form>
                              </div>
                        </div>
                  </div>

            </div>
      </div>
</div>
<?php unset($_SESSION['update_pass_error']); ?>