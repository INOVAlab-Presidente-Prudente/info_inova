<!-- The Modal -->
<div class="modal" id="usersModal">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header modal-primary">
        <h4 class="modal-title">Pesquisar usuário</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <form action="../admin/PesquisaUsuario.php" name="" method="post">
        <!-- Modal body -->
        <div class="modal-body">
            <div class="form-group">
              <label for="inputEstimatedBudget">Digite o CPF do usuário</label>
              <input type="text" id="cpf" name="cpf" class="form-control">
            </div>
        </div>

        <!-- Modal footer -->
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Pesquisar</button>
        </div>
      </form>

    </div>
  </div>
</div>