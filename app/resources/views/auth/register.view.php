<?php

require_once LAYOUTS . 'main_head.php';
setHeader($d);

?>

<div class="container">
    <div class="card mt-5 w-50 mx-auto">
        <div class="card-body">
            <h5 class="card-title">Registro</h5>
            <hr>
            <form action="" id="register-form">
                <div class="form-group input-group">
                    <label for="name" class="input-group-text">
                        <i class="bi bi-person"></i>
                    </label>
                    <input type="text" name="name" id="name" class="form-control" required>
                </div>
                <div class="form-group input-group">
                    <label for="email" class="input-group-text">
                        <i class="bi bi-person"></i>
                    </label>
                    <input type="email" name="email" id="email" class="form-control" required>
                </div>
                <div class="form-group input-group mt-3">
                    <label for="passwd" class="input-group-text">
                        <i class="bi bi-key"></i>
                    </label>
                    <input type="password" name="passwd" id="passwd" class="form-control" required>
                </div>
                <div class="form-group input-group mt-3">
                    <label for="passwd2" class="input-group-text">
                        <i class="bi bi-key"></i>
                    </label>
                    <input type="password" name="passwd2" id="passwd2" class="form-control" required>
                </div>
                <div class="d-grid gap-2 my-2">
                    <small class="form-text text-danger d-none" id="error">
                        No se pudo registrar
                    </small>
                    <button class="btn btn-primary mt-3" type="submit">
                        Registrarme <i class="bi bi-arrow-right-circle"></i>
                    </button>
                    <a href="/Session/iniSession" class="btn btn-link-float-end">Login</a>
                </div>
            </form>
        </div>
    </div>
</div>

<?php

require_once LAYOUTS . 'main_foot.php';
setFooter($d);

?>

<script src=""></script>

<script>
    $(function() {
        const rf = $("#register-form")
        rf.on("submit", function(e) {
            e.preventDefault()
            e.stopPropagation()
            let p1 = $("#passwd")
            let p2 = $("#passwd2")
            if (p1.val() !== p2.val()) {
                Swal.fire({
                    icon: "error",
                    text: "Password dont match",
                }).then(() => {
                    p2.val("")
                    p2.trigger("focus")
                })
            } else {
                const data = new FormData(this)
                fetch(app.routes.register, {
                    method: "POST",
                    body: data
                }).then(res => res.json())
                .then(res => {
                    if (res.r !== false) {
                        location.href = app.routes.inisession
                    } else {
                        $("#error").removeClass("d-none")
                    }
                }).catch( err => {$("#error").removeClass("d-none")})
            }

        })
    })
</script>
