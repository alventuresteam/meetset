<?php
namespace App\Classes;

class ICS {
    public $data;
    public $name;
    public $organizerName;
    public $participiants = '';
    public $organizerEmail;


    public function ICS($start,$end,$name,$description,$location) {
        $this->name = $name;
        $this->data = "BEGIN:VCALENDAR\nVERSION:2.0\nMETHOD:PUBLISH\nBEGIN:VEVENT\nDTSTART:".date("Ymd\THis",strtotime($start))."\nDTEND:".date("Ymd\THis",strtotime($end))."\nLOCATION:".$location."\nTRANSP: OPAQUE\nSEQUENCE:0\nUID:\nDTSTAMP:".date("Ymd\THis")."\nSUMMARY:".$name.
            "\nORGANIZER;CN=".$this->organizerName.":mailto:".$this->organizerEmail. $this->participiants. "\nDESCRIPTION:".$description."\nPRIORITY:1\nCLASS:PUBLIC\nBEGIN:VALARM\nTRIGGER:-PT10080M\nACTION:DISPLAY\nDESCRIPTION:Reminder\nEND:VALARM\nEND:VEVENT\nEND:VCALENDAR\n";
    }


    public function setOrganizer($name,$email) {
        $this->organizerName = $name;
        $this->organizerEmail = $email;
    }

    public function setParticipiants($emails) {
        foreach($emails as $email) {
            $this->participiants.= "\nATTENDEE;ROLE=REQ-PARTICIPANT;PARTSTAT=NEEDS-ACTION;RSVP=TRUE;CN=Ad Soyad:mailto:$email";
        }
    }
    public function save() {
        file_put_contents($this->name.".ics",$this->data);
    }
    public function show() {
        header("Content-type:text/calendar");
        header('Content-Disposition: attachment; filename="'.$this->name.'.ics"');
        Header('Content-Length: '.strlen($this->data));
        Header('Connection: close');
        return $this->data;
    }
}
