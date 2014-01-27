<?php
namespace Front\Model;

use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilter;

class Job implements InputFilterAwareInterface
{
    public $idJob;
    public $idCategory;
    public $type;
    public $company;
    public $logo;
    public $url;
    public $position;
    public $location;
    public $description;
    public $howToPlay;
    public $isPublic;
    public $isActivated;
    public $email;
    public $createdAt;
    public $updatedAt;
    protected $inputFilter;

    public function exchangeArray($data)
    {
        $this->idJob = (isset($data['id_job'])) ? $data['id_job'] : null;
        $this->idCategory = (isset($data['id_category'])) ? $data['id_category'] : null;
        $this->type = (isset($data['type'])) ? $data['type'] : null;
        $this->company = (isset($data['company'])) ? $data['company'] : null;
        $this->logo = (isset($data['logo'])) ? $data['logo'] : null;
        $this->url = (isset($data['url'])) ? $data['url'] : null;
        $this->position = (isset($data['position'])) ? $data['position'] : null;
        $this->location = (isset($data['location'])) ? $data['location'] : null;
        $this->description = (isset($data['description'])) ? $data['description'] : null;
        $this->howToPlay = (isset($data['how_to_play'])) ? $data['how_to_play'] : null;
        $this->isPublic = (isset($data['is_public'])) ? $data['is_public'] : 0;
        $this->isActivated = (isset($data['is_activated'])) ? $data['is_activated'] : 1;
        $this->email = (isset($data['email'])) ? $data['email'] : null;
        $this->createdAt = (isset($data['created_at'])) ? $data['created_at'] : null;
        $this->updatedAt = (isset($data['updated_at'])) ? $data['updated_at'] : null;
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
}
