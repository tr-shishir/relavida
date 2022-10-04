<div class="sidebar__widget custom-sidebar-style sidebar-2">
    <h6 class=""><?php _lang("Wunschzettel"); ?></h6>
    <hr>
    <div class="sidebar-box">
        <ul class="mw-cats-menu" id="wishlist-list">

        </ul>
    </div>

    <?php if (is_logged()) { ?>
        <div id="wishlist-sidebar"></div>
        <p>&nbsp;</p>
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter">
            Erstellen Sie eine neue Wunschliste
        </button>
    <?php } else { ?>
        <button data-toggle="modal" class="btn btn-default login-modal" data-target="#loginModal">Melden Sie sich an, um eine Wunschliste hinzuzufügen</button>
    <?php } ?>
</div>


<div class="modal addWishlist" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <form>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Titel der Wunschliste</label>
                        <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp"
                               placeholder="Enter wishlist title">
                        <small id="emailHelp" class="form-text text-muted red" style="display: none;">We'll never share
                            your email with anyone else.</small>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary newWishlist">Schließen</button>
                <button type="button" class="btn btn-primary" onclick="create_sessions()">Änderungen speichern</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal edittWishlist" id="exampleModalCenteredit" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <form>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Titel der Wunschliste</label>
                        <input type="text" class="form-control" id="exampleInputEmailedit" aria-describedby="emailHelp"
                               placeholder="Enter wishlist title">
                        <input type="hidden" class="form-control" id="exampleInputEmailedithide" aria-describedby="emailHelp"
                               placeholder="Enter wishlist title">
                        <small id="emailHelp" class="form-text text-muted red" style="display: none;">We'll never share
                            your email with anyone else.</small>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary editWishlist">Schließen</button>
                <button type="button" class="btn btn-primary" onclick="edit_sessions()">Änderungen speichern</button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    function create_sessions() {
        let title = $('#exampleInputEmail1').val();
        const emailHelp = $('#emailHelp');
        emailHelp.hide();
        if (title.trim().length > 0) {
            $.post("<?php print api_url('set_wishlist_sessions'); ?>", {title: title}, function (sessions) {
                if (sessions === 'false') {
                    emailHelp.show();
                } else {
                    location.reload();
                }
            });
        } else {
            emailHelp.show();
        }
    }

    function edit_sessions() {
        let title = $('#exampleInputEmailedit').val();
        let titlehide = $('#exampleInputEmailedithide').val();
        const emailHelp = $('#emailHelp');
        emailHelp.hide();
        if (title.trim().length > 0) {
            $.post("<?php print api_url('edit_wishlist_sessions'); ?>", {title: title, titlehide: titlehide}, function (sessions) {
                if (sessions === 'false') {
                    emailHelp.show();
                } else {
                    location.reload();
                }
            });
        } else {
            emailHelp.show();
        }
    }
</script>

<script>
    jQuery('.newWishlist').on("click", function (e) {
        jQuery('.addWishlist').modal('hide');
    });
    jQuery('.editWishlist').on("click", function (e) {
        jQuery('.edittWishlist').modal('hide');
    });
</script>