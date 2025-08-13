<?php
require_once __DIR__ . "/../model/User.php";
require_once __DIR__ . "/../model/Cart.php";
class SiteController
{
    public $baseUrl;
    public $db;
    public function __construct($baseUrl, $db)
    {
        $this->baseUrl = $baseUrl;
        $this->db = $db;
    }

    // hàm index sẽ gọi trang chủ
    public function index()
    {
        $baseUrl = $this->baseUrl;
        // có thể gọi model để lấy data nếu có
        $products = $this->db->getAllProducts();
        // sau đó gán data vào tầng View
        include __DIR__ . '/../view/trangchu.php';
    }

    public function cart()
    {
        $baseUrl = $this->baseUrl;
        $cart = new Cart($this->db);
        
        // Nếu có POST request (thêm sản phẩm vào giỏ hàng)
        if (isset($_POST['addToCart']) || (isset($_POST['id']) && isset($_POST['quantity']))) {
            $cart->addToCart();
            
            // Thêm thông báo thành công
            $_SESSION['cart_message'] = [
                'type' => 'success',
                'message' => 'Đã thêm sản phẩm "' . ($_POST['name'] ?? 'Unknown') . '" (x' . ($_POST['quantity'] ?? 1) . ') vào giỏ hàng!'
            ];
            
            // Redirect đến giỏ hàng
            header("Location: index.php?page=giohang");
            exit;
        }
        
        // Hiển thị trang giỏ hàng
        include __DIR__ . '/../view/giohang.php';
    }
    
    public function giohang()
    {
        $baseUrl = $this->baseUrl;
        // Hiển thị trang giỏ hàng
        include __DIR__ . '/../view/giohang.php';
    }

    public function checkout()
    {
        if (isset($_SESSION['cart']) && count($_SESSION['cart'])) {
            $baseUrl = $this->baseUrl;
            // sau đó gán data vào tầng View
            include __DIR__ . '/../view/checkout.php';
        } else {
            header("Location: index.php");
            exit;
        }
    }

    public function payment()
    {
        $baseUrl = $this->baseUrl;
        $cart = new Cart($this->db);
        $result = $cart->createOrder();

        if ($result['payment_method'] == 'VNPay') {
            require_once("./config.php");

            $vnp_TxnRef = rand(1, 10000); //Mã giao dịch thanh toán tham chiếu của merchant
            $vnp_Amount = $result['amount'] * 100; // Số tiền thanh toán
            $vnp_Locale = 'vn'; //Ngôn ngữ chuyển hướng thanh toán
            $vnp_BankCode = ''; //Mã phương thức thanh toán
            $vnp_IpAddr = $_SERVER['REMOTE_ADDR']; //IP Khách hàng thanh toán

            $inputData = array(
                "vnp_Version" => "2.1.0",
                "vnp_TmnCode" => $vnp_TmnCode,
                "vnp_Amount" => $vnp_Amount * 100,
                "vnp_Command" => "pay",
                "vnp_CreateDate" => date('YmdHis'),
                "vnp_CurrCode" => "VND",
                "vnp_IpAddr" => $vnp_IpAddr,
                "vnp_Locale" => $vnp_Locale,
                "vnp_OrderInfo" => "Thanh toan GD: " . $vnp_TxnRef,
                "vnp_OrderType" => "other",
                "vnp_ReturnUrl" => $vnp_Returnurl,
                "vnp_TxnRef" => $vnp_TxnRef,
                "vnp_ExpireDate" => $expire
            );

            if (isset($vnp_BankCode) && $vnp_BankCode != "") {
                $inputData['vnp_BankCode'] = $vnp_BankCode;
            }

            ksort($inputData);
            $query = "";
            $i = 0;
            $hashdata = "";
            foreach ($inputData as $key => $value) {
                if ($i == 1) {
                    $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
                } else {
                    $hashdata .= urlencode($key) . "=" . urlencode($value);
                    $i = 1;
                }
                $query .= urlencode($key) . "=" . urlencode($value) . '&';
            }

            $vnp_Url = $vnp_Url . "?" . $query;
            if (isset($vnp_HashSecret)) {
                $vnpSecureHash = hash_hmac('sha512', $hashdata, $vnp_HashSecret);//  
                $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
            }
            //echo $vnp_Url;exit;
            header('Location: ' . $vnp_Url);
            //exit;
        } else {
            header("Location: index.php");
            exit;
        }

    }

    public function payment_return()
    {
        require_once("./config.php");

        $vnp_SecureHash = $_GET['vnp_SecureHash'];
        $inputData = array();
        foreach ($_GET as $key => $value) {
            if (substr($key, 0, 4) == "vnp_") {
                $inputData[$key] = $value;
            }
        }

        unset($inputData['vnp_SecureHash']);
        ksort($inputData);
        $i = 0;
        $hashData = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashData = $hashData . '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashData = $hashData . urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
        }

        $secureHash = hash_hmac('sha512', $hashData, $vnp_HashSecret);
        $info = '';
        if ($secureHash == $vnp_SecureHash) {
            if ($_GET['vnp_ResponseCode'] == '00') {
                $info = "<span style='color:blue'>Giao dịch thành công</span>";
            } else {
                $info = "<span style='color:red'>Giao dịch không thành công</span>";
            }
        } else {
            $info = "<span style='color:red'>Chữ ký không hợp lệ</span>";
        }
        include __DIR__ . '/../view/thankyou.php';
    }

    public function removeItemCart()
    {
        $id = $_GET['id'] ?? 0;
        
        // Debug log
        file_put_contents('remove_debug.txt', 
            date('Y-m-d H:i:s') . " - removeItemCart called with ID: $id\n" .
            "GET data: " . print_r($_GET, true) . "\n", 
            FILE_APPEND
        );
        
        $cart = new Cart($this->db);
        $result = $cart->deleteItem($id);
        
        // Thêm thông báo thành công
        if ($result) {
            $_SESSION['cart_message'] = [
                'type' => 'success',
                'message' => 'Đã xóa sản phẩm khỏi giỏ hàng!'
            ];
        } else {
            $_SESSION['cart_message'] = [
                'type' => 'error',
                'message' => 'Không thể xóa sản phẩm!'
            ];
        }
        
        header("Location: index.php?page=giohang");
        exit;
    }
    
    public function updateCartQuantity()
    {
        $id = $_GET['id'] ?? 0;
        $quantity = (int)($_GET['quantity'] ?? 1);
        
        // Validate quantity
        if ($quantity <= 0) {
            $_SESSION['cart_message'] = [
                'type' => 'error',
                'message' => 'Số lượng phải lớn hơn 0!'
            ];
            header("Location: index.php?page=giohang");
            exit;
        }
        
        // Update quantity in session cart
        if (isset($_SESSION['cart'][$id])) {
            $_SESSION['cart'][$id]['quantity'] = $quantity;
            
            $_SESSION['cart_message'] = [
                'type' => 'success',
                'message' => 'Đã cập nhật số lượng sản phẩm!'
            ];
        } else {
            $_SESSION['cart_message'] = [
                'type' => 'error',
                'message' => 'Không tìm thấy sản phẩm trong giỏ hàng!'
            ];
        }
        
        header("Location: index.php?page=giohang");
        exit;
    }
    
    public function thanhtoan()
    {
        // Kiểm tra đăng nhập
        if (!isset($_SESSION['userInfo'])) {
            header("Location: index.php?page=login");
            exit;
        }
        
        // Kiểm tra giỏ hàng
        if (!isset($_SESSION['cart']) || count($_SESSION['cart']) == 0) {
            header("Location: index.php?page=giohang");
            exit;
        }
        
        // Tính tổng tiền
        $totalPrice = 0;
        foreach ($_SESSION['cart'] as $item) {
            $totalPrice += $item['price'] * $item['quantity'];
        }
        
        include __DIR__ . '/../view/thanhtoan.php';
    }
    
    public function createOrder()
    {
        // Kiểm tra đăng nhập
        if (!isset($_SESSION['userInfo'])) {
            header("Location: index.php?page=login");
            exit;
        }
        
        // Kiểm tra giỏ hàng
        if (!isset($_SESSION['cart']) || count($_SESSION['cart']) == 0) {
            header("Location: index.php?page=giohang");
            exit;
        }
        
        $cart = new Cart($this->db);
        $result = $cart->createOrder();
        
        if ($result) {
            $_SESSION['success'] = "Đặt hàng thành công! Mã đơn hàng của bạn là: #" . $result['orderId'] . ". Chúng tôi sẽ liên hệ với bạn sớm nhất để xác nhận đơn hàng.";
            header("Location: index.php?page=home");
        } else {
            $_SESSION['error'] = "Có lỗi xảy ra khi đặt hàng. Vui lòng thử lại sau hoặc liên hệ với chúng tôi để được hỗ trợ!";
            header("Location: index.php?page=thanhtoan");
        }
        exit;
    }

    // hàm index sẽ gọi trang sản phẩm
    public function product()
    {
        $baseUrl = $this->baseUrl;
        // có thể gọi model để lấy data nếu có
        $products = $this->db->getAllProducts();
        // sau đó gán data vào tầng View
        include __DIR__ . '/../view/product.php';
    }

    // hàm index sẽ gọi trang sản phẩm
    public function productDetail()
    {
        $id = isset($_GET['id']) ? $_GET['id'] : 0;
        $baseUrl = $this->baseUrl;
        // có thể gọi model để lấy data nếu có
        $product = $this->db->getProductDetail($id);
        // sau đó gán data vào tầng View
        include __DIR__ . '/../view/product_detail.php';
    }

    public function login()
    {
        $baseUrl = $this->baseUrl;
        $error = "";
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';

            if (empty($username) || empty($password)) {
                $error = "Dữ liệu không được phép rỗng";
            } else {
                $user = new User($this->db);
                if ($userInfo = $user->login($username, $password)) {
                    $_SESSION['userInfo'] = ['userId' => $userInfo['id'], 'username' => $userInfo['username'], 'fullname' => $userInfo['fullname'], 'address' => $userInfo['address'], 'mobile' => $userInfo['mobile'], 'email' => $userInfo['email'], 'role' => $userInfo['role']];
                    header("Location: index.php");
                    exit;
                } else {
                    $error = 'Tên đăng nhập hoặc tài khoản không đúng.';
                }
            }
        }
        include 'view/login.php';
    }

    public function register()
    {
        $baseUrl = $this->baseUrl;
        $errorReg = "";
        $success = "";
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = $_POST['username'] ?? '';
            $fullname = $_POST['fullname'] ?? '';
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'];
            $rePassword = $_POST['rePassword'];

            if ($password != $rePassword) {
                $errorReg = "Mật khẩu không khớp.";
            } else {
                $user = new User($this->db);
                $user->username = $username;
                $user->fullname = $fullname;
                $user->email = $email;
                $user->password = $password;
                $user->role = 'user';

                if ($user->createUser()) {
                    $success = 'Tạo tài khoản thành công! Bạn có thể đăng nhập.';
                } else {
                    $errorReg = 'Lỗi khi tạo tài khoản.';
                }
            }
        }

        include 'view/login.php';
    }

    public function logout()
    {
        unset($_SESSION['userInfo']);
        header("Location: index.php");
        exit;
    }
}