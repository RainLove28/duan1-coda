<h2>Thêm sản phẩm</h2>
<form action="?page=editpro&id=<?=$product['id']?>" method="post" enctype="multipart/form-data">
<div>
    <label for="">Tên sản phẩm</label>
    <input type="text" name="TenSanpham" value="<?=$product['TenSanpham']?>">
</div>
<div>
    <label for="">Giá</label>
    <input type="text" name="Gia" value="<?=$product['Gia']?>">
</div>
<div>
    <label for="">Giá sale</label>
    <input type="text" name="GiaSale" value="<?=$product['GiaSale']?>">
</div>
<div>
    <label for="">Hình Ảnh</label>
    <img src="../public/img/" <?=$product['HinhAnh']?> width="100">
    <input type="file" name="HinhAnh">
</div>
<div>
    <label for="">Nổi bật</label>
    <input type="text" name="NoiBat" value="<?=$product['NoiBat']?>">
</div>
<div>
    <label for="">ID Danh Mục</label>
    <input type="text" name="IdDanhMuc"  value="<?=$product['IdDanhMuc']?>">
</div>
<button type="submit">Sửa Sản Phẩm</button>

</form>