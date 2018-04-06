<?php

/**
 * Custom variables
 */

$user_statuses = array('0' => 'Inactive', '1' => 'Active', '2' => 'Pending Activation', '3' => 'Banned');
Configure::write('user_statuses', $user_statuses);


$coach_statuses = array('0' => 'Inactive', '1' => 'Active');
Configure::write('coach_statuses', $coach_statuses);

