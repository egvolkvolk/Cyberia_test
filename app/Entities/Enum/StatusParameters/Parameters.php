<?php

namespace App\Entities\Enum\StatusParameters;

enum Parameters :string
{
    case New = 'New';
    case Confirmed = 'Confirmed';
    case Canceled = 'Canceled';

}
