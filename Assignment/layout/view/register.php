<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        /* Định dạng chung */

.form-container {
    background: blanchedalmond;
    padding: 30px;
    border-radius: 10px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    width: 350px;
    text-align: center;
    margin: 0 auto;
}

.register-form input {
    width: 100%;
    padding: 10px;
    margin: 10px 0;
    border: 1px solid #ccc;
    border-radius: 5px;
    font-size: 16px;
}

.register-form button {
    width: 100%;
    padding: 10px;
    background: #6c5ce7;
    color: #fff;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 18px;
    transition: 0.3s;
}

.register-form button:hover {
    background: #a29bfe;
}

.message {
    margin-top: 15px;
    font-size: 14px;
}

.message a {
    color: #6c5ce7;
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
    <form class="register-form" action="index.php?page=register" method="post">
        <input type="text" name="Email" placeholder="Email">
        <input type="password" name="Pass" placeholder="Password">
        <input type="text" name="HoTen" placeholder="Họ Tên">
        <input type="text" name="DiaChi" placeholder="Địa chỉ">
        <button type="submit">Register</button>
        <p class="message">Đã có tài khoản ?
            <a href="index.php?page=loginpage">Đăng nhập</a>
        </p>
    </form>
    </div>
</body>
</html>