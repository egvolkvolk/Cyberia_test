<?php

namespace App\Entities\Enum\SortParameters;

enum OrderParameters: string
{
    case product = 'product';
    case sum = 'sum';
    case created_at = 'created_at';
    case user = 'user';
}
