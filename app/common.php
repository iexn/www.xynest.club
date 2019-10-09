<?php
// 应用公共文件
function authcode($string, $operation = 'DECODE', $key = 'www_xyest_club', $expiry = 0) {
    $ckey_length = 4;
    $key = md5($key);
    $keya = md5(substr($key, 0, 16));
    $keyb = md5(substr($key, 16, 16));
    $keyc = $ckey_length ? ($operation == 'DECODE' ? substr($string, 0, $ckey_length) : substr(md5(microtime()), -$ckey_length)) : '';
    $cryptkey = $keya . md5($keya . $keyc);
    $key_length = strlen($cryptkey);
    $string = $operation == 'DECODE' ? base64_decode(substr($string, $ckey_length)) : sprintf('%010d', $expiry ? $expiry + time() : 0) . substr(md5($string . $keyb), 0, 16) . $string;
    $string_length = strlen($string);
    $result = '';
    $box = range(0, 255);
    $rndkey = array();
    for ($i = 0; $i <= 255; $i++) {
        $rndkey[$i] = ord($cryptkey[$i % $key_length]);
    }
    for ($j = $i = 0; $i < 256; $i++) {
        $j = ($j + $box[$i] + $rndkey[$i]) % 256;
        $tmp = $box[$i];
        $box[$i] = $box[$j];
        $box[$j] = $tmp;
    }
    for ($a = $j = $i = 0; $i < $string_length; $i++) {
        $a = ($a + 1) % 256;
        $j = ($j + $box[$a]) % 256;
        $tmp = $box[$a];
        $box[$a] = $box[$j];
        $box[$j] = $tmp;
        $result .= chr(ord($string[$i]) ^ ($box[($box[$a] + $box[$j]) % 256]));
    }
    if ($operation == 'DECODE') {
        if ((substr($result, 0, 10) == 0 || substr($result, 0, 10) - time() > 0) && substr($result, 10, 16) == substr(md5(substr($result, 26) . $keyb), 0, 16)) {
            return substr($result, 26);
        } else {
            return '';
        }
    } else {
        return $keyc . str_replace('=', '', base64_encode($result));
    }
}
/**
 * 为字符串加密
 */
function encry($str, $key = 'www_xyest_club') {
    if(is_array($str)) {
        $str = json_encode($str);
    }
    if(empty($key)) {
        echo "function encry: key was not found.";exit;
    }
    $mapKey = md5($key.'.www_xyest_club');
    return authcode($str, 'ENCODE', $mapKey);
}
/**
 * 将加密字符串解密
 */
function decry($str, $key = 'www_xyest_club', $json2array = true) {
    if(empty($key)) {
        echo "function decry: key was not found.";exit;
    }
    $mapKey = md5($key.'.www_xyest_club');
    $result = authcode($str, 'DECODE', $mapKey);
    if($json2array && (json_encode(json_decode($result, true)) == $result)) {
        $result = json_decode($result, true);
    }
    return $result;
}

function send_mail($email, $title = '', $body = '', $name = '', $attach = '')
{
    if(empty($email)) {
        return '请输入收件人邮箱帐号';
    }
    // 实例化PHPMailer核心类
    $mail = new \PHPMailer\PHPMailer\PHPMailer();
    // 是否启用smtp的debug进行调试 开发环境建议开启 生产环境注释掉即可 默认关闭debug调试模式
    // $mail->SMTPDebug = 1;
    // 使用smtp鉴权方式发送邮件
    $mail->isSMTP();
    // smtp需要鉴权 这个必须是true
    $mail->SMTPAuth = true;
    // 链接qq域名邮箱的服务器地址
    $mail->Host = 'smtp.qq.com';
    // 设置使用ssl加密方式登录鉴权
    $mail->SMTPSecure = 'ssl';
    // 设置ssl连接smtp服务器的远程服务器端口号
    $mail->Port = 465;
    // 设置发送的邮件的编码
    $mail->CharSet = 'UTF-8';
    // 设置发件人昵称 显示在收件人邮件的发件人邮箱地址前的发件人姓名
    $mail->FromName = $name;
    // smtp登录的账号 QQ邮箱即可
    $mail->Username = \think\facade\Config::get('app.send_mail_username');
    // smtp登录的密码 使用生成的授权码
    $mail->Password = \think\facade\Config::get('app.send_mail_password');
    // 设置发件人邮箱地址 同登录账号
    $mail->From = \think\facade\Config::get('app.send_mail_username');
    // 邮件正文是否为html编码 注意此处是一个方法
    $mail->isHTML(true);
    // 设置收件人邮箱地址
    if(is_string($email)) {
        $email = explode(',', $email);
    }
    if(is_array($email)) {
        foreach($email as $e) {
            $mail->addAddress($e);
        }
    }
    // 添加多个收件人 则多次调用方法即可
    // $mail->addAddress('87654321@163.com');
    // 添加该邮件的主题
    $mail->Subject = $title;
    // 添加邮件正文
    $mail->Body = $body;
    // 为该邮件添加附件
    // $mail->addAttachment('./example.pdf');
    // 发送邮件 返回状态
    $status = $mail->send();
    
    return !!$status;
}