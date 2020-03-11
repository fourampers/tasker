<nav aria-label="Page navigation">
    <ul class="pagination justify-content-center">
        <li class="page-item <?php if(!$paginator->getPrevUrl()):?> disabled <?php endif;?>">
            <a class="page-link" href="<?=$paginator->getPrevUrl()?>" 
                <?php if(!$paginator->getPrevUrl()):?> disabled <?php endif;?>
            >Предыдущая</a>
        </li>

        <?php foreach ($paginator->getPages() as $page): ?>
        <?php if ($page['url']): ?>
            <li class="page-item  <?php echo $page['isCurrent'] ? 'active' : ''; ?>">
                <a class="page-link" href="<?php echo $page['url']; ?>"><?php echo $page['num']; ?></a>
            </li>
        <?php else: ?>
            <li class="page-link"><span><?php echo $page['num']; ?></span></li>
        <?php endif; ?>
        <?php endforeach; ?>

        <li class="page-item <?php if(!$paginator->getNextUrl()):?> disabled <?php endif;?>">
            <a class="page-link" href="<?=$paginator->getNextUrl()?>" 
                <?php if(!$paginator->getNextUrl()):?> disabled <?php endif;?>
            >Следующая</a>
        </li>
    </ul>
</nav>