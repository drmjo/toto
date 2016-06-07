<?php

namespace Coyote\BaseBundle\Twig\Extension;

class Extensions extends \Twig_Extension
{
    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('boolean_label', 'booleanLabel'),
            new \Twig_SimpleFilter('usd', 'usd'),
        );
    }

    public function usd($number)
    {
        return '$' . number_format($number, 2);
    }

    public function booleanLabel($bool, $trueLabel = 'true', $falseLabel = 'false')
    {
        $labelClass = $bool ? "label-success" : "label-danger";
        $label = $bool ? $trueLabel : $falseLabel;
        $html = '<span class="label ' . $labelClass . '">' . $label . '</span>';

        return $html;
    }
    
    public function getName()
    {
        return 'coyote_base_twig_extensions';
    }
}