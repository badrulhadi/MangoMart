<?php

if (isset($_SESSION["alertType"]) && $_SESSION["alertType"] == "success" ) {
  echo 
  '<div class="alert alert-success alert-dismissible fade show" role="alert">
  ' . $_SESSION["alertMessage"] .'
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>';
} elseif (isset($_SESSION["alertType"]) && $_SESSION["alertType"] == "error") {
  echo 
  '<div class="alert alert-warning alert-dismissible fade show" role="alert">
    ' . $_SESSION["alertMessage"] .'
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>';
}

if (isset($_SESSION["alertType"])) {
  unset($_SESSION["alertType"]);
  unset($_SESSION["alertMessage"]);
}