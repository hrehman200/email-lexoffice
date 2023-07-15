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
                                                <label class="form-label">Bitte geben Sie hier Ihren persönlichen lexoffice Public API Schlüssel ein.</label>
                                                <input class="form-control form-control-lg" type="text" name="lexapikey" placeholder="Ihr persönlicher lexoffice Public API Schlüssel" value="<?= $user['lex_api_key'] ?>" />
                                                <?php
                                                if ($_SESSION['lex_error']) {
                                                      echo form_error('lexapikey');
                                                }
                                                ?>

                                          </div>
                                          <div class="mb-3 <?= !$user['lex_api_key'] ? 'd-none' : ''?>">
                                                <label class="form-label">Ihre EMAIL INVOICE-Adresse lautet: </label>
                                                <br>
                                                <label><b><?= $user['lex_email'] ?></b></label>
                                                <br>
                                                <small>Diese EMAIL INVOICE Adresse geben Sie als Adresse für Rechnungen an alle Ihre Geschäftspartner weiter, die Ihnen Rechnungen stellen (Lieferanten, Dienstleister etc.). An diese Adresse gerichtete Rechnungen werden automatisch in Ihrem lexoffice-Account hinterlegt.</small>
                                                <?php $id = $_SESSION['userId']; ?>
                                                <input type="hidden" name="userid" value="<?= $id ?>">
                                          </div>
                                          <div class="text-center mt-3">
                                                <button type="submit" class="btn btn-lg btn-primary">Änderung speichern</button>      
                                          </div>
                                          
						<br>
						<div class="alert alert-success" style="background-color: #fffcc8;">Wo finde ich meinen lexoffice Public API Schl&uuml;ssel?<br />Hier k&ouml;nnen Sie Ihren eignen lexoffice Public API Schl&uuml;ssel erstellen:<br /><a title="https://app.lexoffice.de/addons/public-api" href="https://app.lexoffice.de/addons/public-api" target="_blank">https://app.lexoffice.de/addons/public-api</a>.
						</div>
                                          
                                          
                                          
                                    </form>

                                    <hr class="mt-5 mb-5" />


                                    <form method="post" action="<?= site_url('update/second_email') ?>">
                                          <?php if (strlen($_SESSION['msg'])) { ?>
                                                <div class="alert alert-<?=$_SESSION['msg_type']?>">
                                                      <div class="alert-message"><?= $_SESSION['msg'] ?></div>
                                                </div>
                                          <?php } ?>
                                          <div class="mb-3">
                                                <label class="form-label">
                                                Wenn Sie Ihre Rechnungen über eine eigene Mailadresse empfangen möchten (z.B. invoice@ihrefirma.de oder rechnung@ihrefirma.de) und diese dann serverseitig (nicht per Outlook) an Ihre von uns zugeteilte EMAIL INVOICE-Adresse (siehe oben) weiterleiten, müssen Sie hier die Mailadresse angeben, an die Sie sich Rechnungen von Ihren Rechnungsstellern schicken lassen, damit das System diese korrekt zuordnen kann.
                                                </label>
                                                <input class="form-control form-control-lg" type="text" name="second_email" placeholder="invoice@ihrefirma.de" value="<?= $user['second_email'] ?>" />
                                          </div>
                                          <div class="text-center mt-3">
                                                <button type="submit" class="btn btn-lg btn-primary">Speichern</button>      
                                          </div>
                                    </form>

                              </div>
                        </div>
                  </div>

            </div>
      </div>
</div>
<?php unset($_SESSION['lex_error']); ?>