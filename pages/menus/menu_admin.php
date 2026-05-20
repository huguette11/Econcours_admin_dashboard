<ul class="navbar-nav bg-primary sidebar sidebar-dark accordion" id="accordionSidebar">
<?php
function isActive($page) {
    $cur = basename($_SERVER['PHP_SELF']); // ex: voyages.php
    return ($cur === $page) ? 'active' : '';
}
?>

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-bus"></i>


        </div>
        <div class="sidebar-brand-text mx-3">BI - TRAVEL</sup></div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item <?php echo isActive('index.php'); ?>">
        <a class="nav-link <?php echo isActive('index.php'); ?>" href="index.php">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    <li class="nav-item <?php echo isActive('client.php'); ?>">
        <a class="nav-link <?php echo isActive('client.php'); ?>" href="client.php">
            <i class="fas fa-user"></i>
            <span>Clients</span>
        </a>
    </li>

    <!-- Nav Item - Utilities Collapse Menu -->
    <li class="nav-item <?php echo isActive('gare.php'); ?>">
        <a class="nav-link <?php echo isActive('gare.php'); ?>" href="gare.php">
            <i class="fas fa-train"></i>
            <span>Gares</span>
        </a>
    </li>

    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item <?php echo isActive('chauffeur.php'); ?>">
        <a class="nav-link <?php echo isActive('chauffeur.php'); ?>" href="chauffeur.php">
            <i class="fas fa-id-badge"></i>
            <span>Chauffeurs</span>
        </a>
    </li>

    <!-- Nav Item - Charts -->
    <li class="nav-item <?php echo isActive('car.php'); ?>">
        <a class="nav-link <?php echo isActive('car.php'); ?>" href="car.php">
            <i class="fas fa-bus"></i>
            <span>Cars</span></a>
    </li>

    <li class="nav-item <?php echo isActive('trajet.php'); ?>">
        <a class="nav-link <?php echo isActive('trajet.php'); ?>" href="trajet.php">
            <i class="fas fa-route"></i>
            <span>Trajets</span></a>
    </li>

    <li class="nav-item <?php echo isActive('voyage.php'); ?>">
        <a class="nav-link <?php echo isActive('voyage.php'); ?>" href="voyage.php">
            <i class="fas fa-road"></i>
            <span>Voyages</span></a>
    </li>

    <li class="nav-item <?php echo isActive('colis.php'); ?>">
        <a class="nav-link <?php echo isActive('colis.php'); ?>" href="colis.php">
            <i class="fas fa-box"></i>
            <span>Colis</span></a>
    </li>

    <li class="nav-item <?php echo isActive('reservation.php'); ?>">
        <a class="nav-link <?php echo isActive('reservation.php'); ?>" href="reservation.php">
            <i class="fas fa-ticket-alt"></i>
            <span>Réservations</span></a>
    </li>

    <!-- Nav Item - Tables -->
    <li class="nav-item <?php echo isActive('utilisateur.php'); ?>">
        <a class="nav-link <?php echo isActive('utilisateur.php'); ?>" href="utilisateur.php">
            <i class="fas fa-users"></i>
            <span>Utilisateurs</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
<!-- End of Sidebar -->