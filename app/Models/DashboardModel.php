<?php

namespace App\Models;

use \CodeIgniter\Model;

class DashboardModel extends Model {
    public function getLoggedUserData($id) {
        $builder = $this->db->table('users');
        $builder->where('uniid', $id);
        $result = $builder->get();
        if(count($result->getResultArray())==1){
            return $result->getRow();
        }else{
            return false;
        }
    }
}
