<?php function setFooter($args, ...$scripts)
{
    $ua = as_object($args->ua);
    // $ua = as_object([]);
?>

    <script src="/assets/js/jquery.min.js"></script>
    <script src="/assets/js/bootstrap.bundle.min.js"></script>
    <script src="/assets/js/sweetalert2.min.js"></script>
    <script src="/assets/js/app.js"></script>
    <?php foreach ($scripts as $script) { ?>
        <script src="/assets/js/<?= $script ?>"></script>
    <?php } ?>
    <script>
        $(function() {
            app.user.sv = <?= $ua->sv ? 'true' : 'false' ?>;
            app.user.id = <?= $ua->id ?? '""' ?>;
            app.user.name = "<?= $ua->name ?? '' ?>";
            app.user.tipo = "<?= $ua->tipo ?? '' ?>";
        });
    </script>

<?php }
function closeFooter()
{ ?>

    </body>

    </html>

<?php }
