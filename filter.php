<?php

switch($_GET['g']) {
    case 'female':
        echo "Females only!";
        break;
    case 'male':
        echo "Males only!";
        break;
    default:
        echo "everybody!";
}
?>