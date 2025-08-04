<?php
class EventsController {
    private $EventsModel;

    public function __construct() {
        include_once('../layout/model/EventsModel.php');

        $this->EventsModel = new EventsModel();
    }

    public function renderEventsList() {
        $Eventss = $this->EventsModel->getAllpro();
        include_once('view/events.php');
    }

    public function renderAddEvents() {
        include_once('view/addevents.php');
    }

    public function addEvents($data) {
        $this->EventsModel->addevents($data);
        header('Location: index.php?page=events');
    }

    public function renderEditEvents($id) {
        $events = $this->EventsModel->getEventsById($id);
        include_once('view/editevents.php');
    }

    public function editEvents($data) {
        $this->EventsModel->editEvents($data);
        header('Location: index.php?page=events');
    }

    public function deleteEvents($data) {
        $this->EventsModel->deleteEvents($data);
        header('Location: index.php?page=events');
    }
}
?>