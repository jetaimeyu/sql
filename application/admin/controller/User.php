<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/8/22
 * Time: 8:51
 */

namespace app\admin\controller;
use app\common\controller\Admin;
use think\Db;
use think\facade\Request;

class User extends Admin
{
    private $userDb;
    public function __construct()
    {
        parent::__construct();
        $this->userDb = Db::connect('db_sqlite');
    }

    /**
     * 用户列表
     */
    public function index(){
        $usrLists = $this->userDb->table('user')
            ->where('type',2)
            ->field("id,name,state,(case when state=1 then '启用' else '禁用' end) CNstate")
            ->order("state")
            ->select();
        $this->assign('usrLists',$usrLists);

        return $this->fetch();
    }
    /**
     * 添加用户
     */
    public function edituser(){
        $uid = intval(Request::param('uid'));
        $userData = [
            'name'=>'',
            'state'=>1,
            'password'=>'',
            'remark'=>'',
        ];
        if($uid){
            $data = $this->userDb->table('user')->where("id",$uid)->field('name,state,password,remark')->find();
            if($userData){
                $userData = $data;
            }
        }
        $this->assign('userData',$userData);
        return $this->fetch();
    }
    /**
     * 重新生成密码
     */
    public function getNewPwd(){
        echo  randomkeys(8);
    }
    /**
     * ajax添加与编辑用户
     */
    public function ajaxeditUser(){
        if(Request::isPost()){
            $data = input("post.");
            $data['name'] = trim($data['name']);
            if($data['id']){
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
            }else{
                unset($data['id']);
                $data['creatime'] = time();
                $data['password'] = md5(trim($data['password']));
                if($this->userDb->table('user')->where('name',$data['name'])->find()){
                    $resData=['msg'=>'用户名已存在','status'=>2];
                }else{
                    $res = $this->userDb->table('user')->strict(false)->insert($data);
                    if($res){
                        $resData=['msg'=>'添加用户成功','status'=>1];
                    }else{
                        $resData=['msg'=>'添加用户失败','status'=>3];
                    }
                }
            }
            return json($resData);
        }
    }
    /**
     * 启用与禁用用户
     */
    public function changeUserState(){
        if(Request::isPost()){
            $data = input("post.");
            $res = $this->userDb->table('user')->where('id',$data['uid'])->setField('state',$data['state']);
            if($res){
                $resData=['msg'=>'操作成功','status'=>1];
            }else{
                $resData=['msg'=>'操作失败','status'=>3];
            }
            return json($resData);
        }

    }
    /**
     * 删除用户
     */
    public function deluser(){
        if(Request::isPost()){
            $id = input("post.uid");
            $res = $this->userDb->table('user')->where("id",$id)->delete();
            if($res){
                $resData=['msg'=>'删除成功','status'=>1];
            }else{
                $resData=['msg'=>'删除失败','status'=>3];
            }
            return json($resData);
        }
    }


}