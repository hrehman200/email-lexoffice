<div class="row">
      <div class="col-sm-10 col-md-8 col-lg-6 mx-auto d-table h-100">
            <div class="d-table-cell align-middle">

                  <div class="text-center mt-4">
                        <h1 class="h2">Signin</h1>
                        <p class="lead">
                              Signin by entering your information.
                        </p>
                  </div>
                  
                        <?php 
                              if (isset($_SESSIOn['activation_pending'])) {
                                    ?>    
                                    <p class="alert text-warning my-2"><?php 
                                          echo $_SESSIOn['activation_pending'];
                                    ?></p>
                                    <?php
                                    unset($_SESSIOn['activation_pending']);
                              }
                              if (isset($_SESSIOn['activation_success'])) {
                                    ?>    
                                    <p class="alert text-success my-2"><?php 
                                          echo $_SESSIOn['activation_success'];
                                    ?></p>
                                    <?php
                                    unset($_SESSIOn['activation_success']);
                              }
                              if (isset($_SESSIOn['no_record_found'])) {
                                    ?>    
                                    <p class="alert text-danger my-2"><?php 
                                          echo $_SESSIOn['no_record_found'];
                                    ?></p>
                                    <?php
                                    unset($_SESSIOn['no_record_found']);
                              }
                              if (isset($_SESSIOn['account_not_active'])) {
                                    ?>    
                                    <p class="alert text-danger my-2"><?php 
                                          echo $_SESSIOn['account_not_active'];
                                    ?></p>
                                    <?php
                                    unset($_SESSIOn['account_not_active']);
                              }
                         ?>
                  
                  <div class="card">
                        <div class="card-body">
                              <div class="m-sm-4">

                                    <?php if(strlen($message)) { ?>
                                          <div class="alert alert-danger"><div class="alert-message"><?=$message?></div></div>
                                    <?php } ?>

                                    <form method="post" action="<?= site_url('auth/sigin') ?>">
                                          
                                          <div class="mb-3">
                                                <label class="form-label">Email</label>
                                                <input class="form-control form-control-lg" type="email" name="email" placeholder="Enter your email" value="<?php if($_SESSION['login_error']){echo set_value('email');} ?>" />
                                                <?php 
                                                      if($_SESSION['login_error']){
                                                            echo form_error('email');
                                                      }
                                                 ?>

                                          </div>
                                          <div class="mb-3">
                                                <label class="form-label">Password</label>
                                                <input class="form-control form-control-lg" type="password" name="password" placeholder="Enter password" value="<?php if($_SESSION['login_error']){echo set_value('password');} ?>" />
                                                <?php 
                                                      if($_SESSION['login_error']){
                                                            echo form_error('password');
                                                      }
                                                 ?>
                                                
                                          </div>
                                          <div class="text-center mt-3">
                                                <button type="submit" class="btn btn-lg btn-primary">Sign in</button>
                                          </div>
                                    </form>
                              </div>
                        </div>
                  </div>

            </div>
      </div>
</div>
<?php unset($_SESSION['login_error']); ?>