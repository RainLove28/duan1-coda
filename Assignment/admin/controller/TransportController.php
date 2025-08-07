<?php
class TransportController {
    private $TransportModel;

    public function __construct() {
        include_once('../layout/model/TransportModel.php');

        $this->TransportModel = new TransportModel();
    }

    public function renderTransportList() {
        $transports = $this->TransportModel->getAllpro();
        include_once('view/transporter.php');
    }

    public function renderAddTransport() {
        include_once('view/addtransport.php');
    }

    public function addtransport($data) {
        $this->TransportModel->addtransport($data);
        header('Location: index.php?page=transporter');
    }

    public function renderEditTransport($id) {
        $transport = $this->TransportModel->getTransportById($id);
        include_once('view/editTransport.php');
    }

    public function editTransport($data) {
        $this->TransportModel->editTransport($data);
        header('Location: index.php?page=transporter');
    }

    public function deleteTransport($data) {
        $this->TransportModel->deleteTransport($data);
        header('Location: index.php?page=transporter');
    }
}
?>