<!DOCTYPE html>
<html lang="en">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <!-- Meta, title, CSS, favicons, etc. -->
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" href="favicon.png">
  <!-- <link rel="icon" href="icon.ico" type="image/ico"> -->
  <title>Login - Perpustakaan</title>

  <!-- Bootstrap -->
  <link href="<?php echo base_url() ?>assets/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Font Awesome -->
  <link href="<?php echo base_url() ?>assets/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
  <!-- NProgress -->
  <link href="<?php echo base_url() ?>assets/vendors/nprogress/nprogress.css" rel="stylesheet">
  <!-- Animate.css -->
  <!-- <link href="<?php echo base_url() ?>assets/vendors/animate.css/animate.min.css" rel="stylesheet"> -->

  <!-- Custom Theme Style -->
  <!-- <link href="<?php echo base_url() ?>assets/build/css/custom.min.css" rel="stylesheet"> -->
  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background: linear-gradient(135deg, #2980b9, #6dd5fa);
      margin: 0;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }

    .login_wrapper {
      background: #fff;
      padding: 40px;
      border-radius: 12px;
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
      width: 100%;
      max-width: 400px;
    }

    .login_content h1 {
      font-weight: 600;
      font-size: 24px;
      color: #333;
      margin-bottom: 25px;
      text-align: center;
    }

    .login_content input[type="text"],
    .login_content input[type="password"] {
      width: 100%;
      padding: 12px;
      margin: 10px 0;
      border: 1px solid #ccc;
      border-radius: 8px;
      transition: 0.3s;
    }

    .login_content input[type="text"]:focus,
    .login_content input[type="password"]:focus {
      border-color: #17918D;
    }

    .login_content input[type="submit"] {
      width: 100%;
      padding: 12px;
      background-color: #17918D;
      color: #fff;
      border: none;
      border-radius: 8px;
      cursor: pointer;
      font-weight: 600;
      transition: background-color 0.3s ease;
    }

    .login_content input[type="submit"]:hover {
      background-color: #17918D;
    }

    .header-banner {
      /* background-color:rgb(213, 255, 254); */
      color: #17918D;
      padding: 10px 15px;
      margin-bottom: 20px;
      border-radius: 8px;
      text-align: center;
      font-weight: bold;
      /* animation: slideIn 10s linear infinite; */
    }

    @keyframes slideIn {
      0% {
        transform: translateX(100%);
      }

      100% {
        transform: translateX(-100%);
      }
    }

    .footer {
      text-align: center;
      margin-top: 20px;
      font-size: 12px;
      color: #999;
    }

    .logo {
      text-align: center;
      margin-bottom: 20px;
    }

    .logo img {
      max-width: 250px;
      height: auto;
    }

    .alert {
      background-color: #f8d7da;
      color: #721c24;
      padding: 10px;
      border-radius: 6px;
      margin-bottom: 15px;
      text-align: center;
    }
  </style>
</head>

<body style="background:url(assets/img/back-login2.webp) no-repeat center center fixed; background-size: cover;
 -webkit-background-size: cover; 
 -moz-background-size: cover; -o-background-size: cover;">
  <div class="login_wrapper">


    <div class="login_content">
      <form method="post" action="<?php echo base_url() ?>login/dologin">
        <div class="logo">
          <img src="assets/logoweb.webp" alt="logo" style="height: 125px;">
        </div>
        <div class="header-banner">
          PERPUSTAKAAN PONDOK PESANTREN BAITUL ABIDIN DARUSSALAM 
        </div>

        <h1>Login</h1>

        <?php
        $announce = $this->session->flashdata('announce');
        if (!empty($announce)) {
          echo '<div class="alert">' . $announce . '</div>';
        }
        ?>

        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>

        <input type="submit" name="login" value="Login">

        <div class="footer">
          <p> <i class="fa fa-book"></i></p>
          <!-- <p> Perpustakaan Pondok Pesantren BAD</p> -->
          <p>&copy; <?php echo date('Y'); ?> BAD. All Rights Reserved.</p>
        </div>
      </form>
    </div>
  </div>
</body>

</html>