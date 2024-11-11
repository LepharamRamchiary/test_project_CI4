<?php

namespace App\Models;

use \CodeIgniter\Model;

class DashboardModel extends Model
{
    public function getLoggedUserData($id)
    {
        $builder = $this->db->table('users');
        $builder->where('uniid', $id);
        $result = $builder->get();
        if (count($result->getResultArray()) == 1) {
            return $result->getRow();
        } else {
            return false;
        }
    }

    public function updateLogoutTime($id)
    {
        $builder = $this->db->table('login_activity');
        $builder->where('id', $id);
        $builder->update(['logout_time' => date('Y-m-d h:i:s')]);
        if ($this->db->affectedRows() > 0) {
            return true;
        }
    }

    public function getLoginUserInfo($uniid)
    {
        $builder = $this->db->table('login_activity');
        $builder->where('uniid', $uniid);
        $builder->orderBy('id',);
        $builder->limit(10);
        $result = $builder->get();

        if (count($result->getResultArray())) {
            return $result->getResult();
        } else {
            return false;
        }
    }
}
