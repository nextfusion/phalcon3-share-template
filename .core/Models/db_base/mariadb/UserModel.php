<?php

namespace Base\Models\Maria;

class UserModel extends \Base\Components\CModel {
    
    public $user_id;            // รหัสสมาชิก int (11)
    public $user_name;          // ชื่อผู้ใช้งาน varchar (100)
    public $user_email;         // อีเมล์ varchar (128)
    public $user_password;      // รหัสผ่าน varchar (128)
    public $user_activation;    // ความปลอดภัย varchar (128)
    public $user_role;          // ระดับผู้ใช้ char (2) default = MB (สมาชิก)
    public $user_create_at;     // สมัครเมื่อ timestamp
    public $user_update_at;     // อัพเดทล่าสุด timestamp
    public $user_last_visit;    // ล๊อกอินล่าสุด timestamp
    public $user_login_count;   // จำนวนล๊อกอิน int (5) default = 0
    public $user_status;        // สถานะ char (1) default = N (สมาชิกใหม่)
    
    /* ===========================================================================
     * SETTING
     * =========================================================================== */

    public function initialize () {
        $this->setConnectionService('db2_base');
    }

    public function getSource () {
        return 'tbl_user';
    }
    
    /* ===========================================================================
     * GET
     * =========================================================================== */
    
    public function getRole () {
        $roles = [
            'AD' => 'Admin',   // ผู้ดูแลระบบ (Admin)
            'MG' => 'Manager', // ผู้จัดการ (Manager)
            'MB' => 'Member',  // สมาชิก (Member)
            'OW' => 'Owner',   // ผู้บริหาร (Owner)
            'VI' => 'Vip'      // สมาชิกพิเศษ (Vip)
        ];
        return !empty($roles[$this->user_role]) ? $roles[$this->user_role] : null;
    }

    public function getStatus () {
        $status = [
            'N' => 'New',
            'A' => 'Active',
            'B' => 'Ban',
            'C' => 'Cancel',
        ];
        return !empty($status[$this->user_status]) ? $status[$this->user_status] : null;
    }
    
    public function getCreateAt () {
        return \DateLibrary::thai_datetime($this->user_create_at);
    }
    
    /* ===========================================================================
     * FIND DATA
     * =========================================================================== */
    
    public static function findOneByEmail ($user_email = null) {
        if (!empty($user_email)) {
            return self::findFirst([ 
                'conditions' => 'user_email = :user_email:', 
                'bind' => [ 'user_email' => $user_email ]
            ]);
        }
        return false;
    }
    
    /* ===========================================================================
     * FIND BY ADMIN
     * =========================================================================== */
    
    public static function findAllUserByAdmin ($admin = []) {
        if (!empty($admin)) {
            return self::find([ 'order' => 'user_create_at DESC', 'limit' => 15 ]);
        }
        return false;
    }
    
}
