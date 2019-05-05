<?php
class Oauth {
    public function get_token(){
        //如果已经存在直接返回access_token
        if($_SESSION['access_token'] && $_SESSION['expire_time']>time()){
            return $_SESSION['access_token'];
        }else{
        //1.请求url地址
        $appid = 'wxf0b991d41f0ab046';   //appid
        $appsecret =  '88c620bb28289e6fa5cf64b33f11501f';
        //appsecret
        $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".$appid."&secret=".$appsecret;//请求地址
        //2初始化curl请求
        $ch = curl_init();
        //3.配置请求参数
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // 跳过证书检查
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);  // 从证书中检查SSL加密算法是否存在
        curl_setopt($ch, CURLOPT_URL, $url);//请求
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//不直接输出数据
        //4.开始请求
        $res = curl_exec($ch);//获取请求结果
        if( curl_errno($ch) ){
            var_dump( curl_error($ch) );//打印错误信息
        }
        //5.关闭curl
        curl_close( $ch );
        $arr = json_decode($res, true);//将结果转为数组
        $_SESSION['access_token']=$arr['access_token'];　　//将access_token存入session中，可以不存，每次都获得新的token
        $_SESSION['expire_time']=time()+7200;
        return $arr['access_token'];
        }
    }


    //推送模板信息    参数：发送给谁的openid,客户姓名，客户电话，推荐楼盘（参数自定）
    function sendMessage($openid) {
        //获取全局token
        $token = $this->get_token();
        $url="https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=".$token;//模板信息请求地址
        //发送的模板信息(微信要求json格式，这里为数组（方便添加变量）格式，然后转为json)
        $post_data = array(
            "touser"=>$openid,//推送给谁,openid
                "template_id"=>"zYHY-H6J0bZmPYWCaOuEYpp0_cCBwJ5zXHYmI9wlj3Q",//微信后台的模板信息id
                "url"=>"http://www.baidu.com",//下面为预约看房模板示例
                "data"=> array(
                    "first" => array(
                        "value"=>"谢婷婷",
                        "color"=>"#173177"
                    ),
                )
        );
        //将上面的数组数据转为json格式
        $post_data = json_encode($post_data);
        //发送数据，post方式<br>　　　　　　　　　//配置curl请求
        $ch = curl_init();//创建curl请求
        curl_setopt($ch, CURLOPT_URL,$url); //设置发送数据的网址
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1); //设置有返回值，0，直接显示
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,0); //禁用证书验证
        curl_setopt($ch, CURLOPT_POST, 1);//post方法请求
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);//post请求发送的数据包
        //接收执行返回的数据
        $data = curl_exec($ch);
        //关闭句柄
        curl_close($ch);
        $data = json_decode($data,true); //将json数据转成数组
        return $data;
    }
    //获取模板信息-行业信息（参考，示例未使用）
    function getHangye(){
        //用户同意授权后，会传过来一个code
        $token = $this->get_token();
        $url = "https://api.weixin.qq.com/cgi-bin/template/get_industry?access_token=".$token;
        //请求token，get方式
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,0);
        $data = curl_exec($ch);
        curl_close($ch);
        $data = json_decode($data,true); //将json数据转成数组
        //return $data["access_token"];
        return $data;
        }
}

$send = new Oauth();//实例化类
$data = $send->sendMessage('oHwAZ55OpCWI8l6fusMjRvekxBo0');
var_dump($data);
?>