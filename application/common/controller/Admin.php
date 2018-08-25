<?php namespace app\common\controller;
use think\Controller;
use think\Db;
use think\facade\Request;
use think\facade\Session;

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/8/21
 * Time: 17:47
 */
class Admin extends Controller
{
    protected $isMobile;//是否从手机端打开
    protected $adminame;//后台用户名
    protected $uid;//后台用户名id
    public function __construct()
    {
        parent::__construct();
        //判断是否从手机端打开
        $detect = new \Mobile_Detect();
        $this->isMobile = $detect->isMobile();
        $this->assign('isMobile',$this->isMobile);
        if(Request::controller()!='Login'){
            $uid = Session::get("adminUid");
            if($uid){
                $map['type'] = 1;
                $map['state'] = 1;
                $map['id'] = $uid;
                $uerData = Db::connect('db_sqlite')->table('user')->where($map)->find();
                if(!$uerData){
                    exit('<script>top.location.href="'.url('admin/Login/index').'";</script>');
//                    return $this->redirect('/admin/Login/index');
                }else{
                    $this->adminnName = $uerData['name'];
                    $this->uid = $uid;
                }
            }else{
                exit('<script>top.location.href="'.url('admin/Login/index').'";</script>');
                //return $this->redirect('/admin/Login/index');
            }
        }
    }

}