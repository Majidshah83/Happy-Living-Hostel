<div id="alertModel" class="modal fade">
	<div class="modal-dialog modal-confirm">
		<div class="modal-content">
			<div class="modal-header flex-column">
				<h4 class="modal-title w-100">Are you sure?</h4>
			</div>
			<div class="modal-body">
				<p>Do you really want to change status this records? This process can't be undo.</p>
				<input type="hidden" id="status_change_status">
                <input type="hidden" id="status_change_hash_id">
			</div>
			<div class="modal-footer justify-content-left">
				<button type="button" class="btn btn-secondary" onclick="closeStatusChange()">Cancel</button>
				<button type="button" class="btn btn-success" onclick="statusChange()">Save changes</button>
			</div>
		</div>
	</div>
</div>

<div id="deleteModel" class="modal fade">
    <div class="modal-dialog modal-confirm">
        <div class="modal-content">
            <div class="modal-header flex-column">
                <h4 class="modal-title w-100">Are you sure?</h4>
            </div>
            <div class="modal-body">
                <p>Do you really want to delete this record? This process is irreversible.</p>
                <input type="hidden" id="status_change_hash_id">
            </div>
            <div class="modal-footer justify-content-left">
                <button type="button" class="btn btn-secondary" onclick="deleteNo()">Cancel</button>
                <button type="button" class="btn btn-danger" onclick="deleteYes()">Delete</button>
            </div>
        </div>
    </div>
</div>
