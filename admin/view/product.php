<h2>Quản Lý Sản Phẩm</h2>
<a href="?page=addpropage"><button>Thêm Sản Phẩm</button></a>
<table>
    <tr>
        <th>STT</th>
        <th>Tên Sản Phẩm</th>
        <th>Giá</th>
        <th>Giá sale</th>
        <th>Hình Ảnh</th>
        <th>Nổi bât</th>
        <th>ID danh mục</th>
        <th>Thao tác</th>
    </tr>
    <?php foreach($products as $key => $value) {?>
        <tr>
            <td><?=$key+1 ?></td>
            <td><?=$value['TenSanpham'] ?></td>
            <td><?=$value['Gia'] ?></td>
            <td><?=$value['GiaSale'] ?></td>
            <td><img src="../public/img/<?=$value['HinhAnh'] ?>" width="100"></td>
            <td><?=$value['NoiBat'] ?></td>
            <td><?=$value['IdDanhMuc'] ?></td>
            <td>
            <a href="?page=editpropage&id=<?=$value['id']?>"><button>Sửa</button></a>
            <a href="?page=deleteppro&id=<?=$value['id']?>"><button>Xóa</button></a>
            </td>
        </tr>
    <?php } ?>
</table>