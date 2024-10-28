<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
    <style>
        /* Centering styles */
        body, html {
            height: 100%;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #f2f2f2; /* Light background color */
            font-family: Arial, sans-serif;
        }

        .login-container {
            width: 100%;
            max-width: 400px;
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .imgcontainer {
            text-align: center;
            margin-bottom: 20px;
        }

        .imgcontainer img.avatar {
            width: 50%;
            border-radius: 50%;
        }

        .container {
            display: flex;
            flex-direction: column;
        }

        .container label {
            font-weight: bold;
            margin-bottom: 5px;
        }

        .container input[type=text], .container input[type=password] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .loginbtn {
            width: 100%;
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .loginbtn:hover {
            background-color: #45a049;
        }

        .cancelbtn {
            width: 100%;
            padding: 10px;
            background-color: #f44336;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 10px;
        }

        .cancelbtn:hover {
            background-color: #e53935;
        }

        .container label input {
            margin-right: 5px;
        }

        .container span.psw {
            display: block;
            text-align: right;
            margin-top: 10px;
        }

        .container span.psw a {
            color: #007bff;
            text-decoration: none;
        }

        .container span.psw a:hover {
            text-decoration: underline;
        }

        p {
            text-align: center;
            margin-top: 15px;
        }

        p a {
            color: #007bff;
            text-decoration: none;
        }

        p a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <form action="login_process.php" method="post">
            <div class="imgcontainer">
                <img src="img_avatar2.png" alt="Avatar" class="avatar">
            </div>

            <div class="container">
                <label for="username"><b>Username</b></label>
                <input type="text" placeholder="Enter Username" name="username" required>

                <label for="password"><b>Password</b></label>
                <input type="password" placeholder="Enter Password" name="password" required>

                <button type="submit" class="loginbtn">Login</button>

                <label>
                    <input type="checkbox" name="remember"> Remember me
                </label>
            </div>

            <div class="container" style="background-color:#f1f1f1">
                <button type="button" class="cancelbtn" onclick="window.location.href='index.php';">Cancel</button>
                <span class="psw"><a href="#">Forgot password?</a></span>
            </div>
        </form>
        <p>Don't have an account? <a href="register.php">Register here</a></p>
    </div>
</body>
</html>

