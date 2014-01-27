<?php
namespace Jobeet\Model;

use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilter;
use Jobeet\Filter\Slugify;
use Zend\Db\Adapter\AdapterInterface;

class Category implements InputFilterAwareInterface
{
    public $id_category;
    public $name;
    public $slug;
    protected $inputFilter;
    protected $dbAdapter;

    public function exchangeArray($data)
    {
        $slugifyFilter = new Slugify();
        
        $this->id_category = (isset($data['id_category'])) ? $data['id_category'] : null;
        $this->name = (isset($data['name'])) ? $data['name'] : null;
        $this->slug = (isset($data['slug'])) ? $data['slug'] : $slugifyFilter->filter($this->name);
    }
    
    public function getArrayCopy()
    {
        return get_object_vars($this);
    }
    
    public function setInputFilter(\Zend\InputFilter\InputFilterInterface $inputFilter)
    {
        $this->inputFilter = $inputFilter;
    }
    
    public function getInputFilter()
    {
        if (!$this->inputFilter) {
            $inputFilter = new InputFilter();

            $inputFilter->add(
                array(
                    'name'     => 'name',
                    'required' => true,
                    'filters'  => array(
                        array('name' => 'StripTags'),
                        array('name' => 'StringTrim'),
                    ),
                    'validators' => array(
                        array(
                            'name'    => 'StringLength',
                            'options' => array(
                                'encoding' => 'UTF-8',
                                'min'      => 1,
                                'max'      => 100,
                            ),
                        ),
                    ),
                )
            );

            $inputFilter->add(
                array(
                    'name'     => 'slug',
                    'required' => true,
                    'filters'  => array(
                        array('name' => 'StripTags'),
                        array('name' => 'StringTrim'),
                        array('name' => '\Jobeet\Filter\Slugify'),
                    ),
                    'validators' => array(
                        array(
                            'name'    => 'StringLength',
                            'options' => array(
                                'encoding' => 'UTF-8',
                                'min'      => 1,
                                'max'      => 100,
                            ),
                        ),
                    ),
                )
            );
            
            $this->inputFilter = $inputFilter;
        }
    
        return $this->inputFilter;
    }
    
    public function setDbAdapter(AdapterInterface $adapter)
    {
        $this->dbAdapter = $adapter;
    }
    
    public function getDbAdapter()
    {
        return $this->dbAdapter;
    }
}
