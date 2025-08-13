<?php
class Cart
{
    public $id;
    public $name;
    public $image;
    public $price;
    public $quantity;
    public $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function addToCart()
    {
        // Kiểm tra có POST addToCart không hoặc có id và quantity
        $hasAddToCart = isset($_POST['addToCart']);
        $hasProductData = isset($_POST['id']) && isset($_POST['quantity']);
        
        if ($hasAddToCart || $hasProductData) {
            //lấy giá trị
            $name = $_POST['name'] ?? '';
            $image = $_POST['image'] ?? '';
            $price = $_POST['price'] ?? 0;
            $id = $_POST['id'] ?? 0;
            $quantity = $_POST['quantity'] ?? 1;

            //add vào giỏ hàng 
            // nếu giỏ hàng chưa có sản phẩm thì khởi tạo session giỏ hàng với mảng rỗng
            if (!isset($_SESSION['cart']))
                $_SESSION['cart'] = [];

            if (isset($_SESSION['cart'][$id])) { // nếu id sản phẩm có trong giỏ hàng thì cộng dồn số lượng
                $_SESSION['cart'][$id]['quantity'] += $quantity;
            } else {
                $_SESSION['cart'][$id] = [
                    "name" => $name,
                    "image" => $image,
                    "price" => $price,
                    "quantity" => $quantity
                ];
            }
            
            return true;
        }
        
        return false;
    }

    public function deleteItem($id)
    {
        //xoá 1 sản phẩm trong giỏ hàng
        if (isset($_SESSION['cart'][$id])) {
            unset($_SESSION['cart'][$id]);
            return true;
        }
        return false;
    }

    public function updateQuantity($id, $quantity)
    {
        // Cập nhật số lượng sản phẩm trong giỏ hàng
        if (isset($_SESSION['cart'][$id]) && $quantity > 0) {
            $_SESSION['cart'][$id]['quantity'] = (int)$quantity;
            return true;
        }
        return false;
    }

    public function createOrder()
    {
        try {
            //add vào bảng donhang
            $orderCode = 'ORDER_' . date('Ymd-His');
            
            $paymentMethod = $_POST['payment_method'] ?? 'Tiền mặt';
            
            // Chuyển số điện thoại thành số nguyên, loại bỏ ký tự không phải số
            $mobile = preg_replace('/[^0-9]/', '', $_POST['receiver_mobile'] ?? '');
            $mobile = (int)$mobile;
            
            // MaPay mặc định (1 = Tiền mặt, 2 = Chuyển khoản, etc.)
            $paymentId = ($paymentMethod === 'Chuyển khoản') ? 2 : 1;
            
            $sql = "INSERT INTO donhang (`MaTK`, `HoTen`, `DiaChi`, `SoDienThoai`, `TongTien`, `PhuongThucThanhToan`, `TrangThai`, `NgayDat`, `DiaChiGiao`, `MaPay`, `GhiChu`) 
                VALUES (?, ?, ?, ?, ?, ?, 'Chờ xác nhận', NOW(), ?, ?, '')";
            
            $params = [
                $_SESSION['userInfo']['userId'],
                $_POST['receiver_name'] ?? '',
                $_POST['receiver_address'] ?? '',
                $mobile,
                (int)$_POST['total_price'],
                $paymentMethod,
                $_POST['receiver_address'] ?? '',
                $paymentId
            ];
            
            $this->db->execute($sql, $params);
            
            // lấy id đơn vừa mới tạo
            $orderIdSql = "SELECT LAST_INSERT_ID() as order_id";
            $orderResult = $this->db->getOne($orderIdSql);
            $orderId = $orderResult['order_id'];

            // tạo các dòng trong bảng donhangchitiet sau khi tạo xong donhang
            if (isset($_SESSION['cart'])) {
                foreach ($_SESSION['cart'] as $id => $item) {
                    //add vào bảng donhangchitiet
                    $sql = "INSERT INTO donhangchitiet (`MaDH`, `MaSP`, `SoLuong`, `Gia`, `DonGia`) 
                        VALUES (?, ?, ?, ?, ?)";
                    $params = [$orderId, $id, $item['quantity'], $item['price'], $item['price']];
                    $this->db->execute($sql, $params);
                }
                // huỷ giỏ hàng
                unset($_SESSION['cart']);
            }
            return ['orderId' => $orderId, 'payment_method' => $paymentMethod, 'amount' => $_POST['total_price']];
        } catch (Exception $e) {
            error_log("Error creating order: " . $e->getMessage());
            return false;
        }
    }
}