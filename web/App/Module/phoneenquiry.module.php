<?
/**
* 联系电话列表
*
* 联系电话列表创建，修改，删除等
*
* @package	Module
* @author	Far
* @since	2016-7-25
*/
class PhoneEnquiryModule extends AppModule
{
    public $models = array(
        'phone'     => 'phoneEnquiry',
        'user'      => 'user',
    );
    
    public function addPhone($number, $phone, $type){
        $date = array(
            'number'        => $number,
            'phone'         => $phone,
            'type'          => $type,
            'device'        => 1,
            );
        $pid  = $this->import('phone')->create($date);
        return $pid;
    }

    //查询用户信息
    public function getUserByPhone($phone){
        $r['eq'] = array('mobile' => $phone);
        $info    = $this->import('user')->find($r);
        return $info;

    }
    
    public function sendMsg($phone){
        $msgArr     = C('MSG_TEMPLATE');
        $array      = $this->importBi('message')->sendMsg($phone,$msgArr['msg'],$msgArr['id']);
        return $array;;
    }
   
}
?>