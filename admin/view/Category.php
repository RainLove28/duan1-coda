<h2>Quản lý Danh Mục</h2>
<a href="?page=addCategory"><button class="product1"> Thêm Danh Mục</button></a>
<table>
    <tr>
        <th>STT</th>
        <th>Tên Danh Mục</th>
        <th>Hình Ảnh</th>
        <th>Thao Tác</th>
    </tr>
    <?php  foreach ($categoryAll as $key=>$value){?>
        <tr>
           <td><?=$key+1?></td>
           <td><?=$value['TenDanhMuc']?></td>
           <td><img src="../public/img/<?=$value['HinhAnh']?>"  width="100px"></td>
           <td>
            <a href="?page=editCategory&id=<?= $value['id']?>">
            <button>Sửa</button>
            </a>
            <a href="?page=DeleteCategory&id=<?=$value ['id']?>">
            <button class="btn" >Xóa</button>
            </a>
           </td>
        </tr>
    <?php }?>
</table>