<?php

namespace App\Helpers;

use Midtrans\Config;
use Pest\Mutate\Mutators\Logical\TrueToFalse;

class MidtransConfig {
    public static function setup() {
        Config::$serverKey = env('SB-Mid-server-SF9gSwdZsGGhVYPCU0lvb8Ei');
        Config::$isProduction = env('MIDTRANS_IS_PRODUCTION', false);
        Config::$isSanitized = true;
        Config::$is3ds = true;
    }
}