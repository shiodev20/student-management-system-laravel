<div class="modal fade" id="deleteConfirmModal" aria-labelledby="deleteConfirmModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form id="deleteConfirmForm" method="POST">
      @csrf
      @method('DELETE')
      <div class="modal-content">
          <div class="modal-header"><p class="h4">Thông báo</p></div>

        <div class="modal-body">
          <p class="modal-message h5"></p>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Hủy</button>
          <button type="submit" class="btn btn-danger btn-sm">Xóa</button>
        </div>
      </div>

    </form>
  </div>
</div>
