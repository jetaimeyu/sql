<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/8/22
 * Time: 17:45
 */

namespace app\common\controller;
use think\Controller;
use think\Db;
use think\facade\Cache;
use think\facade\Session;

class Home extends Controller
{
    protected $uname;
    protected $uid;
    public function __construct()
    {
        parent::__construct();
        $uid = Session::get("md_uid");
        if($uid){
            $map['type'] = 2;
            $map['state'] = 1;
            $map['id'] = $uid;
            $uerData = Db::connect('db_sqlite')->table('user')->where($map)->find();
            if(!$uerData){
                exit('<script>top.location.href="'.url('index/Login/index').'";</script>');
                //return $this->redirect('/index/Login/index');
            }else{
                $this->uname = $uerData['name'];
                $this->uid = $uid;
            }
        }else{
            exit('<script>top.location.href="'.url('index/Login/index').'";</script>');
            //return $this->redirect('/index/Login/index');
        }
    }
}