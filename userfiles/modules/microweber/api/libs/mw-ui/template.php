<?php include('partials/header.php'); ?>

    <div class="tree">
        DURVO
    </div>

    <script>
        $(document).ready(function () {
//        $('body > .main').addClass('show-sidebar-tree');
        });
    </script>

    <main>
        <div class="main-toolbar">
            <a href="#" class="btn btn-link text-silver px-0"><i class="mdi mdi-chevron-left"></i> Settings</a>
        </div>

        <div class="card bg-none style-1 mb-0">
            <div class="card-header px-0">
                <h5><i class="mdi mdi-shield-edit-outline text-primary mr-3"></i> <strong>Templates</strong></h5>
                <div>

                </div>
            </div>

            <div class="card-body pt-3 px-0">
                <div class="row">
                    <div class="col-md-4 mt-3">
                        <h5 class="font-weight-bold">Settings</h5>
                        <small class="text-muted d-block mb-3">Choose a new template or browse the pages of the current one.</small>

                        <br/>
                        <label class="control-label">Want to upload template?</label>
                        <small class="text-muted d-block mb-3">Choose a new template or browse the pages of the current one.</small>

                        <button class="btn btn-outline-primary mb-3">Upload new template</button>
                        <button class="btn btn-primary mb-3">Apply this template</button>
                    </div>

                    <div class="col-md-8">
                        <div class="card bg-light style-1 mb-3">
                            <div class="card-body pt-4 pb-5">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group mb-3">
                                            <label class="control-label">Template name</label>
                                            <small class="text-muted d-block mb-2">You are using this template. The change will be affected only on the current page.</small>
                                            <div>
                                                <select class="selectpicker" data-width="100%">
                                                    <option>New world</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group mb-3">
                                            <label class="control-label">Choose Page Layout</label>
                                            <small class="text-muted d-block mb-2">Select a page from the current template</small>
                                            <div>
                                                <select class="selectpicker" data-width="100%">
                                                    <option>Home</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card bg-none style-1 mb-0">
            <div class="card-body pt-3 px-0">
                <hr class="thin mt-0 mb-4"/>

                <div class="row">
                    <div class="col-md-12">
                        <h5 class="font-weight-bold">Template preview</h5>
                        <small class="text-muted">Use the fields at the top to see the changes.</small>
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col-md-12">
                        <iframe src="http://droptienda.com" style="width: 100%; height: 50vh;" frameborder="0"></iframe>
                    </div>
                </div>
            </div>
        </div>

        <div class="row copyright mt-3">
            <div class="col-12">
                <p class="text-muted text-center small">Open-source website builder and CMS Droptienda. Version: <?php print(Config::get('app.adminTemplateVersion')); ?></p>
            </div>
        </div>
    </main>


<?php include('partials/footer.php'); ?>
