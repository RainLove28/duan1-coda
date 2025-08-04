<h2>Sửa thông tin Sự kiện</h2>
<form action="?page=editevents&id=<?= $events['id']?>" method="post" enctype="multipart/form-data">
    <div>
        <label for="">Name</label>
        <input type="text" name="Ten" value="<?=$events['Ten']?>">
    </div>
    <div>
        <label for="">Event_date</label>
        <input type="text" name="Ngay" value="<?=$events['Ngay']?>">
    </div>
    <div>
        <label for="">Address</label>
        <input type="text" name="DiaChi" value="<?=$events['DiaChi']?>">
    </div>
    <div>
        <label for="">Mô tả sự kiện</label>
        <input type="text" name="MoTa" value="<?=$events['MoTa']?>">
    </div>
    <div>
        <label for="">Capacity</label>
        <input type="text" name="SucChua" value="<?=$events['SucChua']?>">
    </div>
    <div>
        <label for="">hiển thị</label>
        <input type="text" name="HienThi" value="<?=$events['HienThi']?>">
    </div>
    <button type="submit">Thêm</button>
</form>