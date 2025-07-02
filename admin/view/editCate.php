<h1>Sửa Danh Mục</h1>
<form action="?page=editCate&id=<?=$category['id']?>" method="post" enctype="multipart/form-data">
    <div>
        <label for="">Tên Danh Mục</label>
    </div>
    <input type="text" name="TenDanhMuc" value="<?=$category['TenDanhMuc']?>">
        <label for="">Hình ảnh</label>
        <img src="../public/img/<?=$category['HinhAnh']?>" width="100">
        <input type="file" name="HinhAnh">
    </div>
    <button type="submit">Sửa Danh Mục</button>
</form>