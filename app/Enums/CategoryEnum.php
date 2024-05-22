<?php

namespace App\Enums;

use App\Infra\Traits\EnumHelper;

enum CategoryEnum: string
{
    use EnumHelper;

    case Performance = 'PERFORMANCE';
    case Accessibility = 'ACCESSIBILITY';
    case BestPractices = 'BEST_PRACTICES';
    case SEO = 'SEO';
    case PWA = 'PWA';
}
