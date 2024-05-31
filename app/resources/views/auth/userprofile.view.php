<?php

require_once LAYOUTS . 'main_head.php';
setHeader($d);
$ua = $d->ua;
?>


<div class="container pb-6 pt-6">
    <div class="text-content">
        <h2 class="title has-text-centered"></h2>

        <form class="" id="userForm">
            <div class="">
                <label>Username</label>
                <input class="form-control" type="text" name="name" value="<?= $ua->name ?>" required>
            </div>
            <div class="">
                <label>Email</label>
                <input class="form-control" type="email" name="email" value="<?= $ua->email ?>" required>
            </div>
            <div class="">
                <label>Password</label>
                <input class="form-control" type="password" name="passwd">
            </div>

            <div class="">
                <label>Current Password</label>
                <input class="form-control" type="password" name="old_passwd" required>
            </div>

            <small class="form-text text-danger d-none" id="error">
                Error al actualizar perfil
            </small>
            <div class="">
                <button type="submit" class="button is-info is-rounded">Update</button>
                <button type="reset" class="button is-cancel is-rounded">Cancel</button>
            </div>

        </form>
    </div>
</div>
<?php

require_once LAYOUTS . 'main_foot.php';
setFooter($d, "userprofile.js");

?>
<script>
    $(function() {
        userprofile.updateUser();
    })
</script>
<?php
closeFooter();
?>