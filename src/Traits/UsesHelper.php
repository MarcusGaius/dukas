<?php

namespace MarcusGaius\YTData\Traits;

use MarcusGaius\YTData\Helpers\Helpers;

trait UsesHelper
{
    public function helper()
    {
        return new Helpers;
    }
}
