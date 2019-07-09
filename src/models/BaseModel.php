<?php
namespace Project\Phpblog\models;

use Project\Phpblog\core\DBDriver;
use Project\Phpblog\core\Validator;
use Project\Phpblog\core\Exception\ModelIncorrectDataException;

abstract class BaseModel
{
    protected $db;
    protected $table;
    protected $validator;

    public function __construct(DBDriver $db, Validator $validator, $table)
    {
        $this->db = $db;
        $this->table = $table;
        $this->validator = $validator;
    }

    public function getAll($params = '')
    {
        return $this->db->select($this->table, $params);
    }

    public function getById($id)
    {
        return $this->db->select($this->table, $id, DBDriver::FETCH_ONE);
    }

    public function delById($id)
    {
        $this->db->delete($this->table, ['id' => $id]);
    }

    public function updateById($id, $params)
    {
        $this->db->update($this->table, $params, "id = $id");
    }

    public function addNew($params, $needValidator = true)
    {
        if($needValidator){
            $this->validator->execute($params);

            if(!$this->validator->success) {
                throw new ModelIncorrectDataException($this->validator->errors);
            }
        }

        return $this->db->insert($this->table, $params);
    }

}