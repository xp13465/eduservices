<?php
/**
 * Yii bootstrap file.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @link http://www.yiiframework.com/
 * @copyright Copyright &copy; 2008-2010 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 * @version $Id: yii.php 1678 2010-01-07 21:02:00Z qiang.xue $
 * @package system
 * @since 1.0
 */

require(dirname(__FILE__).'./../framework/YiiBase.php');

/**
 * Yii is a helper class serving common framework functionalities.
 *
 * It encapsulates {@link YiiBase} which provides the actual implementation.
 * By writing your own Yii class, you can customize some functionalities of YiiBase.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @version $Id: yii.php 1678 2010-01-07 21:02:00Z qiang.xue $
 * @package system
 * @since 1.0
 */
class Yii extends YiiBase
{
    static public $client_id='127.0.0.1';
    /**
     * 发送邮件
     * @param string $to 被发送人的email地址
     * @param <type> $subject 邮件主题
     * @param <type> $content 邮件内容
     * @return <type>
     */
    public static function sendMail($to,$subject,$content,$isHTML=true){
        $from = "account@360dibiao.com";
        $mailer = Yii::createComponent('ext.mailer.EMailer');
        $mailer->Host = "smtp.ym.163.com";
        $mailer->Port = 465;
        $mailer->IsSMTP();
        $mailer->From = $from;
        $mailer->SMTPAuth = true; // enable SMTP authentication
        $mailer->SMTPSecure = "ssl"; // sets the prefix to the servier
        $mailer->Username="account@360dibiao.com";
        $mailer->Password = "huihenet";
        $mailer->AddAddress($to);
        $mailer->FromName = '金屋网';
        $mailer->CharSet = 'UTF-8';
        $mailer->Subject = $subject;
        $mailer->Body = $content;
        $mailer->IsHTML($isHTML);
        return $mailer->Send();
    }
}
