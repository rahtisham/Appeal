<?php 
session_start();

session_destroy();
if(empty($_SESSION["login_user"])){ ?>
  <script>window.location = "./";</script>
  <?php
}
?>