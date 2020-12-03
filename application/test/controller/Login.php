<?php

namespace app\test\controller;

use app\test\model\Img;
use think\Controller;
use think\Request;
use think\Validate;

class Login extends Controller
{
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index()
    {
        return view('login');
    }
    //登录方法
    public function login(Request $request){
        //接收input值
        $arr['username']=$request->param('username');
        $arr['pass']=$request->param('pass');
        //表单验证字段
        $validate = new Validate([
            'username'  => 'require',
            'pass' => 'require'
        ]);

        if (!$validate->check($arr)) {

            $this->error('用户名或密码有误');
        }
        $res=\app\test\model\Login::login($arr['username'],$arr['pass']);
        if ($res){
            $this->success('登录成功','/test/login/add');
        }
    }
    public function add(){
        return view('img');
    }
    //添加方法
    public function file(Request $request){
        $arr['type']=$request->param('type');
        $arr['title']=$request->param('title');
        $arr['url']=$request->param('url');
        $file= $request->file('url');
        // 移动到框架应用根目录/public/uploads/ 目录下
        $res=Img::add($arr,$file);
        if($file){
            $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads');
            if($info){
                // 成功上传后 获取上传信息
                // 输出 jpg
                echo $info->getExtension();
                // 输出 20160820/42a79759f284b767dfcb2a0197904287.jpg
                echo $info->getSaveName();
                // 输出 42a79759f284b767dfcb2a0197904287.jpg
                echo $info->getFilename();
                if ($res){
                    $this->success('添加成功','/test/login/show');
                }
            }else{
                // 上传失败获取错误信息
                echo $file->getError();
            }
        }
    }
    //列表展示
    public function show(){
        $res=Img::show();
        return view('lis',['arr'=>$res]);
    }
    //搜索方法
    public function sele(Request $request){
        $title=$request->param('title');
        $res=Img::sele($title);
        if ($res){
            return view('lis',['arr'=>$res]);
        }
    }
}
