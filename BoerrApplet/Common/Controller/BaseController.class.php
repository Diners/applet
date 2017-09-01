<?php
namespace Common\Controller;

use Think\Controller;
use Think\Upload;

class BaseController extends Controller {
    /**
     * http Post请求
     * @param $url
     * @param $requestData
     * @return mixed
     */
    public function postRequest ($url,$requestData)
    {
        if ($url == '' || !is_array($requestData)) {
            \Think\Log::write('http请求参数不合法！');
        }
        $url = trim($url);
        // 初始化
        $ch = curl_init();

        // 设置选项
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
        curl_setopt($ch, CURLOPT_POST,true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $requestData);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // 跳过证书检查
        $output = curl_exec($ch);
        curl_close($ch);

        return $output;
    }

    // http post请求，参数是xml
    public function postRequestXml ($url,$requestData)
    {
        if ($url == '' || !is_array($requestData)) {
            \Think\Log::write('http请求参数不合法！');
        }
        $requestData = $this->arrayToXml($requestData);

        $url = trim($url);
        // 初始化
        $ch = curl_init();

        // 设置选项
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
        curl_setopt($ch, CURLOPT_POST,true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $requestData);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // 跳过证书检查
        $output = curl_exec($ch);
        curl_close($ch);

        return $output;
    }

    /**
     * http Get请求
     * @param $url
     * @return mixed
     */
    public function getRequest ($url)
    {
        if ($url == '') {
            \Think\Log::write('http请求url为空！');
        }
        $url = trim($url);
        // 初始化
        $ch = curl_init();

        // 设置选项
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // 跳过证书检查
        $output = curl_exec($ch);
        curl_close($ch);
        return $output;
    }

    /**
     * 上传图片
     * @param $imageConf
     * @return array|bool
     */
    public function uploadImages ($imageConf)
    {
        $upload = new Upload($imageConf);
        $image = new \Think\Image();
        $info = $upload->upload();
        $hostConf = C('HOST');
        // 图片上传失败
        if (!$info) {
            $errMessage = [
                'code' => 1,
                'message' => '至少上传一张图片！'
            ];
            $this->ajaxReturn($errMessage);
            return false;
        }
        // 缩略图路径
            $image->open($imageConf['rootPath'].$info['images']['savepath'].$info['images']['savename']);
            $smName = (string)$info['images']['savepath'].'sm_'.$info['images']['savename']; // 缩略图名字
            // 生成缩略图
            $image->thumb(600 , 640)->save($imageConf['rootPath'].$smName, null, 60);
            // 删除原图
            unlink($imageConf['rootPath'].$info['images']['savepath'].$info['images']['savename']);
            // 获得根目录
            $rootPath = substr($imageConf['rootPath'], 1);
            $return = $hostConf.$rootPath.$smName;
        return $return;
    }

    // 生成随机字符串
    public function getRandChar($length){
        $str = null;
        $strPol = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz";
        $max = strlen($strPol)-1;

        for($i=0;$i<$length;$i++){
            $str.=$strPol[rand(0,$max)];//rand($min,$max)生成介于min和max两个数之间的一个随机整数
        }

        return $str;
    }

    // 获得签名
    public function getSign ($body)
    {
        foreach ($body as $k => $v)
        {
            $Parameters[$k] = $v;
        }
        //签名步骤一：按字典序排序参数
        ksort($Parameters);
        $String = $this->formatBizQueryParaMap($Parameters, false);
        //echo '【string1】'.$String.'</br>';
        //签名步骤二：在string后加入KEY
        $String = $String.'&key='.C('WX_BUSINESS_KEY');
        //echo "【string2】".$String."</br>";
        //签名步骤三：MD5加密
        $String = md5($String);
        //echo "【string3】 ".$String."</br>";
        //签名步骤四：所有字符转为大写
        $result_ = strtoupper($String);
        //echo "【result】 ".$result_."</br>";
        return $result_;
    }

    // 数组转xml
    function arrayToXml($arr)
    {
        $xml = "<xml>";
        foreach ($arr as $key=>$val)
        {
            $xml.="<".$key.">".$val."</".$key.">";
        }
        $xml.="</xml>";
        return $xml;
    }

    // xml 转数组
    function xmlToArray($xml){

        //禁止引用外部xml实体

        libxml_disable_entity_loader(true);

        $xmlstring = simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA);

        $val = json_decode(json_encode($xmlstring),true);

        return $val;

    }

    /**
     *  作用：格式化参数，签名过程需要使用
     */
    function formatBizQueryParaMap($paraMap, $urlencode)
    {
        $buff = "";
        ksort($paraMap);
        foreach ($paraMap as $k => $v)
        {
            if($urlencode)
            {
                $v = urlencode($v);
            }
            //$buff .= strtolower($k) . "=" . $v . "&";
            $buff .= $k . "=" . $v . "&";
        }
        $reqPar = '';
        if (strlen($buff) > 0)
        {
            $reqPar = substr($buff, 0, strlen($buff)-1);
        }
        return $reqPar;
    }

}