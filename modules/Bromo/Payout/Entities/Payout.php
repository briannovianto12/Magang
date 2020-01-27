<?php

namespace Bromo\Payout\Entities;

use Illuminate\Database\Eloquent\Model;
use Bromo\Payout\Entities\UserProfile;
use Bromo\Auth\Models\Admin;

class Payout extends Model
{
    

    protected $table = 'payout';

    public function userProfile()
    {
        return $this->hasOne('Bromo\Payout\Entities\UserProfile', 'id', 'created_for_user_id');
    }
    
    public function admin()
    {
        return $this->hasOne('Bromo\Auth\Models\Admin', 'id', 'created_by');
    }
    
    protected $dateFormat = 'Y-m-d H:i:s.uO';

}
