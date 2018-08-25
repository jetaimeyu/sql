<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/8/22
 * Time: 10:43
 */

namespace app\admin\controller;


use app\common\controller\Admin;
use think\Db;

class Operationlog extends Admin
{
    //日志列表
    public function index(){
        $logsData = Db::connect('db_sqlite')->table('user')
            ->alias('u')
            ->join(['logs'=>'log'],'u.id = log.uid')
            ->field("u.name,log.*,datetime(log.creatime,'unixepoch','localtime') as addtime")
            ->order('log.id','desc')
            ->paginate(10);
        $page = $logsData->render();
        $this->assign('logsData',$logsData);
        $this->assign('page',$page);
        return $this->fetch();
    }
    //获取详细的sql
    public function getSqlString($id){
        $sqlString = Db::connect('db_sqlite')->table('logs')->where('id',$id)->value('sqltext');
        echo $sqlString;
    }
}