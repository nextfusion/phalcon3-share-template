<?php

namespace Base\Components;

class CAuth extends \Phalcon\Mvc\User\Component {
    
    private $id         = 0;

    private $adminId    = 1;
    private $adminEmail = 'eakkabin@drivesoft.co.th';
    
    // ระดับ
    private $role = [
        'OW' => 'Owner',   // ผู้บริหาร (Owner)
        'AD' => 'Admin',   // ผู้ดูแลระบบ (Admin)
        'MG' => 'Manager', // ผู้จัดการ (Manager)
        'MB' => 'Member',  // สมาชิก (Member)
        'VP' => 'Vip',     // สมาชิกพิเศษ (Vip)
        'GU' => 'Guest',   // ผู้ใช้ทั่วไป (Guest)
    ];
    
    # =====================================================================

    // แสดงข้อมูล Auth ทั้งหมด
    public function get () {
        if (!empty($this->session->has('auth'))) {
            return $this->session->get('auth');
        }
        return null;
    }

    // แสดงข้อมูล User ID
    public function getId () {
        if (!empty($this->session->has('auth'))) {
            $auth = $this->session->get('auth');
            return $auth->id;
        }
        return 0;
    }
    
    // แสดงข้อมูล E-Mail
    public function getEmail () {
        if (!empty($this->session->has('auth'))) {
            $auth = $this->session->get('auth');
            return $auth->email;
        }
        return null;
    }

    // แสดงข้อมูล User
    public function getUser () {
        if ($this->isAuth() === true) {
            $auth = $this->session->get('auth');
            $model = \Example\Models\Maria\UserModel::findFirst([ 
                'conditions' => 'user_id = :user_id: AND user_email = :user_email:', 
                'bind' => [ 'user_id' => $auth->id, 'user_email' => $auth->email ],
                'bindTypes' => [ 'user_id' => \Phalcon\Db\Column::BIND_PARAM_INT, 'user_email' => \Phalcon\Db\Column::BIND_PARAM_STR ],
            ]);
            if (!empty($model)) {
                return (object) [
                    'user_id'          => $model->user_id,
                    'user_name'        => $model->user_name,
                    'user_email'       => $model->user_email,
                    'user_create_at'   => $model->user_create_at,
                    'user_update_at'   => $model->user_update_at,
                    'user_last_visit'  => $model->user_last_visit,
                    'user_login_count' => $model->user_login_count,
                    'user_role'        => $model->role,
                    'user_status'      => $model->status
                ];
            }
       }
       return false;
    }

    # =====================================================================
    
    // Online หรือไม่
    public function isAuth () {
        if (!empty($this->session->has('auth'))) {
            $auth = $this->session->get('auth');
            if (!empty($auth->role)) {
                return true;
            }
        }
        return false;
    }

    // ใช่ Owner หรือไม่
    public function isOwner () {
        if (!empty($this->session->has('auth'))) {
            $auth = $this->session->get('auth');
            if ((!empty($auth->role) && $auth->role === 'Owner')) {
                return true;
            }
        }
        return false;
    }
    
    // ใช่ Admin หรือไม่
    public function isAdmin () {
        if (!empty($this->session->has('auth'))) {
            $auth = $this->session->get('auth');
            if ((!empty($auth->role) && $auth->role === 'Admin') && ($auth->id === $this->adminId) && ($auth->email === $this->adminEmail)) {
                return true;
            }
        }
        return false;
    }

    // ใช่ Manager หรือไม่
    public function isManager () {
        if (!empty($this->session->has('auth'))) {
            $auth = $this->session->get('auth');
            if ((!empty($auth->role) && $auth->role === 'Manager')) {
                return true;
            }
        }
        return false;
    }

    // ใช่ Member หรือไม่
    public function isMember () {
        if (!empty($this->session->has('auth'))) {
            $auth = $this->session->get('auth');
            if (!empty($auth->role) && $auth->role === 'Member') {
                return true;
            }
        }
        return false;
    }

    // ใช่ Vip หรือไม่
    public function isVip () {
        if (!empty($this->session->has('auth'))) {
            $auth = $this->session->get('auth');
            if (!empty($auth->role) && $auth->role === 'Vip') {
                return true;
            }
        }
        return false;
    }

    // ใช่ Guest หรือไม่
    public function isGuest () {
        if (empty($this->session->has('auth'))) {
            return true;
        }
        return false;
    }

    # =====================================================================
    
    // ลงทะเบียน auth
    public function registerSession ($model = []) {
        
        if (!empty($model)) {
            
            $model->user_login_count  = $model->user_login_count + 1;
            $model->user_last_visit   = date('Y-m-d H:i:s', time());
            
            if (!empty($model->save())) {
                
                $this->session->remove('auth');
                
                $this->session->set('auth', (object) [
                    'id'    => $model->user_id,
                    'name'  => $model->user_name,
                    'email' => $model->user_email,
                    'role'  => $this->role[$model->user_role]
                ]);
                
                return true;
                
            }
            
        }
        
        return false;
        
    }
    
    // ยกเลิกการทะเบียน auth
    public function removeSession () {
        if (!empty($this->session->has('auth'))) {
            $this->session->remove('auth');
            return true;
        }
        return false;
    }
    
}