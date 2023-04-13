<?= $this->extend('layout/template') ?>

<?= $this->section('template') ?>
<section class="content">
  <div class="container-fluid">

    <div class="card">
      <div class="card-header">
        <form action="<?= base_url("admin/categorias") ?>" method="get" class="form form-inline">
          <div class="d-flex justify-content-between w-100">
            <div class="d-flex" style="gap: 5px;">
              <input type="search" name="search" placeholder="Pesquisar" class="form-control" value="<?= $search ?>">
              <button type="submit" class="btn btn-dark">
                <i class="fa fa-search" aria-hidden="true"></i>
              </button>
            </div>
            <button type="button" class="btn btn-dark" title="Adicionar" data-toggle="modal" data-target="#add-categoria">
              <i class="fa fa-plus" aria-hidden="true"></i>
            </button>
          </div>
        </form>
      </div>
      <div class="card-body">
        <table class="table table-condensed">
          <thead>
            <tr>
              <th>Nome</th>
              <th>Descrição</th>
              <th>Status</th>
              <th width="150">Ações</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($categorias as $item) : ?>
              <tr>
                <td><?= $item["nome"] ?></td>
                <td><?= $item["descricao"] ?></td>
                <td>
                  <a href="<?= base_url("admin/categorias/" . $item["id"] . "/status") ?>" class="btn btn-<?= $item["status"] == "A" ? "success" : "danger" ?>">
                    <i class="fa fa-<?= $item["status"] == "A" ? "check-circle" : "times-circle" ?>"></i>
                  </a>
                </td>
                <td style="width: 10px;">
                  <button type="button" class="btn btn-info" title="Editar" data-toggle="modal" data-target="#edit-categoria-<?= $item["id"] ?>">
                    <i class="fas fa-edit"></i>
                  </button>
                  <!-- <a href="" class="btn btn-warning" title="Ver">
                    <i class="fa fa-eye"></i>
                  </a> -->
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>

  </div>
</section>


<!-- Modal ADD -->
<div class="modal fade" id="add-categoria" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Adicionar categoria</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="<?= base_url("admin/categorias/cadastrar") ?>" method="post">
        <div class="modal-body">

          <div class="form-group">
            <label for="nome">Nome</label>
            <input type="text" class="form-control" name="nome" id="nome" placeholder="Nome da categoria">
          </div>

          <div class="form-group">
            <label for="descricao">Descrição</label>
            <textarea class="form-control" id="descricao" name="descricao" rows="3"></textarea>
          </div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
          <button type="submit" class="btn btn-primary">Salvar</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal EDIT -->
<?php foreach ($categorias as $item) : ?>
  <div class="modal fade" id="edit-categoria-<?= $item["id"] ?>" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Editar categoria</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="<?= base_url("admin/categorias/" . $item["id"] . "/editar") ?>" method="post">
          <div class="modal-body">

            <div class="form-group">
              <label for="nome">Nome</label>
              <input type="text" class="form-control" name="nome" id="nome" value="<?= $item["nome"] ?>" placeholder="Nome da categoria">
            </div>

            <div class="form-group">
              <label for="descricao">Descrição</label>
              <textarea class="form-control" id="descricao" name="descricao" rows="3"><?= $item["descricao"] ?></textarea>
            </div>

          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
            <button type="submit" class="btn btn-primary">Salvar</button>
          </div>
        </form>
      </div>
    </div>
  </div>
<?php endforeach; ?>


<?= $this->endSection() ?>