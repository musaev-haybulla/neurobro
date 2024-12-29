<?php
namespace NeuroBro\Contracts\Limits;

enum LimitLevel: int
{
    case SECOND = 1;
    case MINUTE = 2;
    case HOUR = 3;
    case DAY = 4;
    case MONTH = 5;
}
