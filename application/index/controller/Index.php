<?php
namespace app\index\controller;
use app\common\controller\Home;
use think\Db;
use think\Exception;
use think\facade\Cache;
use think\facade\Request;
use think\facade\Session;

class Index extends Home
{
    //首页
    public function index()
    {
        $this->assign("uname",$this->uname);
        return $this->fetch();
    }
    //查询页面
    public function querysql(){
        $uid = $this->uid;
        $page = Request::get('page',0);
        $page =  $page*10;
        $sqlData = [];
        $sqlString = Cache::get($uid.'_sqlString');
        $sqlString = $sqlString?$sqlString:'';
        $dataCount = Cache::get($uid.'_dataCount');
        $dataCount = $dataCount?$dataCount:0;
        $isTrouble = Cache::get($uid.'_isTrouble');
        $isTrouble = $isTrouble?$isTrouble:1;
        if(request()->isPost()){
            $data = input('post.');
            $sqlString = trim($data['sqldata']);
            $sqlString = str_replace(PHP_EOL, ' ', $sqlString);
            //添加日志
            $logData=[
                'uid'=>$this->uid,
                'sqltext'=>$sqlString,
                'creatime'=>time(),
            ];
            Db::connect('db_sqlite')->table('logs')->strict(false)->insert($logData);
            //判断是否含有增删改
            $arryDisabledString = ['create ','truncate ','alter ','insert ','update ','delete ','drop ','add ','modify ','change ','rename '];
            for($i=0;$i<count($arryDisabledString);$i++){
                if(strpos(strtolower($sqlString),$arryDisabledString[$i]) !==false){
                    Cache::set($uid.'_isTrouble',2);
                    Cache::set($uid.'_errorSql',$sqlString);
                    Cache::set($uid."_errorMsg",'存在不可用的命令。。。');
                    exit('<script>window.location.href="'.url('/index/Index/errorIndex').'";</script>');
                    break;
                }
            }
            $querySqlResult = [];
            try{
                $querySqlResult = Db::query($sqlString);
            }catch(\Exception $e){
                Cache::set($uid.'_isTrouble',2);
                Cache::set($uid.'_errorSql',$sqlString);
                Cache::set($uid."_errorMsg",$e->getMessage());
                exit('<script>window.location.href="'.url('/index/Index/errorIndex').'";</script>');
            }

            Cache::set($uid.'_isTrouble',1);
            Cache::set($uid.'_sqlString',$sqlString);
            $dataCount = count($querySqlResult);
            Cache::set($uid.'_dataCount',$dataCount);
            return redirect('/index/Index/querysql');
        }
        if($sqlString && $isTrouble==1){
            try{
                $sqlData = Db::query($sqlString.' limit '.$page.',10');
            }catch (\Exception $e){
                Cache::set($uid.'_isTrouble',2);
                Cache::set($uid.'_errorSql',$sqlString.' limit '.$page.',10');
                Cache::set($uid."_errorMsg",$e->getMessage());
                exit('<script>window.location.href="'.url('/index/Index/errorIndex').'";</script>');
            }
        }
        Cache::set($uid.'_isTrouble',1);
        $this->assign("sqlString",$sqlString);
        $this->assign("dataCount",$dataCount);
        $this->assign('sqlData',$sqlData);
        return $this->fetch();
    }
    /**
     * 退出
     */
    public function userSignout(){
        Session::delete('md_uid');
        exit('<script>top.location.href="'.url('index/Login/index').'";</script>');
    }

    /**
     * 错误页面
     */
    public function errorIndex(){
        $uid = $this->uid;
        $errorSql = Cache::get($uid.'_errorSql');
        $errorMsg = Cache::get($uid.'_errorMsg');
        $this->assign('errorSql',$errorSql);
        $this->assign('errorMsg',$errorMsg);
        $this->assign("uname",$this->uname);
        return $this->fetch();
    }
}
