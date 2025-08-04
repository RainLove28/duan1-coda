<h2>Them San Pham</h2>
<form action="?page=editpro&id=<?=$product['id']?>" method="post" enctype="multipart/form-data">
<div>
    <label for="">Ten San Pham</label>
    <input type="text" name="TenSanPham" value="<?=$product['TenSanPham']?>">
</div>
<div>
    <label for="">Gia</label>
    <input type="text" name="Gia" value="<?=$product['Gia']?>">
</div>
<div>
    <label for="">Gia khuyen mai</label>
    <input type="text" name="GiaSale" value="<?=$product['GiaSale']?>">
</div>
<div>
    <label for="">Hinh Anh</label>
    <img src="../public/img/<?=$product['HinhAnh']?>" alt="" width="100">
    <input type="file" name="HinhAnh" >
</div>
<div>
    <label for="">Noi Bat</label>
    <input type="text" name="NoiBat" value="<?=$product['NoiBat']?>">
</div>
<div>
    <label for="">ID Danh Muc</label>
    <input type="text" name="idDanhMuc" value="<?=$product['idDanhMuc']?>">
</div>

<button type="submit">Sua San Pham</button>
</form>