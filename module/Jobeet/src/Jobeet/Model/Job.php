<?php
namespace Jobeet\Model;

use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilter;
use Zend\Db\Adapter\AdapterAwareInterface;
use Zend\Db\Adapter\AdapterInterface;

class Job implements InputFilterAwareInterface
{
    public $id_job;
    public $id_category;
    public $type;
    public $company;
    public $logo;
    public $url;
    public $position;
    public $location;
    public $description;
    public $how_to_play;
    public $is_public;
    public $is_activated;
    public $email;
    public $created_at;
    public $updated_at;
    protected $inputFilter;
    protected $dbAdapter;

    public function exchangeArray($data)
    {
        $this->id_job = (isset($data['id_job'])) ? $data['id_job'] : null;
        $this->id_category = (isset($data['id_category'])) ? $data['id_category'] : null;
        $this->type = (isset($data['type'])) ? $data['type'] : null;
        $this->company = (isset($data['company'])) ? $data['company'] : null;
        $this->logo = (isset($data['logo'])) ? $data['logo'] : null;
        $this->url = (isset($data['url'])) ? $data['url'] : null;
        $this->position = (isset($data['position'])) ? $data['position'] : null;
        $this->location = (isset($data['location'])) ? $data['location'] : null;
        $this->description = (isset($data['description'])) ? $data['description'] : null;
        $this->how_to_play = (isset($data['how_to_play'])) ? $data['how_to_play'] : null;
        $this->is_public = (isset($data['is_public'])) ? $data['is_public'] : 0;
        $this->is_activated = (isset($data['is_activated'])) ? $data['is_activated'] : 1;
        $this->email = (isset($data['email'])) ? $data['email'] : null;
        $this->created_at = (isset($data['created_at'])) ? $data['created_at'] : null;
        $this->updated_at = (isset($data['updated_at'])) ? $data['updated_at'] : null;
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
                    'name'     => 'id_category',
                    'required' => true,
                )
            );
            
            $inputFilter->add(
                array(
                    'name' => 'type',
                    'required' => true,
                )
            );

            $inputFilter->add(
                array(
                    'name' => 'company',
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
                                'max'      => 255,
                            )
                        )
                    )
                )
            );
            
            $inputFilter->add(
                array(
                    'name' => 'logo',
                    'required' => true,
                )
            );
            
            $inputFilter->add(
                array(
                    'name' => 'url',
                    'required' => false,
                    'filters'  => array(
                        array('name' => 'StripTags'),
                        array('name' => 'StringTrim'),
                    ),
                    'validators' => array(
                        array(
                            'name'    => 'StringLength',
                            'options' => array(
                                'encoding' => 'UTF-8',
                                'min' => 1,
                                'max' => 255,
                            )
                        ),
                    )
                )
            );
            
            $inputFilter->add(
                array(
                    'name' => 'position',
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
                                'min' => 1,
                                'max' => 255,
                            )
                        )
                    )
                )
            );
            
            $inputFilter->add(
                array(
                    'name' => 'location',
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
                                'min' => 1,
                                'max' => 255,
                            )
                        )
                    )
                )
            );
            
            $inputFilter->add(
                array(
                    'name' => 'description',
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
                                'min' => 1,
                                'max' => 255,
                            )
                        )
                    )
                )
            );
            
            $inputFilter->add(
                array(
                    'name' => 'how_to_play',
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
                                'min' => 1,
                                'max' => 255,
                            )
                        )
                    )
                )
            );
            
            $inputFilter->add(
                array(
                    'name' => 'email',
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
                                'min' => 1,
                                'max' => 255,
                            )
                        ),
                        array(
                            'name' => 'EmailAddress'
                        )
                    )
                )
            );
            
            $inputFilter->add(
                array(
                    'name' => 'is_public',
                    'required' => false,
                )
            );
            
            $inputFilter->add(
                array(
                    'name' => 'is_activated',
                    'required' => true,
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
