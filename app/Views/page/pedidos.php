<?= $this->extend('layout/template') ?>

<?= $this->section('template') ?>
<section class="content">
  <div class="container-fluid">

    <div class="card">
      <div class="card-header">
        <form action="<?= base_url("admin/pedidos") ?>" method="get" class="form form-inline">
          <div class="d-flex justify-content-between w-100">
            <div class="d-flex flex-md-row flex-column w-100" style="gap: 5px;">

              <select class="custom-select" id="status" name="status">
                <option value="">Selecione um status</option>
                <option value="P" <?= isset($filtros["status"]) && $filtros["status"] == PENDENTE ? "selected" : "" ?>>Fazendo</option>
                <option value="E" <?= isset($filtros["status"]) && $filtros["status"] == ENTREGA ? "selected" : "" ?>>Em Rota</option>
                <option value="R" <?= isset($filtros["status"]) && $filtros["status"] == RECEBIDO ? "selected" : "" ?>>Recebido</option>
                <option value="F" <?= isset($filtros["status"]) && $filtros["status"] == FALHA ? "selected" : "" ?>>Cancelado</option>
              </select>

              <input type="search" name="search" placeholder="Pesquisar" class="form-control" value="<?= isset($filtros["search"]) ? $filtros["search"] : "" ?>">
              <button type="submit" class="btn btn-dark">
                Filtrar
              </button>
            </div>
          </div>
        </form>
      </div>
      <div class="card-body table-responsive">
        <table class="table table-condensed">
          <thead>
            <tr>
              <th>#</th>
              <th>Data</th>
              <th>Cliente</th>
              <th>Endereço</th>
              <th>Forma de Pagamento</th>
              <th>Frete</th>
              <th>Total</th>
              <th>Status</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($pedidos as $item) : ?>
              <tr>
                <td><?= $item["codigo"] ?></td>
                <td><?= format_date($item["created_at"], "d/m/Y h:m:s" ) ?></td>
                <td><?= $item["usuario_nome"] ?></td>
                <td><?= $item["endereco"] ?></td>
                <td><?= $item["forma_pagamento"] ?></td>
                <td><?= format_money($item["frete"]) ?></td>
                <td><?= format_money($item["total"]) ?></td>
                <td>
                  <?php if ($item["status"] == PENDENTE) : ?>
                    <a href="#" class="btn btn-primary" title="PEDIDO PENDENTE">
                      <i class="fa fa-info-circle"></i>
                    </a>
                  <?php elseif ($item["status"] == RECEBIDO) : ?>
                    <a href="#" class="btn btn-success" title="PEDIDO RECEBIDO">
                      <i class="fa fa-check-circle"></i>
                    </a>
                  <?php elseif ($item["status"] == FALHA) : ?>
                    <a href="#" class="btn btn-danger" title="PEDIDO CANCELADO">
                      <i class="fa fa-times-circle"></i>
                    </a>
                  <?php elseif ($item["status"] == ENTREGA) : ?>
                    <a href="#" class="btn btn-warning" title="PEDIDO EM ROTA">
                      <i class="fa fa-motorcycle"></i>
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