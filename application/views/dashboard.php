<div class="row">
      <div class="col-sm-10 col-md-8 col-lg-6 mx-auto d-table h-100">
            <div class="d-table-cell align-middle">
                  
                  <div class="card">
                        <div class="card-body">
                              <div class="m-sm-4">

                                    <?php if(strlen($message)) { ?>
                                          <div class="alert alert-danger"><div class="alert-message"><?=$message?></div></div>
                                    <?php } ?>

                                    <form method="post" action="<?= site_url('lex/detail') ?>">
                                          
                                          <div class="mb-3">
                                                <label class="form-label">Lex Api Key</label>
                                                <input class="form-control form-control-lg" type="text" name="lexapikey" placeholder="Enter your lex api key" value="<?php if($_SESSION['lex_error']){echo set_value('lexapikey');} ?>" />
                                                <?php 
                                                      if($_SESSION['lex_error']){
                                                            echo form_error('lexapikey');
                                                      }
                                                 ?>

                                          </div>
                                          <div class="mb-3">
                                                <label class="form-label">Lex Email</label>
                                                <input class="form-control form-control-lg" type="email" name="lex_email" placeholder="Enter lex email" value="<?php if($_SESSION['lex_error']){echo set_value('lex_email');} ?>" />
                                                <?php 
                                                      if($_SESSION['lex_error']){
                                                            echo form_error('lex_email');
                                                      }
                                                 ?>
                                                 <?php $id = $_SESSION['userId']; ?>
                                                <input type="hidden" name="userid" value="<?=$id?>">
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