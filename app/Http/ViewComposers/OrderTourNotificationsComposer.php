<?php

namespace App\Http\ViewComposers;

use App\OrderTour;
use Illuminate\View\View;

class OrderTourNotificationsComposer
{
    /**
     * @var int
     */
    public $orderNotificationsCount = 0;

    /**
     * @var array
     * Stable orderNotifications items
     */
    public $orderNotifications;

    /**
     * MenuComposer constructor.
     *
     * adding custom created pages to stable menu items and sharing to layouts
     */
    public function __construct()
    {
        $model = new OrderTour();
        $this->orderNotifications = $model->getNotReadedOrders($this->orderNotificationsCount);
    }

    public function compose(View $view)
    {
        $view->with('orderNotificationsCount', $this->orderNotificationsCount);
        $view->with('orderNotifications', $this->orderNotifications);
    }
}