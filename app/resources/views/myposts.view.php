<?php

include_once LAYOUTS . 'main_head.php';

setHeader($d);
//$ua = as_object($_SESSION);
?>

<div class="mx-auto w-75">
    <h1 class="text-center">
        Mis Publicaciones
    </h1>
    <div class="row">
        <div class="col-10">
            <div class="input-group">
                <input type="text" class="form-control" id="text-filter" placeholder="Buscar Publicaciones">
                <div class="input-group-append">
                    <button class="btn btn-secondary" type="button" id="button-filter">
                        <i class="bi bi-search"></i>
                    </button>
                </div>
            </div>
        </div>
        <div class="col-2">
            <a href="userposts/newpost" class="btn btn-primary w-100" id="new-post">
                <i class="bi bi-plus"></i> Nueva Publicación
            </a>
        </div>
    </div>
    <table class="table table-striped mt-3">
        <thead>
            <tr>
                <th>Date</th>
                <th>Title</th>
                <th><i class="bi-gear"></i></th>
            </tr>
        </thead>
        <tbody id="tbl-mis-publicaciones">
        </tbody>
    </table>
</div>


<?php
include_once LAYOUTS . 'main_foot.php';
setFooter($d, 'app_myposts.js');
?>

<script>
    $(function() {
        app_myposts.loadMyPosts();
    });
</script>

<?php
closeFooter();
