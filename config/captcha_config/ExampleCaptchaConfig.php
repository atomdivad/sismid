<?php if (!class_exists('CaptchaConfiguration')) { return; }

// BotDetect PHP Captcha configuration options
// more details here: http://captcha.com/doc/php/howto/captcha-configuration.html
// ---------------------------------------------------------------------------
 
$LBD_CaptchaConfig = CaptchaConfiguration::GetSettings();

$imageStyles = array(
    ImageStyle::Chipped,
    ImageStyle::Negative,

);

$LBD_CaptchaConfig->ImageWidth = 150;
$LBD_CaptchaConfig->ImageHeight = 50;
$LBD_CaptchaConfig->SoundEnabled = false;
