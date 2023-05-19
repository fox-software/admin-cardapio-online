<?= $this->extend('layout/template') ?>

<?= $this->section('template') ?>
<section class="content">
  <div class="container-fluid">

    <div class="card">
      <div class="card-body table-responsive">
        <table class="table table-condensed">
          <thead>
            <tr>
              <th>#</th>
              <th>Descrição</th>
              <th>Status</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($pagamentos as $item) : ?>
              <tr>
                <td><?= $item["id"] ?></td>
                <td><?= $item["descricao"] ?></td>
                <td>
                  <?php if (!empty($item["status"])) : ?>
                    <a href="<?= base_url("admin/forma_de_pagamentos/" . $item["id"] . "/status") ?>">
                      <span class="badge badge-<?= $item["status"] == ATIVO ? "success" : "danger" ?>">
                        <?= $item["status"] == ATIVO ? "ATIVO" : "INATIVO" ?>
                      </span>
                    </a>
                  <?php else : ?>
                    <a href="<?= base_url("admin/forma_de_pagamentos/" . $item["id"] . "/adicionar") ?>" class="btn btn-dark">
                      <i class="fa fa-plus"></i>
                    </a>
                  <?php endif; ?>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>

  </div>
</section>


<?= $this->endSection() ?>