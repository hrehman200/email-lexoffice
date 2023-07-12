<div class="row">
      <div class="col-sm-10 col-md-8 col-lg-6 mx-auto d-table h-100 mob-screen">
            <div class="d-table-cell align-middle">

                  <div class="text-center mt-4">
                        <h1 class="h2">EMAIL INVOICE Registrieren</h1>
                        <p class="lead">
                              Buchhaltung wird jetzt noch einfacher
                        </p>
                        
                  </div>

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
                                    <style type="text/css">
                                          form p {
                                                color: red;
                                          }
                                    </style>
                                    <form method="post" action="<?= site_url('auth/create_user') ?>"
                                          class="signup-form">
                                          <div class="mb-3">
                                                <label class="form-label">Firma</label>
                                                <input class="form-control form-control-lg" type="text" name="company"
                                                      placeholder="Firma" value="<?php if ($_SESSION['error']) {
                                                            echo set_value('company');
                                                      } ?>" />
                                                <?php
                                                if ($_SESSION['error']) {
                                                      echo form_error('company');
                                                }
                                                ?>
                                          </div>
                                          <div class="mb-3">
                                                <label class="form-label">Vorname</label>
                                                <input class="form-control form-control-lg" type="text" name="name"
                                                      placeholder="Vorname" value="<?php if ($_SESSION['error']) {
                                                            echo set_value('name');
                                                      } ?>" />
                                                <?php
                                                if ($_SESSION['error']) {
                                                      echo form_error('name');
                                                }
                                                ?>
                                          </div>
                                          <div class="mb-3">
                                                <label class="form-label">Nachname</label>
                                                <input class="form-control form-control-lg" type="text" name="last_name"
                                                      placeholder="Nachname" value="<?php if ($_SESSION['error']) {
                                                            echo set_value('last_name');
                                                      } ?>" />
                                                <?php
                                                if ($_SESSION['error']) {
                                                      echo form_error('last_name');
                                                }
                                                ?>
                                          </div>
                                          <div class="mb-3">
                                                <label class="form-label">Adresse</label>
                                                <input class="form-control form-control-lg" type="text" name="address"
                                                      placeholder="Adresse" value="<?php if ($_SESSION['error']) {
                                                            echo set_value('address');
                                                      } ?>" />
                                                <?php
                                                if ($_SESSION['error']) {
                                                      echo form_error('address');
                                                }
                                                ?>
                                          </div>
                                          <div class="mb-3">
                                                <label class="form-label">Ort</label>
                                                <input class="form-control form-control-lg" type="text" name="city"
                                                      placeholder="Ort" value="<?php if ($_SESSION['error']) {
                                                            echo set_value('city');
                                                      } ?>" />
                                                <?php
                                                if ($_SESSION['error']) {
                                                      echo form_error('city');
                                                }
                                                ?>
                                          </div>
                                          <div class="mb-3">
                                                <label class="form-label">PLZ</label>
                                                <input class="form-control form-control-lg" type="text" name="zip"
                                                      placeholder="PLZ" value="<?php if ($_SESSION['error']) {
                                                            echo set_value('zip');
                                                      } ?>" />
                                                <?php
                                                if ($_SESSION['error']) {
                                                      echo form_error('zip');
                                                }
                                                ?>
                                          </div>
                                          <div class="mb-3">
                                                <label class="form-label">Land</label>
                                                <input class="form-control form-control-lg" type="text" name="country"
                                                      placeholder="Land" value="<?php if ($_SESSION['error']) {
                                                            echo set_value('country');
                                                      } ?>" />
                                                <?php
                                                if ($_SESSION['error']) {
                                                      echo form_error('country');
                                                }
                                                ?>
                                          </div>

                                          <div class="mb-3">
                                                <label class="form-label">Ihre Emaildresse</label>
                                                <input class="form-control form-control-lg" type="email" name="email"
                                                      placeholder="Ihre Emaildresse" value="<?php if ($_SESSION['error']) {
                                                            echo set_value('email');
                                                      } ?>" />

                                                <?php
                                                if ($_SESSION['error']) {
                                                      echo form_error('email');
                                                }
                                                ?>
                                          </div>
                                          <div class="mb-3">
                                                <label class="form-label">Passwort</label>
                                                <input class="form-control form-control-lg" type="password"
                                                      name="password" placeholder="Passwort" value="<?php if ($_SESSION['error']) {
                                                            echo set_value('password');
                                                      } ?>" />
                                                <?php
                                                if ($_SESSION['error']) {
                                                      echo form_error('password');
                                                }
                                                ?>

                                          </div>
                                          <div class="mb-3">
                                                <label class="form-label">Password Bestätigung</label>
                                                <input class="form-control form-control-lg" type="password"
                                                      name="password_confirm" placeholder="Password Bestätigung" value="<?php if ($_SESSION['error']) {
                                                            echo set_value('password_confirm');
                                                      } ?>" />
                                                <?php
                                                if ($_SESSION['error']) {
                                                      echo form_error('password_confirm');
                                                }
                                                ?>

                                          </div>

                                          <div class="form-check mt-3">
                                                <input class="form-check-input" type="checkbox" value="1" name="trader"
                                                      id="flexCheckDefault">
                                                <label class="form-check-label" for="flexCheckDefault">
                                                      Ich akzeptiere den Vertrag zur <a href="https://www.75marketing.net/auftragsdatenverarbeitung/" target="_blank">Auftragsdatenverarbeitung</a> und habe die <a href="https://www.75marketing.net/agb/" target="_blank">AGB</a> und <a href="/datenschutz/" target="_blank">Datenschutzerklärung</a> gelesen und stimme zu.
                                                      
                                                </label>
                                                <?php
                                                if ($_SESSION['error']) {
                                                      echo form_error('trader');
                                                }
                                                ?>
                                          </div>

                                          <div>
                                                <label class="form-check form-check-inline mt-3">
                                                <input class="form-check-input" type="radio" name="timing"
                                                            value="1" checked >
                                                      <span class="form-check-label">
                                                              <b>KOSTENLOS:</b> in der Beta Testphase<br>
                                                            Vor dem Ende der Beta Testphase werden Sie rechtzeitig informiert und haben dann die Wahl ein kostenpflichtiges Abo für EMAIL INVOICE abzuschließen oder die Nutzung von EMAIL INVOICE zu beenden.
                                                      </span>
                                                </label>
                                            
                                            
                                                <label class="form-check form-check-inline mt-3">
                                                      <input class="form-check-input" type="radio" name="timing"
                                                            value="2" >
                                                      <span class="form-check-label">
                                                              <b>Monatstarif</b>: 8 EURO / Monat zzgl. MwSt<br>
                                                            Vertragslaufzeit 1 Monat: sollte der Vertrag bis 4 Wochen vor Ablauf der Vertragslaufzeit nicht gekündigt sein, verlängert sich der Vertrag automatisch um 1 Monat.
                                                      </span>
                                                </label>
                                                <br>
                                                <br>
                                                
                                                <label class="form-check form-check-inline">
                                                      <input class="form-check-input" type="radio" name="timing"
                                                            value="3">
                                                      <span class="form-check-label">
                                                              <b>Jahrestarif</b>: 90 EURO / Jahr zzgl. MwSt<br>
                                                            Vertragslaufzeit 1 Jahr: sollte der Vertrag bis 4 Wochen vor Ablauf der Vertragslaufzeit nicht gekündigt sein, verlängert sich der Vertrag automatisch um 12 Monate.
                                                      </span>
                                                </label>
                                          </div>

                                          <div class="text-center mt-3">
                                                <button type="submit" class="btn btn-lg btn-color">Anmelden</button>
                                          </div>
                                    </form>
                              </div>
                        </div>
                  </div>

            </div>
      </div>
</div>
<?php unset($_SESSION['error']); ?>