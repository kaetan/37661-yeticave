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
    <section class="rates container">
        <h2>Мои ставки</h2>
        <table class="rates__list">
            <?php foreach($bets as $bet): ;?>
            <?php
                $time_left = strtotime($bet['lot_finish']) - strtotime('now');

                if ($bet['winner'] === $user_id) {
                    $classname = "rates__item--win";
                }
                elseif ($time_left <= 0) {
                    $classname = "rates__item--end";
                }
                else {
                    $classname = '';
                }
            ?>
            <tr class="rates__item <?=$classname;?>">
                <td class="rates__info">
                    <div class="rates__img">
                        <img src="<?=$bet['picture']; ?>" width="54" height="40" alt="<?=$bet['title']; ?>">
                    </div>
                    <div>
                        <h3 class="rates__title"><a href="lot.php?id=<?=$bet['id']; ?>"><?=htmlspecialchars($bet['title']); ?></a></h3>
                        <?php if($classname === "rates__item--win") { ?>
                        <p><?=$bet['contacts']; ?></p>
                        <?php ;} ?>
                    </div>
                </td>
                <td class="rates__category">
                    <?=$bet['category']; ?>
                </td>
                <td class="rates__timer">

                    <? if ($time_left < 3600 && $time_left > 0) { ?>
                    <div class="timer timer--finishing"><?=lot_timer($bet['lot_finish'])?></div>

                    <? ;} elseif (strtotime($bet['lot_finish']) - strtotime('now') <= 0 && $classname !== "rates__item--win") { ?>
                    <div class="timer timer--end">Торги окончены</div>

                    <? } elseif ($classname === "rates__item--win") { ?>
                    <div class="timer timer--win">Ставка выиграла</div>

                    <? ;} else { ?>
                    <div class="timer"><?=lot_timer($bet['lot_finish'])?></div>
                    <? ;} ?>

                </td>
                <td class="rates__price">
                    <?=htmlspecialchars(format_cost($bet['bet'], 0)); ?> р
                </td>
                <td class="rates__time">
                    <?=human_date($bet['bet_date']);?>
                </td>
            </tr>
            <? endforeach ?>
        </table>
    </section>
</main>