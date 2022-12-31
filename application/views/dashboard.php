<div class="row">
      <div class="col-sm-10 col-md-8 col-lg-6 mx-auto d-table h-100">
            <div class="d-table-cell align-middle">
                  <div class="card">
                        <div class="card-body">
                              <div class="m-sm-4">

                                    <?php if (strlen($message)) { ?>
                                          <div class="alert alert-danger">
                                                <div class="alert-message"><?= $message ?></div>
                                          </div>
                                    <?php }

                                    if (isset($_SESSION['lex_detail_update_success'])) {
                                    ?>
                                          <p class="alert alert-success py-2"> <?= $_SESSION['lex_detail_update_success'] ?> </p>
                                    <?php
                                          unset($_SESSION['lex_detail_update_success']);
                                    }
                                    if (isset($_SESSION['lex_detail_update_error'])) {
                                    ?>
                                          <p class="alert alert-danger py-2"> <?= $_SESSION['lex_detail_update_error'] ?> </p>
                                    <?php
                                    }
                                    ?>

                                    <form method="post" action="<?= site_url('lex/detail') ?>">

                                          <div class="mb-3">
                                                <label class="form-label">LexOffice API Key</label>
                                                <input class="form-control form-control-lg" type="text" name="lexapikey" placeholder="Enter your lex api key" value="<?= $user['lex_api_key'] ?>" />
                                                <?php
                                                if ($_SESSION['lex_error']) {
                                                      echo form_error('lexapikey');
                                                }
                                                ?>

                                          </div>
                                          <div class="mb-3 <?= !$user['lex_api_key'] ? 'd-none' : ''?>">
                                                <label class="form-label">LexOffice Email</label>
                                                <br>
                                                <label><b><?= $user['lex_email'] ?></b></label>
                                                <br>
                                                <small>This is the email that you will share with your suppliers in order to get invoices directly to your LexOffice dashboard.</small>
                                                <?php $id = $_SESSION['userId']; ?>
                                                <input type="hidden" name="userid" value="<?= $id ?>">
                                          </div>
                                          <div class="text-center mt-3">
                                                <button type="submit" class="btn btn-lg btn-primary">Submit</button>
                                          </div>
                                    </form>
                              </div>
                        </div>
                  </div>

            </div>
      </div>
</div>
<?php unset($_SESSION['lex_error']); ?>