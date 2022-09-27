<?php

// Get the preview template name from the query string
$preview = $_GET['page'];
// Include the template
include $preview;
