<?php
namespace Core\library;

class Rsa
{

    private $_privKey;

    private $_pubKey;

    private $_keyPath;

    public function __construct($path='/home/wwwroot/payment/rsa/')
    {
        if(empty($path) || !is_dir($path)){
            throw new Exception('Must set the keys save path');
        }

        $this->_keyPath = $path;
    }

    /**
     * create the key pair,save the key to $this->_keyPath
     */
    public function createKey()
    {
        $time = time().'_'.rand(10000,99999);
        $r = openssl_pkey_new();
        openssl_pkey_export($r, $privKey);
        $priv_file = $this->_keyPath . DIRECTORY_SEPARATOR . $time.'_private.pem';
        file_put_contents($priv_file, $privKey);
        $this->_privKey = openssl_pkey_get_public($privKey);

        $rp = openssl_pkey_get_details($r);
        $pubKey = $rp['key'];
        $pub_file = $this->_keyPath . DIRECTORY_SEPARATOR . $time. '_public.pem';
        file_put_contents($pub_file, $pubKey);
        $this->_pubKey = openssl_pkey_get_public($pubKey);

        return array('public'=>$pub_file,'private'=>$priv_file);

    }

    /**
     * setup the private key
     */
    public function setupPrivKey($file)
    {

        $prk = file_get_contents($file);
        $this->_privKey = openssl_pkey_get_private($prk);
        return true;
    }

    /**
     * setup the public key
     */
    public function setupPubKey($file)
    {

        $puk = file_get_contents($file);
        $this->_pubKey = openssl_pkey_get_public($puk);
        return true;
    }

    /**
     * encrypt with the private key
     */
    public function privEncrypt($data,$file)
    {
        if(!is_string($data)){
            return null;
        }

        $this->setupPrivKey($file);

        $r = openssl_private_encrypt($data, $encrypted, $this->_privKey);
        if($r){
            return base64_encode($encrypted);
        }
        return null;
    }

    /**
     * decrypt with the private key
     */
    public function privDecrypt($encrypted,$file)
    {
        if(!is_string($encrypted)){
            return null;
        }

        $this->setupPrivKey($file);

        $encrypted = base64_decode($encrypted);

        $r = openssl_private_decrypt($encrypted, $decrypted, $this->_privKey);
        if($r){
            return $decrypted;
        }
        return null;
    }

    /**
     * encrypt with public key
     */
    public function pubEncrypt($data,$file)
    {
        if(!is_string($data)){
            return null;
        }

        $this->setupPubKey($file);

        $r = openssl_public_encrypt($data, $encrypted, $this->_pubKey);
        if($r){
            return base64_encode($encrypted);
        }
        return null;
    }

    /**
     * decrypt with the public key
     */
    public function pubDecrypt($crypted,$file)
    {
        if(!is_string($crypted)){
            return null;
        }

        $this->setupPubKey($file);

        $crypted = base64_decode($crypted);

        $r = openssl_public_decrypt($crypted, $decrypted, $this->_pubKey);
        if($r){
            return $decrypted;
        }
        return null;
    }


    /**
     * RSA sing
     * @param $data
     * @param $private_key
     * return bool
     */
    function rsaSign($data, $private_key) {
        //以下为了初始化私钥，保证在您填写私钥时不管是带格式还是不带格式都可以通过验证。
        //$private_key=str_replace("-----BEGIN RSA PRIVATE KEY-----","",$private_key);
        //$private_key=str_replace("-----END RSA PRIVATE KEY-----","",$private_key);
        //$private_key=str_replace("\n","",$private_key);

        //$private_key="-----BEGIN RSA PRIVATE KEY-----".PHP_EOL .wordwrap($private_key, 64, "\n", true). PHP_EOL."-----END RSA PRIVATE KEY-----";
        //echo $private_key;
        $res=openssl_get_privatekey($private_key);
        //var_dump($res);exit;
        if($res)
        {
            openssl_sign($data, $sign,$res);
        }
        else {
            echo "The format of your private_key is incorrect!";
            exit();
        }
        openssl_free_key($res);
        //base64编码
        $sign = base64_encode($sign);
        return $sign;
    }

    /**
     * RSA verify
     * @param $data
     * @param $alipay_public_key
     * @param $sign
     * return bool
     */
    function rsaVerify($data, $alipay_public_key, $sign)  {
        //以下为了初始化私钥，保证在您填写私钥时不管是带格式还是不带格式都可以通过验证。
        //$alipay_public_key=str_replace("-----BEGIN PUBLIC KEY-----","",$alipay_public_key);
        //$alipay_public_key=str_replace("-----END PUBLIC KEY-----","",$alipay_public_key);
        //$alipay_public_key=str_replace("\n","",$alipay_public_key);

        //$alipay_public_key='-----BEGIN PUBLIC KEY-----'.PHP_EOL.wordwrap($alipay_public_key, 64, "\n", true) .PHP_EOL.'-----END PUBLIC KEY-----';
        $res=openssl_get_publickey($alipay_public_key);
        if($res)
        {
            $result = (bool)openssl_verify($data, base64_decode($sign), $res);
        }
        else {
            echo "The format of your public_key is incorrect!";
            exit();
        }
        openssl_free_key($res);
        return $result;
    }

    public function __destruct()
    {
        @ fclose($this->_privKey);
        @ fclose($this->_pubKey);
    }

}