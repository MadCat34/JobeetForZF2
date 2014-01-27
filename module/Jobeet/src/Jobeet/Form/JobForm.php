<?php
    namespace Jobeet\Form;
    use Zend\Form\Form;
    use Jobeet\Model\CategoryTable;

    class JobForm extends Form
    {
        protected $categoryTable = null;
        
        public function __construct(CategoryTable $table)
        {
            parent::__construct('Job');
            $this->setAttribute('method', 'post');
            $this->setAttribute('enctype', 'multipart/form-data');
            
            $this->categoryTable = $table;
            
            $this->add(
                array(
                    'name' => 'id_job',
                    'type' => 'Hidden',
                )
            );
            
            $this->add(
                array(
                    'name' => 'csrf',
                    'type' => 'Csrf',
                    'options' => array(
                        'csrf_options' => array(
                            'timeout' => 600
                        )
                    )
                )
            );
            
            $this->add(
                array(
                    'name' => 'id_category',
                    'type' => 'Select',
                    'attributes' => array(
                        'id'    => 'id_category'
                    ),
                    'options' => array(
                        'label' => 'Catégory',
                        'value_options' => $this->getCategoryOptions(),
                        'empty_option'  => '--- Sélectionnez une categorie---'
                    ),
                )
            );

            $this->add(
                array(
                    'name' => 'type',
                    'type' => 'Radio',
                    'attributes' => array(
                        'id'    => 'type'
                    ),
                    'options' => array(
                        'label' => 'Type',
                        'value_options' => array(
                            'Plein-temps' => 'Plein-temps',
                            'Mi-temps' => 'Mi-temps',
                            'Freelance' => 'Freelance'
                        )
                    )
                )
            );

            $this->add(
                array(
                    'name' => 'company',
                    'type' => 'Text',
                    'attributes' => array(
                        'id'    => 'company'
                    ),
                    'options' => array(
                        'label' => 'Company'
                    )
                )
            );
            
            $this->add(
                array(
                    'name' => 'logo',
                    'type' => 'File',
                    'attributes' => array(
                        'id'    => 'logo'
                    ),
                    'options' => array(
                        'label' => 'Company logo'
                    )
                )
            );
            
            $this->add(
                array(
                    'name' => 'url',
                    'type' => 'Url',
                    'attributes' => array(
                        'id'    => 'url'
                    ),
                    'options' => array(
                        'label' => 'Url'
                    )
                )
            );

            $this->add(
                array(
                    'name' => 'position',
                    'type' => 'Text',
                    'attributes' => array(
                        'id'    => 'position'
                    ),
                    'options' => array(
                        'label' => 'Position'
                    )
                )
            );
            
            $this->add(
                array(
                    'name' => 'location',
                    'type' => 'Text',
                    'attributes' => array(
                        'id'    => 'location'
                    ),
                    'options' => array(
                        'label' => 'Location'
                    )
                )
            );

            $this->add(
                array(
                    'name' => 'description',
                    'type' => 'Textarea',
                    'attributes' => array(
                        'id'    => 'description',
                        'rows' => 4,
                        'cols' => 30,
                    ),
                    'options' => array(
                        'label' => 'Description'
                    )
                )
            );
            
            $this->add(
                array(
                    'name' => 'how_to_play',
                    'type' => 'Textarea',
                    'attributes' => array(
                        'id'    => 'how_to_play',
                        'rows' => 4,
                        'cols' => 30,
                    ),
                    'options' => array(
                        'label' => 'How to apply'
                    )
                )
            );
            
            $this->add(
                array(
                    'name' => 'is_public',
                    'type' => 'MultiCheckbox',
                    'attributes' => array(
                        'id'    => 'is_public'
                    ),
                    'options' => array(
                        'label' => 'Public ?',
                        'value_options' => array(
                            '1' => 'Whether the job can also be published on affiliate websites or not.'
                        )
                    )
                )
            );
            
            $this->add(
                array(
                    'name' => 'is_activated',
                    'type' => 'Radio',
                    'attributes' => array(
                        'value' => 1,
                    ),
                    'options' => array(
                        'label' => 'Activated ?',
                        'value_options' => array(
                            1 => 'Oui',
                            0 => 'Non',
                        )
                    )
                )
            );
            
            $this->add(
                array(
                    'name' => 'email',
                    'type' => 'Text',
                    'attributes' => array(
                        'id'    => 'email'
                    ),
                    'options' => array(
                        'label' => 'Email'
                    )
                )
            );
            
            $this->add(
                array(
                    'name' => 'submit',
                    'type' => 'Submit',
                    'attributes' => array(
                        'value' => 'Save your job',
                        'class' => 'btn',
                        'id' => 'submit',
                    ),
                )
            );
        }
        
        public function getCategoryOptions()
        {
            $data  = $this->categoryTable->fetchAll()->toArray();
            $selectData = array();
            
            foreach ($data as $key => $selectOption) {
                $selectData[$selectOption["id_category"]] = $selectOption["name"];
            }

            return $selectData;
        }
    }
