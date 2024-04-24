<?php

require_once LAYOUTS . 'main_head.php';
setHeader($d);

?>

<div class="container">
    <div class="card mt-5 w-50 mx-auto">
        <div class="card-body">
            <h5 class="card-title">Inicio de sesión</h5>
            <hr>
            <form action="" id="login-form">
                <div class="form-group input-group">
                    <label for="username" class="input-group-text">
                        <i class="bi bi-person"></i>
                    </label>
                    <input type="text" name="username" id="username" class="form-control" required>
                </div>
                <div class="form-group input-group mt-3">
                    <label for="passwd" class="input-group-text">
                        <i class="bi bi-key"></i>
                    </label>
                    <input type="password" name="passwd" id="passwd" class="form-control" required>
                </div>
                <div class="d-grid gap-2 my-2">
                    <small class="form-text text-danger d-none" id="error">
                        Sus credenciales son incorrectas
                    </small>
                    <hr>
                    <button class="btn btn-primary mt-3" type="submit">
                        Iniciar Sesión <i class="bi bi-arrow-right-circle"></i>
                    </button>
                    <a href="/Register" class="btn btn-link-float-end">Regístrate</a>
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