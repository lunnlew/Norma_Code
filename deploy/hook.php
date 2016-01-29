<?php
  $pwd = getcwd();
  $command = './deploy.bat';
  $output = shell_exec($command);
  print $output;
?>