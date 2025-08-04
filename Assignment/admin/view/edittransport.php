<h2>Sửa Mã giảm giá</h2>
<form action="?page=edittransport&id=<?= $transport['id']?>" method="post" enctype="multipart/form-data">
    <div>
        <label for="">Name</label>
        <input type="text" name="Ten" value="<?=$transport['Ten']?>">
    </div>
    <div>
        <label for="">Address</label>
        <input type="text" name="DiaChi" value="<?=$transport['DiaChi']?>">
    </div>
    <div>
        <label for="">Phone</label>
        <input type="text" name="phone" value="<?=$transport['phone']?>">
    </div>
    <div>
        <label for="">mô tả</label>
        <input type="text" name="MoTa" value="<?=$transport['MoTa']?>">
    </div>
    <div>
        <label for="">hiển thị</label>
        <input type="text" name="HienThi" value="<?=$transport['HienThi']?>">
    </div>
    <button type="submit">Thêm</button>
</form>