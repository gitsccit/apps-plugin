<?php
/**
 * displays option values; shows nice related data based on type
 * @var type hexcolor, email, text, phone, or file
 */
if(empty($type)) $type = "text";

if($type == "hexcolor") {
    echo "<span class=\"option-hexcolor\" style=\"background-color:".$value."\"></span>".$value;
}
else if($type == "phone") {
    echo $this->Phone->format($value);
}
else if($type == "file") {
    echo $this->Html->link('<span class="file-icon" style="background-image:url('.$this->Url->build(['controller' => 'files','action' => 'resize','plugin' => 'Apps',$value,50]).')"></span> File #'.$value,['controller' => 'files','action' => 'view','plugin' => null,$value],['escape' => false]);
}
else echo $value;
