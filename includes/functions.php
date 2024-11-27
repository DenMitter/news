<?php

function displayStatusMessage() {
    if (isset($_SESSION['status'])) {
        $statusClass = $_SESSION['status'] == 1 ? 'success-message' : 'error-message';
        $statusType = $_SESSION['status'] == 1 ? 'success' : 'error';

        echo '<a href="" class="content-header status-message ' . $statusClass . '">';
        echo $_SESSION['message'];
        echo '</a>';

        unset($_SESSION['status']);
        unset($_SESSION['message']);
    }
}