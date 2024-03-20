<?php
  ob_start();
  require_once('includes/load.php');
?>
<?php include_once('layouts/header.php'); ?>

    <div class="container rounded-0">
        <h2>Bubble JAQ</h2>
        <h5>LOGIN PORTAL</h5>
        <p class="text-dark"><?php echo display_msg($msg); ?></p>
        <form method="post" action="loginFunction.php" class="clearfix">
            <div class="form-group mt-3">
                <label for="username" class="form-label">Username:</label>
                <input type="text" id="username" name="username" class="form-control rounded-0" required>
            </div>
            <div class="form-group">
                <label for="password" class="form-label">Password:</label>
                <input type="password" id="password" name="password" class="form-control rounded-0" required>
            </div>
            <div class="form-group">
                <input type="submit" value="Login">
            </div>
        </form>
    </div>

    <!-- STYLE -->
        <style>
                body {
                    font-family: Arial, sans-serif;
                    background-color: #ffff;
                    margin: 0;
                    padding: 0;
                    display: flex;
                    justify-content: center;
                    align-items: center;
                    height: 100vh;
                }
        
                .container {
                    background-color: #fff;
                    border-radius: 5px;
                    box-shadow: 0 0 40px rgba(0, 0, 0, 0.2);
                    padding: 20px;
                    width: 300px;
                }
        
                .container h2 , .container h5{
                    text-align: center;
                    color:#F48C06;
                    letter-spacing:1px;
                    text-transform:uppercase;
                    font-weight:bold;
                }
        
                .container h2{
                    font-size:24px;
                }
                .container h5 {
                    font-size:14px;
                }
        
                .form-group {
                    margin-bottom: 15px;
                }
        
                .form-group label {
                    font-size:13px;
                    letter-spacing:1px;
                    display: block;
                    color:#fff;
                    margin-bottom: 5px;
                    color: #F48C06;
                }
        
                .form-group input {
                    width: 100%;
                    padding: 10px;
                    border: 1px solid #F48C06;
                    background-color: transparent;
                    color:#1e1e1e;
                }
        
                .form-group input[type="submit"] {
                    background-color: #F48C06;
                    color: #fff;
                    border: none;
                    cursor: pointer;
                    text-transform:uppercase;
                    font-weight:bold;
                    letter-spacing:1px;
                    transition:0.2s;
                }
        
                .form-group input[type="submit"]:hover {
                    background-color: #F48C06;
                    opacity:0.9;
                }
        </style>
    <!-- STYLE -->

<?php include_once('layouts/footer.php'); ?>
