<?php

require_once LAYOUTS . 'main_head.php';
setHeader($d);
?>


<div class="mx-auto w-75 mt-5 shadow p-3 bg-body-tertiary rounded">
<h1 class="text-center">Nueva Publicación</h1>
<form action="/Userposts/saveNewPost" method="POST">
    <div class="form-group mb-3">
        <label for="title"></label>
        <input type="text" class="form-control" id="title" name="title">
    </div>
    <div class="form-group mb-3">
        <label for="texto">texto</label>
        <textarea class="form-control" cols="30" rows="10" name="body" id="body"></textarea>
    </div>
    <div class="mt-2 text-end">
        <button type="submit" class="btn btn-primary">Guardar</button>
        <a href="/userposts" class="btn btn-secondary float-end">Cancelar</a>
    </div>
</form>
</div>



<?php
include_once LAYOUTS . 'main_foot.php';
setFooter($d, 'app_myposts.js');
?>

<?php
closeFooter();
