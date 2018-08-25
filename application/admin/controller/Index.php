<?php
namespace app\admin\controller;

use app\common\controller\Admin;
use think\Db;
use think\facade\Request;
use think\facade\Session;

class Index extends Admin
{
    private $userDb;
    public function __construct()
    {
        parent::__construct();
        $this->userDb = Db::connect('db_sqlite');
    }
    public function index()
    {
        $this->assign('adminName',$this->adminnName);
        return $this->fetch();
    }
    public function hello(){
        return $this->fetch();
    }
    /**
     * 编辑管理员信息
     */
    public function editAdmin(){
        $uid = $this->uid;
        $map['id'] = $uid;
        $map['type'] = 1;
        $map['sate'] = 1;
        $userData = $this->userDb->table('user')->field('id,name,state,password,remark')->find();
        $this->assign('userData',$userData);
        return $this->fetch();
    }
    /**
     * ajax 编辑管理员信息
     */
    public function ajaxeditUser(){
        if(Request::isPost()){
            $data = input("post.");
            $data['id'] = $this->uid;
            $data['name'] = trim($data['name']);
            if(!trim($data['password'])){
                unset($data['password']);
            }else{
                $data['password'] = md5(trim($data['password']));
            }
            $res = $this->userDb->table('user')->strict(false)->update($data);
            if($res){
                $resData=['msg'=>'编辑用户成功','status'=>1];
            }else{
                $resData=['msg'=>'编辑用户失败','status'=>3];
            }
            return json($resData);
        }
    }
    /**
     * 退出
     */
    public function adminSignout(){
        Session::delete('adminUid');
        exit('<script>top.location.href="'.url('admin/Login/index').'";</script>');
    }
}
