<?php

namespace Source\Models;

use Source\Core\Model;

/**
 * Description of Order
 *
 * @author Gustavo Pinheiro
 */
class Order extends Model {

    public function __construct() {
        parent::__construct('orders', ["id"], ["user", "book", "order_date", "return_date", "status"]);
    }

    /**
     * Responsile for preparing the object to be saved on database
     * @param int $user
     * @param int $book
     * @return \Source\Models\Order
     */
    public function bootstrap(User $user, Book $book, int $interval = 7): Order {
        $this->user = $user->id;
        $this->book = $book->id;
        $this->order_date = date("Y-m-d");
        $this->return_date = date('Y-m-d', strtotime($this->order_date . "+{$interval} days"));
        $this->fine = 0.00;
        $this->status = 'pending';
        return $this;
    }

    /**
     * Responsible for returning the book title.
     * @return string|null
     */
    public function findBookTitle(): ?string {
        $book = (new Book())->findById($this->book);
        if (!empty($book)) {
            return $book->title;
        }

        return null;
    }

    /**
     * Responsible for listing user orders
     * @param \Source\Models\User $user
     * @param string|null $status
     * @return \Source\Models\Order|null
     */
    public function listOrders(User $user, ?string $status = 'pending'): ?Order {
        if ($status) {
            $orders = $this->find("user = :user AND status = :status", "user={$user->id}&status={$status}");
        } else {
            $orders = $this->find("user = :user", "user={$user->id}");
        }

        return $orders;
    }

    /**
     * Responsible for providing the next return date
     * @param \Source\Models\User $user
     * @param string $status
     * @return string|null
     */
    public function nextReturn(User $user, string $status = 'pending'): ?string {
        $minDateArray = [];
        $dates = $this->find("user = :user AND status = :status ", "user={$user->id}&status={$status}", "return_date")->fetch(true);
        if ($dates) {
            foreach ($dates as $date) {
                $minDateArray[] = strtotime($date->data->return_date);
            }
            $minDate = min($minDateArray);
            return date('d/m/Y', $minDate);
        }
        
        return '_';
    }

    /**
     * Responsible for updating order fine, if necessary
     * @param \Source\Models\User $user
     * @param string|null $status
     * @param type $fine
     */
    public function calculateFine(User $user, ?string $status = 'pending', $fine = 2) {
        $pendingOrders = $this->find("user = :user AND status = :status", "user={$user->id}&status={$status}", "*")->fetch(true);
        if ($pendingOrders) {
            foreach ($pendingOrders as $order) {
                $return = strtotime($order->data->return_date);
                $now = strtotime('now');
                $diff = $now - $return;
                if ($diff > 0) {
                    $day = 24 * 60 * 60;
                    $numberDaysFault = floor($diff / $day);
                    $updatedFine = $numberDaysFault * $fine;
                    $order->data->fine = $updatedFine;
                    $order->save();
                }
            }
        }
    }

    /**
     * Responsible for summing fines for pending orders of a specific user
     * @param \Source\Models\User $user
     * @param string $status
     * @return \Source\Models\Order|null
     */
    public function sumFine(User $user, string $status = 'pending'): ?Order {
        $fines = $this->find("user = :user AND status = :status", "user={$user->id}&status={$status}", "SUM(fine) as fines");
        return $fines;
    }

}
