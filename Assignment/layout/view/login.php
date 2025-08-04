<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
    

.form-container {
    background: blanchedalmond;
    padding: 50px;
    border-radius: 10px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    width: 320px;
    text-align: center;
    margin: 0 auto
    
}

.login-form input {
    width: 100%;
    padding: 10px;
    margin: 10px 0;
    border: 1px solid #ccc;
    border-radius: 5px;
    font-size: 16px;
}

.login-form button {
    width: 100%;
    padding: 10px;
    background: #0984e3;
    color: #fff;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 18px;
    transition: 0.3s;
}

.login-form button:hover {
    background: #74b9ff;
}

.message {
    margin-top: 15px;
    font-size: 14px;
}

.message a {
    color: #0984e3;
    text-decoration: none;
    font-weight: bold;
}

.message a:hover {
    text-decoration: underline;
}

    </style>
</head>
<body>
    <div class="form-container">
    <form class="login-form" action="?page=login" method="post">
        <input type="text" name="Email" placeholder="Email">
        <input type="password" name="Pass" placeholder="Password">
        <button type="submit">Login</button>
        <p class="message">Chưa đăng ký ?
        <a href="index.php?page=registerpage">Tạo tài khoản mới</a>
        </p>
    </form>
    </div>
</body>
</html>