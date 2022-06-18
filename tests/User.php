<?php

namespace YieldStudio\LaravelMailjetNotifier\Tests;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class User extends Model {
    use Notifiable;
}
