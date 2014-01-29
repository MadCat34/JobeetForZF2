<?php
namespace Jobeet\Controller;

use RuntimeException;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Stdlib\ArrayUtils;

class JobeetController extends AbstractActionController
{

    protected $config = array();

    protected $jobTable;

    protected $categoryTable;

    public function __construct($category, $job)
    {
        $this->categoryTable = $category;
        $this->jobTable = $job;
    }

    public function setConfig($config)
    {
        if ($config instanceof \Traversable) {
            $config = ArrayUtils::iteratorToArray($config);
        }
        
        if (! is_array($config)) {
            throw new RuntimeException(sprintf('Expected array or Traversable Jobeet configuration; received %s', (is_object($config) ? get_class($config) : gettype($config))));
        }
        $this->config = $config;
    }

    public function setCategoryTable($category)
    {
        $this->categoryTable = $category;
    }

    public function setJobTable($job)
    {
        $this->jobTable = $job;
    }
}
