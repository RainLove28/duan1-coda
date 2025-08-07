<h2>Quản lý danh mục</h2>
<a href="?page=addcatepage"><button>Thêm danh mục</button></a>
<table>
    <tr>
        <th>STT</th>
        <th>Tên Danh Mục</th>
        <th>Hình Ảnh</th>
        <th>Thao Tác</th>
    </tr>
    <?php foreach($categoryAll as $key=>$value) { ?>
        <tr>
            <td><?= $key+1 ?></td>
            <td><?= $value['TenDanhMuc'] ?></td>
            <td><img src="../public/img/<?= $value['HinhAnh'] ?>" alt="" width="100px"></td>

            <td>
                <a href="?page=editcatepage&id=<?=$value['id']?>">
                <button>Sửa</button>
                </a>
               <a href="?page=deletecate&id=<?=$value['id']?>">
               <button>Xóa</button>
               </a>
            
            </td>
        </tr>
    <?php } ?>
</table>