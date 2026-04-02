
<?php
function format_dob($dob){
    return date("d-m-Y", strtotime($dob));
}