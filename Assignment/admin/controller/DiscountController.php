<?php


class DiscountController {
    private $DiscountModel;

    public function __construct() {
        include_once('../layout/model/DiscountModel.php');

        $this->DiscountModel = new DiscountModel();
    }

    public function renderDiscountList() {
        $discounts = $this->DiscountModel->getAllpro();
        include_once('view/discounts.php');
    }

    public function renderAddDiscount() {
        include_once('view/adddiscount.php');
    }

    public function addDiscount($data) {
        $this->DiscountModel->adddiscount($data);
        header('Location: index.php?page=discounts');
    }

    public function renderEditDiscount($id) {
        $discount = $this->DiscountModel->getDiscountById($id);
        include_once('view/editdiscount.php');
    }

    public function editDiscount($data) {
        $this->DiscountModel->editDiscount($data);
        header('Location: index.php?page=discounts');
    }

    public function deleteDiscount($data) {
        $this->DiscountModel->deleteDiscount($data);
        header('Location: index.php?page=discounts');
    }
}
?>