<?php
  $isTest = getenv('DOCKER_ENV');

  if(getenv('DOCKER_ENV')) {
    echo 'Env var: ' .$isTest;
  } else {
    echo 'No env var.';
  }
?>
