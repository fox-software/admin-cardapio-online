<?= $this->extend('layout/template') ?>

<?= $this->section('template') ?>
<section id="kanban" class="content pb-4">
  <div class="container-fluid h-100">

    <!-- FAZER -->
    <div class="card card-row card-primary">
      <div class="card-header">
        <h3 class="card-title text-center w-100">FAZER</h3>
      </div>
      <div class="card-body" id="card-fazer"></div>
    </div>

    <!-- FAZENDO -->
    <div class="card card-row card-warning">
      <div class="card-header">
        <h3 class="card-title text-center w-100">FAZENDO</h3>
      </div>
      <div class="card-body" id="card-fazendo"></div>
    </div>

    <!-- FEITO -->
    <div class="card card-row card-success">
      <div class="card-header">
        <h3 class="card-title text-center w-100">FEITO</h3>
      </div>
      <div class="card-body" id="card-feito"></div>
    </div>

  </div>
</section>

<?= $this->endSection() ?>