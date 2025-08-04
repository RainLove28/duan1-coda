<h2>Sua Danh Mục</h2>
<form action="?page=editcate&id=<?=$category['id']?>" method="post" enctype="multipart/form-data">
<div>
    <label for="">Tên Danh Mục</label>
    <input type="text" name="TenSanPham" value="<?=$category['TenDanhMuc']?>">
</div>

<div>
    <label for="">Hình Ảnh</label>
    <img src="../public/img/<?=$category['HinhAnh']?>" alt="" width="100">
    <input type="file" name="HinhAnh" >
</div>


<button type="submit">Sửa Danh Mục</button>
</form>