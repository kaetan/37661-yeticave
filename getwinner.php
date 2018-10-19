<?php
// Выбор завершившихся лотов без победителя, а также юзеров, сделавших победившую ставку
$sql = "SELECT l.id AS lot_id, l.title, b.id AS bet_id, b.owner, u.username, u.email
        FROM lots l 
        LEFT JOIN bets b ON b.lot = l.id AND b.bet = l.current_price
        LEFT JOIN users u ON u.id = b.owner
        WHERE l.winner IS NULL 
        AND l.datetime_finish <= UTC_TIMESTAMP";
if ($result = mysqli_query($link, $sql)) {
    $lots_winners = mysqli_fetch_all($result, MYSQLI_ASSOC);
} else {
    print(db_error($link));
    exit();
}

// Вносим id победителей в таблицу лотов
foreach ($lots_winners as $key) {
    $qq_win = $key['owner'];
    $qq_id = $key['lot_id'];

    $update_winners = "UPDATE lots SET winner = $qq_win WHERE id = $qq_id";
    $go = mysqli_prepare($link, $update_winners);
    mysqli_stmt_execute($go);

    // Вызываем функцию рассылки писем победителям
    mail_winner($key['email'], $key['username'], $key['lot_id'], $key['title']);
}

