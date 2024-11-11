<?php

namespace App\Models;

use \CodeIgniter\Model;

class RegisterModel extends Model
{
    public function createUser($data)
    {
        $builder = $this->db->table('users');
        $result = $builder->insert($data);
        if ($this->db->affectedRows() == 1) {
            return true;
        } else {
            return false;
        }
    }

    public function verifyUniid($id)
    {
        $builder = $this->db->table('users');
        $builder->select('activation_date,status,uniid');
        $builder->where('uniid', $id);

        $result = $builder->get();
        // echo count($result->getResultArray());
        // echo count();
        // when we use $bulder->countall then we got all users account == 1 eg 2==1 it not working
        if (count($result->getResultArray()) == 1) {

            return $result->getRow();
        } else {
            return false;
        }
    }

    public function updateStatus($uniid)
    {
        $builder = $this->db->table('users');
        $builder->where('uniid', $uniid);
        $builder->update(['status' => 'active']);
        if ($this->db->affectedRows() == 1) {
            return true;
        } else {
            return false;
        }
    }
}
