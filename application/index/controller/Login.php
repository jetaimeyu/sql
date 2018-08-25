<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/8/20
 * Time: 12:00
 */

namespace app\index\controller;
use think\Controller;
use think\Db;
use think\facade\Cache;
use think\facade\Request;
use think\facade\Session;

class Login extends Controller
{
    /**
     * 登录页面
     */
    public function index(){
        $uid = Session::get("uid");
        if($uid){
            $map['type'] = 2;
            $map['state'] = 1;
            $map['id'] = $uid;
            $uerData = Db::connect('db_sqlite')->table('user')->where($map)->find();
            if($uerData){
                exit('<script>top.location.href="'.url('/index/Index/index').'";</script>');
            }
        }
        return $this->fetch();
    }
    /**
     * 用户登录
     */
    public function homeLogin(){
        if(Request::isPost()){
            $data = input("post.");
            $map['name'] = trim($data['name']);
            $map['password'] = md5(trim($data['password']));
            $map['type'] = 2;
            $map['state'] = 1;
            $uerData = Db::connect('db_sqlite')->table('user')->where($map)->find();
            if($uerData){
                Session::set('md_uid',$uerData['id']);
                $resData=['msg'=>'登录成功','status'=>1];
            }else{
                $resData=['msg'=>'用户名不存在或密码错误','status'=>3];
            }
            return json($resData);
        }
    }

}