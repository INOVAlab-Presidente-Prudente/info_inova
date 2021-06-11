<!-- The Modal -->
<div class="modal" id="salaModal">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header modal-primary">
        <h4 class="modal-title">Pesquisar sala</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <form action="../admin/PesquisaSala.php" method="post">
        <!-- Modal body -->
        <div class="modal-body">
            <div class="form-group">
              <label for="inputEstimatedBudget">Digite o nome da sala</label>
              <input type="text" id="sala" name="sala" class="form-control">
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