<?php
class Web_Mail extends Zend_Mail {
    //To send the mail by using Zend Mail
    public function mail($empEmailId,$headEmailId) {
        $mail = new Zend_Mail();
        $mail -> setBodyText(' Dear Sir, I have submitted my Appraisal Form. Kindly review my form')
              -> setFrom($empEmailId, 'Appraisee');
        $mail -> addTo($headEmailId, 'Some Recipient');
        $mail -> setSubject('Appraisal Form') 
              -> send();
        $mail -> clearFrom();
    }

}
