<?php 
$logic->addAction('Login',array(new VerifyCode(),'check'))
$logic->execute('Login');
