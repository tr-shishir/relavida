<?php

/*

type: layout
name: Benifits
position: 21
*/


?>


<section class="benefits-wrapper section-padding edit" field="layout-benifits<?php print $params['id'] ?>" 
            rel="module">
            <div class="container">
                <!-- <div class="section-head">
                    <h3>IHRE VORTEILE AUF EINEN BLICK</h3>
                </div> -->
                <module type="layouts" template="section-heading/index"/>

                <div class="row mt-5">
                    <!-- Card item -->
                    <div class="col-lg-4 col-md-6">
                        <div class="benefit-card">
                            <span class="card-icon">
                            <img src="<?php print template_url(); ?>/assets/images/icons/benefit-icon1.png" alt="" />
                            </span>
                            <h4 class="card-title text-uppercase">PERSÖNLICHE BERATUNG</h4>
                            <p class="card-desc">
                                Als kleines Unternehmen steht bei uns die persönliche Beratung an
                                erster Stelle. Unser höchstes Ziel ist Ihre Zufriedenheit – vor,
                                während und nach dem Kauf, überzeugen Sie sich selbst.
                            </p>
                        </div>
                    </div>
                    <!-- Card item -->
                    <div class="col-lg-4 col-md-6">
                        <div class="benefit-card">
                            <span class="card-icon">
                            <img src="<?php print template_url(); ?>/assets/images/icons/benefit-icon2.png" alt="" />
                            </span>
                            <h4 class="card-title text-uppercase">INDIVIDUELLE LÖSUNGEN</h4>
                            <p class="card-desc">
                                Sie suchen eine individuelle Lösung für Ihr Anliegen oder finden
                                nicht das richtige Produkt? Wir helfen Ihnen gerne bereits bei der
                                Ermittlung Ihrer Bedürfnisse – kontaktieren Sie uns!
                            </p>
                        </div>
                    </div>
                    <!-- Card item -->
                    <div class="col-lg-4 col-md-6">
                        <div class="benefit-card">
                            <span class="card-icon">
                            <img src="<?php print template_url(); ?>/assets/images/icons/benefit-icon3.png" alt="" />
                            </span>
                            <h4 class="card-title text-uppercase">QUALITÄTSVERSPRECHEN</h4>
                            <p class="card-desc">
                                Wir setzen uns für Sie ein und prüfen die Qualität der bei uns im
                                Sortiment erhältlichen Produkte besonders genau, um Ihnen immer ein
                                gutes Einkaufserlebnis bieten zu können.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>