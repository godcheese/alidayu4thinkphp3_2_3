<?php
namespace Home\Controller;
use Think\Controller;

use Flc\Alidayu\Client;
use Flc\Alidayu\App;
use Flc\Alidayu\Requests\AlibabaAliqinFcSmsNumSend;
use Flc\Alidayu\Requests\IRequest;

class IndexController extends Controller {
    public function index(){
        $this->show('<a href="/Home/Index/send_sms">发送短信验证码</a>');
    }

    /**
     * 获取随机位数数字，用于生成短信验证码
     * @param  integer $len 长度
     * @return string
     */
    protected function rand_string($len = 6){
        $chars = str_repeat('0123456789', $len);
        $chars = str_shuffle($chars);
        $str   = substr($chars, 0, $len);
        return $str;
    }

    /**
     * 短信验证码发送
     * @author github.com/godcheese
     * @fork
     * @fork https://github.com/flc1125/alidayu
     */
    public function send_sms(){

        // 手动加载类， 因为thinkphp 3.2.3 还未支持composer，所以只能自己手动用 Vendor 加载
        Vendor('Alidayu.App');
        Vendor('Alidayu.Client');
        Vendor('Alidayu.Support');
        Vendor('Alidayu.Requests.IRequest');
        Vendor('Alidayu.Requests.Request');
        Vendor('Alidayu.Requests.AlibabaAliqinFcSmsNumSend');

        // Alidayu发送短信配置信息
        $alidayu_config=array(
            'app'=>array(
                'app_key'=>'23531710',
                'app_secret'=>'83b81a43f4ffd4bba1e9d18b12337dd7'
            ),
            'sign'=>'呼啦呼啦', // 短信签名
            'sms_code_template_id'=>'SMS_31680062' // 短信模板ID
        );

        $mobile_phone='18869941433'; // 接收短信的手机号码

        $client = new Client(new App($alidayu_config['app']));
        $request    = new AlibabaAliqinFcSmsNumSend;

        $request->setRecNum($mobile_phone)
            ->setSmsParam([
                'number' =>$this->rand_string() // 验证码参数
            ])
            ->setSmsFreeSignName($alidayu_config['sign'])
            ->setSmsTemplateCode($alidayu_config['sms_code_template_id']);

        $response = $client->execute($request);
        var_dump($response);// 打印请求结果

    }



}