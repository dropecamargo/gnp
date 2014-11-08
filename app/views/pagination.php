<?php
    $presenter = new Illuminate\Pagination\BootstrapPresenter($paginator);
?>

<?php if ($paginator->getLastPage() > 1): ?>
    <ul class="pagination" style="margin: 0px;">
        <?php echo $presenter->render(); ?>
    </ul>
<?php endif; ?>	