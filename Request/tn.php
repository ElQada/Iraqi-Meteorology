<?php
require_once ( 'index.php' );
echo json_encode (Get_TNTNTN (_REQUEST_('date'),_REQUEST_('time')));