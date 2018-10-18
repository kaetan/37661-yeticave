<main>
    <nav class="nav">
        <ul class="nav__list container">
            <? foreach ($categories as $val): ?>
                <li class="nav__item">
                    <a href="all_lots.php?cat=<?=$val['id']; ?>"><?=$val['title']?></a>
                </li>
            <? endforeach ?>
        </ul>
    </nav>
    <div class="container">
        <section class="lots">
            <?php if (!$not_found) { ?>
                <h2>Результаты поиска по запросу «<span><?=htmlspecialchars($search_unsafe); ?></span>»</h2>
            <?php ;} else { ?>
                <h2>Ничего не найдено по вашему запросу</h2>
            <?php ;} ?>
            <ul class="lots__list">
                <?php foreach ($lots as $lot): ?>
                    <li class="lots__item lot">
                        <div class="lot__image">
                            <img src="<?=$lot['picture']; ?>" width="350" height="260" alt="<?=htmlspecialchars($lot['title']); ?>">
                        </div>
                        <div class="lot__info">
                            <span class="lot__category"><?=$lot['category']; ?></span>
                            <h3 class="lot__title"><a class="text-link" href="lot.php?id=<?=$lot['id']; ?>"><?=htmlspecialchars($lot['title']); ?></a></h3>
                            <div class="lot__state">
                                <div class="lot__rate">
                                    <span class="lot__amount">Стартовая цена</span>
                                    <span class="lot__cost">
                                    <?php print(format_cost(htmlspecialchars($lot['starting_price']), 1)); ?>
                                    </span>
                                </div>
                                <div class="lot__timer timer">
                                    <?php print lot_timer($lot['datetime_finish'])?>
                                </div>
                            </div>
                        </div>
                    </li>
                <? endforeach ?>
            </ul>
        </section>
        <?=$pagination;?>
    </div>
</main>