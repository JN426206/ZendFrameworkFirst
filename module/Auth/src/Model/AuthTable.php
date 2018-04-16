<?php
namespace Auth\Model;

use RuntimeException;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Sql\Select;
use Zend\Db\TableGateway\TableGatewayInterface;
use Zend\Paginator\Adapter\DbSelect;

class AuthTable
{
    private $tableGateway;
    
    
    public function __construct(TableGatewayInterface $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }
    
    public function fetchAll()
    {        
        return $this->tableGateway->select();
    }
    
    public function getAuth($id)
    {
        $id = (int) $id;
        $rowset = $this->tableGateway->select(['id' => $id]);
        $row = $rowset->current();
        if (! $row) {
            throw new RuntimeException(sprintf(
                'Could not find row with identifier %d',
                $id
                ));
        }
        
        return $row;
    }
    
    public function saveAuth(Auth $auth)
    {
        $data = [
            'userName' => $auth->userName,
            'email'  => $auth->email,
            'password'  => $auth->password,
        ];
        
        $id = (int) $auth->id;
        
        if ($id === 0) {
            $this->tableGateway->insert($data);
            return;
        }
        
        if (! $this->getAuth($id)) {
            throw new RuntimeException(sprintf(
                'Cannot update album with identifier %d; does not exist',
                $id
                ));
        }
        
        $this->tableGateway->update($data, ['id' => $id]);
    }
    
    public function deleteAuth($id)
    {
        $this->tableGateway->delete(['id' => (int) $id]);
    }
}