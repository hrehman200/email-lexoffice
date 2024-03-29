<div class="row">
      <div class="col-sm-10 col-md-8 col-lg-6 mx-auto d-table h-100">
            <div class="d-table-cell align-middle">

                  <div class="text-center mt-4">
                        <h1 class="h2">EMAIL INVOICE Login</h1>
                  </div>

                  <?php
                  if (isset($_SESSION['activation_pending'])) {
                        ?>
                        <p class="alert alert-warning my-2">
                              <?php
                              echo $_SESSION['activation_pending'];
                              ?>
                        </p>
                        <?php
                        unset($_SESSION['activation_pending']);
                  }
                  if (isset($_SESSION['activation_success'])) {
                        ?>
                        <p class="alert alert-success my-2">
                              <?php
                              echo $_SESSION['activation_success'];
                              ?>
                        </p>
                        <?php
                        unset($_SESSION['activation_success']);
                  }
                  if (isset($_SESSION['no_record_found'])) {
                        ?>
                        <p class="alert alert-danger my-2">
                              <?php
                              echo $_SESSION['no_record_found'];
                              ?>
                        </p>
                        <?php
                        unset($_SESSION['no_record_found']);
                  }
                  if (isset($_SESSION['account_not_active'])) {
                        ?>
                        <p class="alert alert-danger my-2">
                              <?php
                              echo $_SESSION['account_not_active'];
                              ?>
                        </p>
                        <?php
                        unset($_SESSION['account_not_active']);
                  }
                  if (isset($_SESSION['password_updata'])) {
                        ?>
                        <p class="alert alert-success my-2">
                              <?php
                              echo $_SESSION['password_updata'];
                              ?>
                        </p>
                        <?php
                        unset($_SESSION['password_updata']);
                  }
                  ?>

                  <div class="card">
                        <div class="card-body">
                              <div class="m-sm-4">

                                    <?php if (strlen($message)) { ?>
                                          <div class="alert alert-danger">
                                                <div class="alert-message">
                                                      <?= $message ?>
                                                </div>
                                          </div>
                                    <?php } ?>

                                    <form method="post" action="<?= site_url('auth/signin') ?>">

                                          <div class="mb-3">
                                                <label class="form-label">Ihre Emaildresse</label>
                                                <input class="form-control form-control-lg" type="email" name="email"
                                                      placeholder="Ihre E-Maildresse" value="<?php if ($_SESSION['login_error']) {
                                                            echo set_value('email');
                                                      } ?>" />
                                                <?php
                                                if ($_SESSION['login_error']) {
                                                      echo '<div class="text-danger">' . form_error('email') . '</div>';
                                                }
                                                ?>

                                          </div>
                                          <div class="mb-3">
                                                <label class="form-label">Passwort</label>
                                                <input class="form-control form-control-lg" type="password"
                                                      name="password" placeholder="Passwort" value="<?php if ($_SESSION['login_error']) {
                                                            echo set_value('password');
                                                      } ?>" />
                                                <?php
                                                if ($_SESSION['login_error']) {
                                                      echo '<div class="text-danger">' . form_error('password') . '</div>';
                                                }
                                                ?>

                                          </div>
                                          <a href="<?= base_url('forgotpassword') ?>">Passwort vergessen?</a>
                                          <div class="text-center mt-3">
                                                <button type="submit" class="btn btn-lg btn-color">Login</button>
                                          </div>
                                    </form>
                              </div>
                        </div>
                  </div>

            </div>
      </div>
</div>
<?php unset($_SESSION['login_error']); ?>