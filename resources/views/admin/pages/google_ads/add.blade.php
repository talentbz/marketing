<div id="addModal" class="modal fade" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mt-0" id="addModalLabel">Add Hyros</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <form class="custom-validation" action="" id="add-modal">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-2"></div>
                        <div class="col-md-8">
                            <div class="mb-3">
                                <label class="form-label">Store Name</label>
                                <div>
                                    <input type="text" class="form-control" name="name" required />
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Account Id</label>
                                <div>
                                    <input type="text" class="form-control" name="account_id" required />
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <div>
                                    <input type="email" class="form-control" name="email" required />
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">API Key</label>
                                <div>
                                    <input type="text" class="form-control" name="api_key" required />
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary waves-effect"
                        data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary waves-effect waves-light add_button">Save</button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal --> 