<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/8/20
 * Time: 11:58
 */

namespace app\admin\controller;
use app\common\controller\Admin;
use think\Db;
use think\facade\Request;
use think\facade\Session;

class Login extends Admin
{
    private $userDb;
    public function __construct()
    {
        parent::__construct();
        $this->userDb = Db::connect('db_sqlite');
    }
    /**
     * 登录
     */
    public function index(){
        return $this->fetch();
    }
    /**
     * 管理员登录
     */
    public function adminLogin(){
        if(Request::isPost()){
            $data = input("post.");
            $map['name'] = trim($data['name']);
            $map['password'] = md5(trim($data['password']));
            $map['type'] = 1;
            $uerData = $this->userDb->table('user')->where($map)->find();
            if($uerData){
                Session::set('adminUid',$uerData['id']);
                $resData=['msg'=>'登录成功','status'=>1];
            }else{
                $resData=['msg'=>'用户名不存在或密码错误','status'=>3];
            }
            return json($resData);
        }
    }

}