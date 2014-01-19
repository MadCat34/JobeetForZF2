<?php
namespace Front\Model;

use Zend\Db\Adapter\Adapter;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\AbstractTableGateway;

class UserTable extends AbstractTableGateway
{
    protected $table ='users';

    public function __construct(Adapter $adapter)
    {
        $this->adapter = $adapter;
        $this->resultSetPrototype = new ResultSet();
        $this->resultSetPrototype->setArrayObjectPrototype(new User());
        $this->initialize();
    }

    public function fetchAll()
    {
        $resultSet = $this->select();
        return $resultSet;
    }

    public function getUser($id)
    {
        $id  = (int)$id;
        $rowset = $this->select(array('id' => $id));
        $row = $rowset->current();

        if (!$row) {
            throw new \Exception("Could not find row $id");
        }

        return $row;
    }

    public function saveUser(User $user)
    {
        $data = array(
            'id_user' => $user->idUser,
            'email' => $user->email,
            'password' => $user->password,
            'is_active' => $user->isActive,
            'type' => $user->type,
            'created_at' => $user->createdAt
        );

        $id = (int)$user->idUser;

        if ($id == 0) {
            $this->insert($data);
        } elseif ($this->getCategory($id)) {
            $this->update(
                $data,
                array(
                    'id_user' => $id,
                )
            );
        } else {
            throw new \Exception('Form id does not exist');
        }
    }

    public function deleteUser($id)
    {
        $this->delete(array('id' => $id));
    }
}