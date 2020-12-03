<?php

namespace app\test\model;

use think\Model;

class Img extends Model
{
    protected  $table='img';
    //添加方法
    static public function add($arr,$file){
        return self::insert($arr,$file);
    }
    //展示分页
    static public function show(){
        return self::paginate(3);
    }
    //搜索方法
    static public function sele($title){
        return self::where('title','like',"%$title%")->find();
    }
}
