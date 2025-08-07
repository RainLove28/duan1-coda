<h2>Quản lý Đơn vị vận chuyển</h2>
<a href="?page=addtransport"><button class="product1"> Thêm đơn vị vận chuyển</button></a>
<h3>Tổng số đơn vị vận chuyển: <?php echo count($transports); ?> đơn vị</h3>
<table>
    <tr>
        <th>STT</th>
        <th>Name</th>
        <th>Address </th>
        <th>phone</th>
        <th>Mô Tả</th>
        <th>hiển thị</th>
        <th>Thao tác</th>
    </tr>
    <?php  foreach ($transports as $key=>$value){?>
        <tr>
           <td><?=$key+1?></td>
           <td><?=$value['Ten']?></td>
           <td><?=$value['DiaChi']?></td>
           <td><?=$value['phone']?></td>
           <td><?=$value['MoTa']?></td>
           <td><?=$value['HienThi']?></td>
           <td>
            <a href="?page=edittransportpage&id=<?= $value['id']?>">
            <button>Sửa</button>
            </a>
            <a href="?page=deleteTransport&id=<?=$value ['id']?>">
            <button class="btn" >Xóa</button>
            </a>
           </td>
        </tr>
    <?php }?>
</table>