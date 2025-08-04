<h2>Quản lý mã giảm giá</h2>
<a href="?page=adddiscount"><button class="product1"> Thêm mã giảm giá</button></a>
<table>
    <tr>
        <th>STT</th>
        <th>Code</th>
        <th>giá trị giảm </th>
        <th>mô tả</th>
        <th>hiển thị</th>
        <th>Thao tác</th>
    </tr>
    <?php  foreach ($discounts as $key=>$value){?>
        <tr>
           <td><?=$key+1?></td>
           <td><?=$value['Code']?></td>
           <td><?=$value['Discount']?></td>
           <td><?=$value['MoTa']?></td>
           <td><?=$value['HoatDong']?></td>
           <td>
            <a href="?page=editdiscountpage&id=<?= $value['id']?>">
            <button>Sửa</button>
            </a>
            <a href="?page=deleteDiscount&id=<?=$value ['id']?>">
            <button class="btn" >Xóa</button>
            </a>
           </td>
        </tr>
    <?php }?>
</table>