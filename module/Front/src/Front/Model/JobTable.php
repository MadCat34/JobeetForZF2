<?php
namespace Front\Model;

use Zend\Db\Sql\Select;
use Zend\Db\Adapter\Adapter;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\AbstractTableGateway;

class JobTable extends AbstractTableGateway
{
    protected $table ='job';

    public function __construct(Adapter $adapter)
    {
        $this->adapter = $adapter;
        $this->resultSetPrototype = new ResultSet();
        $this->resultSetPrototype->setArrayObjectPrototype(new Job());
        $this->initialize();
    }

    public function fetchAll()
    {
        $resultSet = $this->select();
        return $resultSet;
    }
    
    public function fetchByIdCategoryWithLimit($idCategory, $limit)
    {
        $select = new Select();
        $select->from('job')
               ->where('id_category = ' . (int)$idCategory)
               ->limit((int)$limit);

        $resultSet = $this->select($select);
        return $resultSet;
    }
    
    public function fetchAllByIdCategory($idCategory)
    {
    	$id  = (int)$idCategory;
        $resultSet = $this->select(array('id_category' => $id));
        return $resultSet;
    }
    

    public function getJob($id)
    {
        $id  = (int)$id;
        $rowset = $this->select(array('id_job' => $id));
        $row = $rowset->current();

        if (!$row) {
            throw new \Exception("Could not find row $id");
        }

        return $row;
    }

    public function saveJob(Job $job)
    {
        $data = array(
            'id_job' => $job->idJob,
            'id_category' => $job->idCategory,
            'id_user' => $job->idUser,
            'type' => $job->type,
            'company' => $job->company,
            'logo' => $job->logo,
            'url' => $job->url,
            'position' => $job->position,
            'location' => $job->location,
            'description' => $job->description,
            'howToPlay' => $job->howToPlay,
            'isPublic' => $job->isPublic,
            'isActivated' => $job->isActivated,
            'email' => $job->email,
            'createdAt' => $job->createdAt
        );

        $id = (int)$job->idJob;

        if ($id == 0) {
            $this->insert($data);
        } elseif ($this->getJob($id)) {
            $this->update(
                $data,
                array(
                    'id_job' => $id,
                )
            );
        } else {
            throw new \Exception('Form id does not exist');
        }
    }

    public function deleteJob($id)
    {
        $this->delete(array('id' => $id));
    }
}