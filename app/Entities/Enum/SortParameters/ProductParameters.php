<?php

namespace App\Entities\Enum\SortParameters;

enum ProductParameters: string
{
    case category_id = 'category_id';
    case name = 'name';
    case price = 'price';
}
