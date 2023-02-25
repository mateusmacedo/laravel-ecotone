<?php
namespace Module\Core\Domain\Contracts;

use Illuminate\Support\Facades\Date;

abstract class DomainEvent
{
    public Date $occouranceDate;

    public mixed $data;

}
