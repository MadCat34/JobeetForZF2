<?php
namespace Front\Model;

use Zend\Debug\Debug;

use Zend\Db\Sql\Select;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;

class JobTable
{
    protected $tableGateway;

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    public function getAdapter()
    {
        return $this->tableGateway->getAdapter();
    }
    
    public function fetchAll()
    {
        $resultSet = $this->tableGateway->select();
        
        return $resultSet;
    }

    public function fetchByIdCategoryWithLimit($idCategory, $limit = 10, $nbDays = 30)
    {
        $select = new Select($this->tableGateway->getTable());
        $select->where("id_category = {$idCategory}")
               ->where("created_at >= '" . date('Y-m-d H:i:s', time() - 86400 * $nbDays) . "'")
               ->limit($limit);

        $resultset = $this->tableGateway->selectWith($select);

        return $resultset;
    }

    public function fetchAllByIdCategory($idCategory, $limit = 10, $nbDays = 30)
    {
        $resultSet = $this->tableGateway->select(
            array(
                'id_category = ?' => (int)$idCategory,
                'created_at >= ?' => date('Y-m-d H:i:s', time() - 86400 * $nbDays)
            )
        );
        return $resultSet;
    }

    public function getActiveJobsForPagination($idCategory, $nbDays)
    {
        $select = new \Zend\Db\Sql\Select();
        $select->from($this->tableGateway->getTable())
               ->where(
                   array(
                       'id_category = ?' => (int)$idCategory,
                       'created_at >= ?' => date('Y-m-d H:i:s', time() - 86400 * $nbDays)
                   )
               );
    
        return $select;
    }

    public function getJob($id)
    {
        $id  = (int)$id;
        $rowset = $this->tableGateway->select(array('id_job' => $id));
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
            $this->tableGateway->insert($data);
        } elseif ($this->getJob($id)) {
            $this->tableGateway->update(
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
        $this->tableGateway->delete(array('id' => $id));
    }
}
