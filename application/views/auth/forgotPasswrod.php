<div class="row">
      <div class="col-sm-10 col-md-8 col-lg-6 mx-auto d-table h-100">
            <div class="d-table-cell align-middle">

                  <div class="text-center mt-4">
                        <h1 class="h2">Passwort wiederherstellen</h1>
                  </div>
                  <?php 
                        if (isset($_SESSION['code_sent'])) {
                              ?>
                              <p class="py-2 alert alert-success"><?=$_SESSION['code_sent']?></p>
                              <?php
                              unset($_SESSION['code_sent']);
                        }
                        if (isset($_SESSION['no_email_found'])) {
                              ?>
                              <p class="py-2 alert bg-danger text-white"><?=$_SESSION['no_email_found']?></p>
                              <?php
                              unset($_SESSION['no_email_found']);
                        }
                   ?>
                  <div class="card">
                        <div class="card-body">
                              <div class="m-sm-4">

                                    <form method="post" action="<?= site_url('recover/password') ?>">

                                          <div class="mb-3">
                                                <label class="form-label">Ihre E-Maildresse</label>
                                                <input type="email" name="email" required="" class="form-control">
                                          <div class="text-center mt-3">
                                                <button type="submit" class="btn btn-lg btn-color">senden</button>
                                          </div>
                                    </form>
                              </div>
                        </div>
                  </div>

            </div>
      </div>
</div>
<?php unset($_SESSION['login_error']); ?>