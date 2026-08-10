{{-- Upload modal --}}
<div class="modal-wrap" id="modal-upload" aria-hidden="true">
    <div class="modal-backdrop" data-close-modal></div>
    <div class="modal" role="dialog" aria-modal="true" aria-labelledby="upload-title">
        <div class="modal-head">
            <h3 id="upload-title">Upload Files</h3>
            <button class="icon-btn" type="button" data-close-modal aria-label="Close">
                <i data-lucide="x" aria-hidden="true"></i>
            </button>
        </div>

        <div class="upload-panel">
            <label class="dropzone" for="upload-file" data-drop-target="upload-file">
                <i data-lucide="upload-cloud" aria-hidden="true"></i>
                <b>Drop files here or click to browse</b>
                <span>Up to {{ ceil(config('infinitg.max_upload_kb') / 1024) }} MB per file &middot; JPG, PNG, PDF, ZIP, DOC and more</span>
            </label>
            <input id="upload-file" type="file" name="file" class="is-hidden" multiple>

            <div class="upload-queue is-hidden" id="upload-queue"></div>

            <div class="upload-progress is-hidden" id="upload-progress">
                <div class="upload-progress-track">
                    <span class="upload-progress-fill" id="upload-progress-fill"></span>
                </div>
                <span class="upload-progress-text" id="upload-progress-text"></span>
            </div>

            <div class="note">
                <i data-lucide="info" aria-hidden="true"></i>
                <span>Files are encrypted and stored securely on Telegram infrastructure.</span>
            </div>

            <div class="modal-foot">
                <button class="btn btn-ghost" type="button" data-close-modal id="upload-cancel">Cancel</button>
                <button class="btn btn-primary" type="button" id="upload-start" data-url="{{ route('upload') }}" disabled>
                    <i data-lucide="upload" aria-hidden="true"></i>Upload Files
                </button>
            </div>
        </div>
    </div>
</div>

{{-- New folder modal --}}
<div class="modal-wrap" id="modal-folder" aria-hidden="true">
    <div class="modal-backdrop" data-close-modal></div>
    <div class="modal" role="dialog" aria-modal="true" aria-labelledby="folder-title">
        <div class="modal-head">
            <h3 id="folder-title">New Folder</h3>
            <button class="icon-btn" type="button" data-close-modal aria-label="Close">
                <i data-lucide="x" aria-hidden="true"></i>
            </button>
        </div>

        <form action="{{ route('folders.store') }}" method="POST">
            @csrf
            <div class="field">
                <label for="new-folder-name">Folder name</label>
                <input class="input" id="new-folder-name" type="text" name="name" placeholder="e.g. Vacation photos" required maxlength="255">
            </div>

            <div class="modal-foot">
                <button class="btn btn-ghost" type="button" data-close-modal>Cancel</button>
                <button class="btn btn-primary" type="submit">
                    <i data-lucide="folder-plus" aria-hidden="true"></i>Create Folder
                </button>
            </div>
        </form>
    </div>
</div>

