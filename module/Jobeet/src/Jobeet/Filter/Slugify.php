<?php
    namespace Jobeet\Filter;
    use Zend\Filter\FilterInterface;

    class Slugify implements FilterInterface
    {
        public function filter($value) {
            $value = htmlentities($value, ENT_NOQUOTES, 'utf-8');
            $value = preg_replace('#\&([A-za-z])(?:acute|cedil|circ|grave|ring|tilde|uml)\;#', '\1', $value);
            $value = preg_replace('#\&([A-za-z]{2})(?:lig)\;#', '\1', $value);
            $value = preg_replace('#\&[^;]+\;#', '', $value);
            $value = preg_replace('/\s/', '', $value);
            $value = preg_replace('/\W+/', '-', $value);
            $value = strtolower(trim($value, '-'));
            
            return $value;
        }
    }
