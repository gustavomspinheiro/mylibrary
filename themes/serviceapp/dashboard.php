<?php $this->layout("_theme", ["head" => $head]); ?>

<article class="main_dashboard">

    <div class="main_dashboard_area">
        <div class="main_dashboard_metric">
            <header class="main_dashboard_metric_header">
                <h2 class="icon-book-read-streamline">
                    Livros Alugados
                </h2>
            </header>

            <div class="main_dashboard_metric_content">
                <p><?= $totalOrders; ?></p>
            </div>
        </div>

        <div class="main_dashboard_metric">
            <header class="main_dashboard_metric_header">
                <h2 class="icon-alert">
                    Aluguéis em Aberto
                </h2>
            </header>

            <div class="main_dashboard_metric_content">
                <p><?= (!empty($ordersCount) ? $ordersCount : 0); ?></p>
            </div>
        </div>

        <div class="main_dashboard_metric">
            <header class="main_dashboard_metric_header">
                <h2 class="icon-calendar">
                    Próxima Devolução
                </h2>
            </header>

            <div class="main_dashboard_metric_content">
                <p style="color: <?= ($nextReturn < date('d/m/Y') ? "red" : "black"); ?>"><?= $nextReturn; ?></p>
            </div>
        </div>

        <div class="main_dashboard_metric">
            <header class="main_dashboard_metric_header">
                <h2 class="icon-money">
                    Multa em Aberto 
                </h2>
            </header>

            <div class="main_dashboard_metric_content">
                <p><?= str_price($pendingFines); ?></p>
            </div>
        </div>

    </div>

    <?php if (!empty($orders)): ?>
        <header class="list_books_header">
            <h3>Meus Aluguéis Pendentes de Devolução</h3>
        </header>
        <?php foreach ($orders as $order): ?>
            <article class="list_books">
                <div class="list_books_attribute">
                    <h4>Livro</h4>
                    <p><?= $order->findBookTitle(); ?></p>
                </div>
                <div class="list_books_attribute">
                    <h4>Aluguel</h4>
                    <p><?= date_fmt($order->order_date, "d/m/Y"); ?></p>
                </div>

                <div class="list_books_attribute">
                    <h4>Devolução</h4>
                    <p><?= date_fmt($order->return_date, "d/m/Y"); ?></p>
                </div>

                <div class="list_books_attribute">
                    <h4>Multa</h4>
                    <p><?= str_price($order->fine); ?></p>
                </div>

                <div class="list_books_attribute">
                    <h4>Status</h4>
                    <p><?= ($order->status == "pending" ? "Pendente" : "Devolvido"); ?></p>
                </div>

                <div class="list_books_button_return">
                    <form method="post" action="<?= url("/app/devolver/{$order->id}"); ?>">
                        <input class="return_book button button_info" type="submit" value="Devolver">
                    </form>
                </div>

            </article>


        <?php endforeach; ?>
    <?php endif; ?>

</article>

