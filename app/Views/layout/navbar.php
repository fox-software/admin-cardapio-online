<?= $this->section('navbar') ?>

<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
  <!-- Left navbar links -->
  <ul class="navbar-nav">
    <li class="nav-item">
      <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
    </li>
    <li class="nav-item d-none d-sm-inline-block">
      <div class="d-flex h-100 p-1">
        <div class="d-flex align-items-center justify-content-center">
          <div class="d-flex justify-content-center align-items-center p-1 rounded bg-<?= get_status_sistema(session()->get("sistema")["aberto"], session()->get("sistema")["fechado"]) ? "success" : "danger" ?>">
            <?= get_status_sistema(session()->get("sistema")["aberto"], session()->get("sistema")["fechado"]) ? "ABERTO" : "FECHADO" ?>
          </div>
        </div>
      </div>
    </li>
    <li class="nav-item d-none d-sm-inline-block">
      <div class="d-flex h-100 p-1">
        <div class="d-flex align-items-center justify-content-center">
          <span>
            Aberto de <?= format_date(session()->get("sistema")["aberto"], "H:i") ?> às <?= format_date(session()->get("sistema")["fechado"], "H:i") ?>
          </span>
        </div>
      </div>
    </li>
    <li class="nav-item d-none d-sm-inline-block">
      <div class="d-flex h-100 p-1">
        <div class="d-flex align-items-center justify-content-center pl-4" style="gap: 10px;">
          <i class="fa fa-motorcycle"></i>
          <span>
            Entrega <?= session()->get("sistema")["tempo_entrega_min"] ?> a <?= session()->get("sistema")["tempo_entrega_max"] ?> mins
          </span>
        </div>
      </div>
    </li>
    <!-- <li class="nav-item d-none d-sm-inline-block">
      <a href="#" class="nav-link">Contact</a>
    </li> -->
  </ul>

  <!-- Right navbar links -->
  <ul class="navbar-nav ml-auto">

    <!-- Notifications Dropdown Menu -->
    <li class="nav-item dropdown">
      <a class="nav-link" data-toggle="dropdown" href="#">
        <i class="far fa-bell"></i>
        <span class="badge badge-warning navbar-badge">15</span>
      </a>
      <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
        <span class="dropdown-item dropdown-header">15 Notifications</span>
        <div class="dropdown-divider"></div>
        <a href="#" class="dropdown-item">
          <i class="fas fa-envelope mr-2"></i> 4 new messages
          <span class="float-right text-muted text-sm">3 mins</span>
        </a>
        <div class="dropdown-divider"></div>
        <a href="#" class="dropdown-item">
          <i class="fas fa-users mr-2"></i> 8 friend requests
          <span class="float-right text-muted text-sm">12 hours</span>
        </a>
        <div class="dropdown-divider"></div>
        <a href="#" class="dropdown-item">
          <i class="fas fa-file mr-2"></i> 3 new reports
          <span class="float-right text-muted text-sm">2 days</span>
        </a>
        <div class="dropdown-divider"></div>
        <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
      </div>
    </li>

    <li class="nav-item">
      <a class="nav-link" data-widget="fullscreen" href="#" role="button">
        <i class="fas fa-expand-arrows-alt"></i>
      </a>
    </li>

    <!-- <li class="nav-item">
      <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
        <i class="fas fa-th-large"></i>
      </a>
    </li>
     -->
  </ul>
</nav>
<!-- /.navbar -->

<?= $this->endSection() ?>