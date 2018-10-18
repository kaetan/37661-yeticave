<?php if ($pages_count > 1): ?>
<ul class="pagination-list">
    <li class="pagination-item pagination-item-prev"><a href="<?=$page_link;?>page=<?=$current_page > 1 ? $current_page - 1 : 1; ?>">Назад</a></li>

    <?php foreach ($pages as $page): ?>
    <li class="pagination-item <?php if ($page == $current_page): ?>pagination-item-active<?php endif; ?>">
        <a href="<?=$page_link;?>page=<?=$page;?>"><?=$page;?></a>
    </li>
    <?php endforeach; ?>

    <li class="pagination-item pagination-item-next"><a href="<?=$page_link;?>page=<?=$current_page < $pages_count ? $current_page + 1 : $pages_count; ?>">Вперед</a></li>
</ul>
<?php endif; ?>