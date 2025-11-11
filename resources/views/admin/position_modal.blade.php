<div class="modal fade" id="positionModal" tabindex="-1" aria-labelledby="positionModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      
      <div class="modal-header">
        <h5 class="modal-title" id="positionModalLabel">Add Position</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <form id="positionForm">
        <div class="modal-body">
            @csrf
            <input type="hidden" id="position_id" name="id">

            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>


        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary" id="savePositionBtn">
            Save
          </button>
        </div>
      </form>

    </div>
  </div>
</div>