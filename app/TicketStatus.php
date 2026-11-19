<?php

namespace App;

enum TicketStatus: string
{
    case Available = 'available';
    case Reserved = 'reserved';
    case Bought = 'bought';
}
