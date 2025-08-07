<h2>Quản lý Sự kiện</h2>
<a href="?page=addevents"><button class="product1"> Thêm Sự kiện mới</button></a>
<h3>Tổng số đơn vị sự kiện: <?php echo count($Eventss); ?> sự kiện</h3>
<table>
    <tr>
        <th>STT</th>
        <th>Name</th>
        <th>Event_date </th>
        <th>Address </th>
        <th>Description</th>
        <th>Capacity</th>
        <th>hiển thị</th>
        <th>Thao tác</th>
    </tr>
    <?php  foreach ($Eventss as $key=>$value){?>
        <tr>
           <td><?=$key+1?></td>
           <td><?=$value['Ten']?></td>
           <td><?=$value['Ngay']?></td>
           <td><?=$value['DiaChi']?></td>
           <td><?=$value['MoTa']?></td>
           <td><?=$value['SucChua']?></td>
           <td><?=$value['HienThi']?></td>
           <td>
            <a href="?page=editeventspage&id=<?= $value['id']?>">
            <button>Sửa</button>
            </a>
            <a href="?page=deleteEvents&id=<?=$value ['id']?>">
            <button class="btn" >Xóa</button>
            </a>
           </td>
        </tr>
    <?php }?>
</table>