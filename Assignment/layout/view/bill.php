<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đơn Hàng</title>
    <link rel="stylesheet" href="public/css/style1.css">
    

        
</head>
<body>
    <header>
        <h1>Đơn Hàng</h1>
    </header>
    <div class="container_cart">
        <div class="left-box-bill">
            <form id="orderForm" class="order-form">
                <h2>Thông Tin Người Đặt Hàng</h2>
                <label for="fullName">Họ và Tên:</label>
                <input type="text" id="fullName" name="fullName" required>

                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>

                <label for="address">Địa Chỉ:</label>
                <textarea id="address" name="address" rows="4" required></textarea>

                
            </form>
            

            <h2>Voucher</h2>
            <div class="voucher">
                <input type="text" id="voucherCode" name="voucherCode" placeholder="Nhập mã voucher">
                <button type="button" id="applyVoucher">Áp Dụng</button>
            </div>
        </div>
        <div class="right-box-bill">
            
            <h2>Giỏ Hàng</h2>
            <div class="order-summary">
                <h2>Tóm Tắt Giỏ Hàng</h2>
                <ul>
                    <li><span>Sản phẩm A</span><span>$50.00</span></li>
                    <li><span>Sản phẩm B</span><span>$30.00</span></li>
                    <!-- Add more items as needed -->
                </ul>
                <div class="total">Tổng Cộng: <span>$80.00</span></div>
            </div>

            <h2 class="total">Tổng Cộng: <span id="totalAmount">$0.00</span></h2>

            <h2>Phương Thức Thanh Toán</h2>
            <div class="payment-method">
                <table>
                    <tr>
                        <td>
                            <input type="radio" name="paymentMethod" id="creditCard" value="cod">
                        </td>
                        <td>
                            <label for="creditCard">Thanh toán khi nhận hàng</label>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <input type="radio" name="paymentMethod" id="creditCard" value="momo">
                        </td>
                        <td>
                            <label for="creditCard">Thanh toán ví điện tử</label>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <input type="radio" name="paymentMethod" id="creditCard" value="banktransfer">
                        </td>
                        <td>
                            <label for="creditCard">Thanh toán ngân hàng</label>
                        </td>
                    </tr>


                </table>
                
                
            </div>

            <button type="button" class="checkout-btn" id="checkoutBtn">Thanh Toán</button>
        </div>
    </div>
    <footer>
   <div class="container1 ">
    <div>
     <h3 class="font-bold mb-4">
      VỀ KAWASAKI
     </h3>
     <ul>
      <li>
       <a class="text-gray-400" href="#">
        Chính Sách Bảo Mật
       </a>
      </li>
     </ul>
    </div>
    <div>
     <h3 class="font-bold mb-4">
      THÔNG TIN ĐẠI LÝ
     </h3>
     <ul>
      <li>
       <a class="text-gray-400" href="#">
        Tìm đại lý
       </a>
      </li>
     </ul>
    </div>
    <div>
     <h3 class="font-bold mb-4">
      TIN TỨC
     </h3>
     <ul>
      <li>
       <a class="text-gray-400" href="#">
        Mẫu xe đặc trưng mới
       </a>
      </li>
     </ul>
    </div>
    <div>
     <h3 class="font-bold mb-4">
      NGUỒN
     </h3>
     <ul>
      <li>
       <a class="text-gray-400" href="#">
        Thông tin nguồn
       </a>
      </li>
      <li>
        <iframe width="500" height="300" src="https://www.youtube.com/embed/hBASAZa51TI" title="New 2024 Kawasaki Ninja ZX-6R | Official Video" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d502320.4268836051!2d105.88944303034746!3d10.391495617315853!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31752feb018d5df3%3A0xf592146838aff2aa!2sKawasaki%20Motors%20Vietnam%20Co.%2C%20Ltd!5e0!3m2!1svi!2s!4v1738825197471!5m2!1svi!2s" width="500" height="300" style="border:0; float: right;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
       </li>
      
     </ul>
    </div>
   </div>
   
   <div class="text-center mt-6">
    <p class="text-gray-400">
     © Bản quyền thuộc về Kawasaki Motors Việt Nam 2023
    </p>
    <div class="flex justify-center space-x-4 mt-4">
     <a class="text-gray-400" href="#">
      <i class="fab fa-facebook-f">
      </i>
     </a>
     <a class="text-gray-400" href="#">
      <i class="fab fa-instagram">
      </i>
     </a>
     <a class="text-gray-400" href="#">
      <i class="fab fa-youtube">
      </i>
     </a>
    </div>
   </div>
   
   
  </footer>

    
</body>
</html>
