<main class="container">
    <section class="promo">
        <h2 class="promo__title">Нужен стафф для катки?</h2>
        <p class="promo__text">На нашем интернет-аукционе ты найдёшь самое эксклюзивное сноубордическое и горнолыжное снаряжение.</p>
        <ul class="promo__list">
            <!--заполните этот список из массива категорий-->
            <?php foreach ($categories as $val): ?>
                <li class="promo__item promo__item--boards">
                    <a class="promo__link" href="all_lots.php?cat=<?=$val['id']; ?>"><?=$val['title']; ?></a>
                </li>
            <? endforeach ?>
        </ul>
    </section>
    <section class="lots">
        <div class="lots__header">
            <h2>Открытые лоты</h2>
        </div>
        <?=include_template('_grid.php', ['lots' => $lots]); ?>
    </section>
</main>