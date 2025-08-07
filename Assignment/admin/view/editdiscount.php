<h2>Sửa Mã giảm giá</h2>
<form action="?page=editdiscount&id=<?= $discount['id']?>" method="post" enctype="multipart/form-data">
    <div>
        <label for="">Code</label>
        <input type="text" name="Code" value="<?=$discount['Code']?>">
    </div>
    <div>
        <label for="">gia giam</label>
        <input type="text" name="Discount" value="<?=$discount['Discount']?>">
    </div>
    <div>
        <label for="">mô tả</label>
        <input type="text" name="MoTa" value="<?=$discount['MoTa']?>">
    </div>
    <div>
        <label for="">hiển thị</label>
        <input type="text" name="HoatDong" value="<?=$discount['HoatDong']?>">
    </div>
    <button type="submit">Thêm</button>
</form>