<?php
namespace App\View\Helper;

use Cake\View\Helper;
use Cake\Utility\Inflector;

class CustomHelper extends Helper
{
    public function pluralize(string $word): string
    {
        return Inflector::pluralize($word);
    }
}
