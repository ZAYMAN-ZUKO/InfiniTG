/* InfiniTG UI enhancements
   Toast system, multi-file AJAX upload with progress,
   gallery lightbox, bulk file actions, image skeletons. */
(function () {
    'use strict';

    var csrf = document.querySelector('meta[name="csrf-token"]');
    csrf = csrf ? csrf.getAttribute('content') : '';

    /* ---------- Helpers ---------- */
    function el(tag, className, html) {
        var node = document.createElement(tag);
        if (className) node.className = className;
        if (html !== undefined) node.innerHTML = html;
        return node;
    }

    function esc(str) {
        var div = document.createElement('div');
        div.textContent = str == null ? '' : String(str);
        return div.innerHTML;
    }

    function formatBytes(bytes) {
        if (!bytes && bytes !== 0) return '';
        if (bytes < 1024) return bytes + ' B';
        if (bytes < 1024 * 1024) return (bytes / 1024).toFixed(1) + ' KB';
        if (bytes < 1024 * 1024 * 1024) return (bytes / (1024 * 1024)).toFixed(1) + ' MB';
        return (bytes / (1024 * 1024 * 1024)).toFixed(2) + ' GB';
    }

    function toast(message, type) {
        var box = document.getElementById('toast');
        if (!box) return;
        type = type || 'success';
        box.className = 'toast show toast-' + type;
        box.innerHTML = '';
        var icons = {
            success: 'check-circle',
            danger: 'alert-circle',
            info: 'info',
            warn: 'alert-triangle'
        };
        var icon = document.createElement('i');
        icon.setAttribute('data-lucide', icons[type] || 'info');
        icon.setAttribute('aria-hidden', 'true');
        box.appendChild(icon);
        var span = document.createElement('span');
        span.textContent = message;
        box.appendChild(span);
        if (window.lucide) lucide.createIcons();
        clearTimeout(toast._t);
        toast._t = setTimeout(function () {
            box.classList.remove('show');
        }, 3600);
    }

    /* Auto-show flash messages rendered server-side. */
    var flash = document.querySelector('[data-toast]');
    if (flash) {
        toast(flash.dataset.toast, flash.dataset.toastType || 'success');
    }


    /* ---------- Multi-file upload ---------- */
    var dropzone = document.querySelector('[data-drop-target="upload-file"]');
    var fileInput = document.getElementById('upload-file');
    if (dropzone && fileInput) {
        var queue = [];
        var uploading = false;
        var uploadBtn = document.getElementById('upload-start');
        var queueBox = document.getElementById('upload-queue');
        var progressWrap = document.getElementById('upload-progress');
        var progressFill = document.getElementById('upload-progress-fill');
        var progressText = document.getElementById('upload-progress-text');
        var cancelBtn = document.getElementById('upload-cancel');

        function mimeIcon(name, mime) {
            var ext = (name.split('.').pop() || '').toLowerCase();
            mime = mime || '';
            if (mime.indexOf('image') === 0 || ['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg'].indexOf(ext) > -1) return 'image';
            if (mime.indexOf('video') === 0 || ['mp4', 'mov', 'avi', 'mkv', 'webm'].indexOf(ext) > -1) return 'video';
            if (['zip', 'rar', '7z', 'tar', 'gz'].indexOf(ext) > -1) return 'archive';
            if (mime.indexOf('pdf') > -1 || ext === 'pdf') return 'file-text';
            if (mime.indexOf('word') > -1 || ['doc', 'docx', 'odt'].indexOf(ext) > -1) return 'file-text';
            if (mime.indexOf('sheet') > -1 || ['xls', 'xlsx', 'csv'].indexOf(ext) > -1) return 'file-spreadsheet';
            return 'file';
        }

        function renderQueue() {
            queueBox.classList.remove('is-hidden');
            queueBox.innerHTML = '';
            queue.forEach(function (item, index) {
                var row = el('div', 'upload-row' + (item.status === 'error' ? ' is-error' : '') + (item.status === 'done' ? ' is-done' : ''));
                var ic = el('span', 'upload-row-icon');
                ic.innerHTML = '<i data-lucide="' + mimeIcon(item.file.name, item.file.type) + '" aria-hidden="true"></i>';
                var meta = el('div', 'upload-row-meta');
                var name = el('b', null, esc(item.file.name));
                var sub = el('span', null, formatBytes(item.file.size));
                meta.appendChild(name);
                meta.appendChild(sub);
                var status = el('span', 'upload-row-status', esc(item.statusText || 'Pending'));
                row.appendChild(ic);
                row.appendChild(meta);
                row.appendChild(status);
                if (!uploading) {
                    var rm = el('button', 'upload-row-remove', '&times;');
                    rm.type = 'button';
                    rm.title = 'Remove';
                    rm.addEventListener('click', function () {
                        queue.splice(index, 1);
                        renderQueue();
                        syncUploadBtn();
                    });
                    row.appendChild(rm);
                }
                item._row = row;
                queueBox.appendChild(row);
            });
            if (window.lucide) lucide.createIcons();
        }

        function updateRowStatus(item) {
            if (item._row) {
                var s = item._row.querySelector('.upload-row-status');
                if (s) s.textContent = item.statusText || '';
                item._row.classList.toggle('is-done', item.status === 'done');
                item._row.classList.toggle('is-error', item.status === 'error');
            }
        }

        function syncUploadBtn() {
            if (!uploadBtn) return;
            var has = queue.some(function (i) { return i.status !== 'done'; });
            uploadBtn.disabled = !has || uploading;
        }

        function addFiles(list) {
            for (var i = 0; i < list.length; i++) {
                var f = list[i];
                var dup = queue.some(function (q) {
                    return q.file.name === f.name && q.file.size === f.size;
                });
                if (!dup) {
                    queue.push({ file: f, status: 'pending', statusText: 'Pending' });
                }
            }
            renderQueue();
            syncUploadBtn();
        }

        dropzone.addEventListener('click', function () { fileInput.click(); });
        dropzone.addEventListener('dragover', function (e) {
            e.preventDefault();
            dropzone.classList.add('drag');
        });
        dropzone.addEventListener('dragleave', function () {
            dropzone.classList.remove('drag');
        });
        fileInput.addEventListener('change', function () {
            addFiles(Array.prototype.slice.call(fileInput.files));
            fileInput.value = '';
        });
        dropzone.addEventListener('drop', function (e) {
            e.preventDefault();
            dropzone.classList.remove('drag');
            if (e.dataTransfer && e.dataTransfer.files.length) addFiles(Array.prototype.slice.call(e.dataTransfer.files));
        });

        function uploadOne(item, index, total) {
            return new Promise(function (resolve) {
                var formData = new FormData();
                formData.append('file', item.file, item.file.name);

                var xhr = new XMLHttpRequest();
                xhr.open('POST', uploadBtn.getAttribute('data-url'));

                xhr.upload.onprogress = function (ev) {
                    if (ev.lengthComputable) {
                        var pct = Math.round((ev.loaded / ev.total) * 100);
                        item.status = 'uploading';
                        item.statusText = pct + '%';
                        updateRowStatus(item);
                        if (progressFill) progressFill.style.width = pct + '%';
                        if (progressText) progressText.textContent = 'Uploading ' + (index + 1) + ' of ' + total + ' \u2014 ' + pct + '%';
                    }
                };

                xhr.onload = function () {
                    var ok = xhr.status >= 200 && xhr.status < 400;
                    if (ok) {
                        item.status = 'done';
                        item.statusText = 'Done';
                    } else {
                        item.status = 'error';
                        item.statusText = 'Failed';
                        try {
                            var resp = JSON.parse(xhr.responseText);
                            var msg = resp.message || resp.error;
                            if (!msg && resp.errors) {
                                var first = Object.keys(resp.errors)[0];
                                if (first) msg = resp.errors[first][0];
                            }
                            if (msg) { item.statusText = msg; item.errorMessage = msg; }
                        } catch (e) { /* non-JSON error body */ }
                    }
                    updateRowStatus(item);
                    resolve(ok);
                };

                xhr.onerror = function () {
                    item.status = 'error';
                    item.statusText = 'Failed';
                    resolve(false);
                };

                xhr.setRequestHeader('X-CSRF-TOKEN', csrf);
                xhr.setRequestHeader('Accept', 'application/json');
                xhr.send(formData);
            });
        }

        if (uploadBtn) {
            uploadBtn.addEventListener('click', function () {
                if (uploading || !queue.length) return;
                uploading = true;
                syncUploadBtn();
                if (progressWrap) progressWrap.classList.remove('is-hidden');
                if (progressFill) progressFill.style.width = '0%';
                if (cancelBtn) cancelBtn.disabled = true;

                var pending = queue.filter(function (i) { return i.status !== 'done'; });
                var total = pending.length;
                var chain = Promise.resolve();
                var successCount = 0;

                pending.forEach(function (item, idx) {
                    chain = chain.then(function () {
                        if (progressText) progressText.textContent = 'Uploading ' + (idx + 1) + ' of ' + total + ' \u2014 0%';
                        return uploadOne(item, idx, total).then(function (ok) {
                            if (ok) successCount++;
                        });
                    });
                });

                chain.then(function () {
                    uploading = false;
                    syncUploadBtn();
                    if (progressFill) progressFill.style.width = '100%';
                    if (progressText) progressText.textContent = successCount + ' of ' + total + ' uploaded';

                    setTimeout(function () {
                        var modal = document.getElementById('modal-upload');
                        if (modal) modal.classList.remove('open');
                        queue = [];
                        renderQueue();
                        if (progressWrap) progressWrap.classList.add('is-hidden');
                        if (cancelBtn) cancelBtn.disabled = false;
                        if (successCount > 0) {
                            toast(successCount === total ? 'All files uploaded successfully!' : successCount + ' file(s) uploaded, ' + (total - successCount) + ' failed.', successCount === total ? 'success' : 'warn');
                            setTimeout(function () { window.location.reload(); }, 900);
                        } else {
                            var failed = pending.filter(function (i) { return i.status === 'error'; });
                            var message = failed.map(function (i) { return i.errorMessage || i.statusText; }).filter(Boolean)[0];
                            toast(message || 'Upload failed. Please try again.', 'danger');
                        }
                    }, 700);
                });
            });
        }
    }

    /* ---------- Gallery lightbox ---------- */
    var lightbox = document.getElementById('lightbox');
    if (lightbox) {
        var photos = Array.prototype.slice.call(document.querySelectorAll('[data-lightbox]'));
        var current = 0;

        function show(index) {
            if (!photos.length) return;
            current = (index + photos.length) % photos.length;
            var photo = photos[current];
            var img = lightbox.querySelector('.lightbox-img');
            var cap = lightbox.querySelector('.lightbox-caption b');
            var meta = lightbox.querySelector('.lightbox-caption span');
            var download = lightbox.querySelector('.lightbox-download');
            var favForm = lightbox.querySelector('.lightbox-fav-form');

            img.src = photo.dataset.full || photo.src;
            img.alt = photo.getAttribute('alt') || '';
            img.classList.add('skeleton');
            if (img.complete && img.naturalWidth > 0) { img.classList.remove('skeleton'); }
            if (cap) cap.textContent = img.alt;
            if (meta) meta.textContent = photo.dataset.meta || '';
            if (download) download.href = photo.dataset.download || '#';
            if (favForm) {
                favForm.action = photo.dataset.favUrl || '#';
                var star = favForm.querySelector('i');
                if (star) star.style.cssText = photo.dataset.fav === '1' ? 'fill:var(--warn);color:var(--warn)' : '';
            }

            if (!lightbox._favBound) {
                lightbox._favBound = true;
                favForm.addEventListener('submit', function (e) {
                    e.preventDefault();
                    var form = e.target;
                    var photo = photos[current];
                    fetch(form.action, {
                        method: 'PUT',
                        headers: { 'X-CSRF-TOKEN': csrf, 'Accept': 'application/json' }
                    }).then(function () {
                        var fav = photo.dataset.fav === '1' ? '0' : '1';
                        photo.dataset.fav = fav;
                        var star = form.querySelector('i');
                        if (star) star.style.cssText = fav === '1' ? 'fill:var(--warn);color:var(--warn)' : '';
                        toast(fav === '1' ? 'Added to favorites.' : 'Removed from favorites.', 'success');
                    });
                });
            }
            lightbox.classList.add('open');
        }

        photos.forEach(function (photo, index) {
            photo.addEventListener('click', function () { show(index); });
        });

        function close() { lightbox.classList.remove('open'); }

        lightbox.querySelector('[data-lightbox-close]').addEventListener('click', close);
        lightbox.querySelector('.lightbox-backdrop').addEventListener('click', close);

        var prev = lightbox.querySelector('[data-lightbox-prev]');
        var next = lightbox.querySelector('[data-lightbox-next]');
        if (prev) prev.addEventListener('click', function () { show(current - 1); });
        if (next) next.addEventListener('click', function () { show(current + 1); });

        document.addEventListener('keydown', function (e) {
            if (!lightbox.classList.contains('open')) return;
            if (e.key === 'Escape') close();
            if (e.key === 'ArrowLeft') show(current - 1);
            if (e.key === 'ArrowRight') show(current + 1);
        });
    }

    /* ---------- Bulk actions ---------- */
    var bulkBar = document.getElementById('bulk-bar');
    if (bulkBar) {
        var checkboxes = Array.prototype.slice.call(document.querySelectorAll('.file-check'));
        var selectAll = document.getElementById('select-all');
        var countBox = document.getElementById('bulk-count');
        function update() {
            var sel = checkboxes.filter(function (c) { return c.checked; });
            var ids = sel.map(function (c) { return c.value; });
            countBox.textContent = ids.length + ' selected';
            bulkBar.classList.toggle('show', ids.length > 0);
            checkboxes.forEach(function (c) {
                var row = c.closest('.file-row');
                if (row) row.classList.toggle('is-selected', c.checked);
            });
            return ids;
        }

        checkboxes.forEach(function (c) {
            c.addEventListener('change', update);
        });
        if (selectAll) {
            selectAll.addEventListener('change', function () {
                checkboxes.forEach(function (c) { c.checked = selectAll.checked; });
                update();
            });
        }

        document.querySelectorAll('[data-bulk]').forEach(function (btn) {
            btn.addEventListener('click', function () {
                var ids = update();
                if (!ids.length) return;
                var action = btn.getAttribute('data-bulk');
                var url = btn.getAttribute('data-url');

                if (action === 'download') {
                    ids.forEach(function (id, i) {
                        setTimeout(function () {
                            var a = document.createElement('a');
                            a.href = url.replace('__ID__', id);
                            a.style.display = 'none';
                            document.body.appendChild(a);
                            a.click();
                            document.body.removeChild(a);
                        }, i * 350);
                    });
                    toast('Downloading ' + ids.length + ' file(s)...', 'info');
                    return;
                }

                var method = btn.getAttribute('data-method') || 'POST';
                var confirmMsg = btn.getAttribute('data-confirm');
                if (confirmMsg && !window.confirm(confirmMsg)) return;

                var chain = Promise.resolve();
                ids.forEach(function (id) {
                    chain = chain.then(function () {
                        return fetch(url.replace('__ID__', id), {
                            method: method,
                            headers: { 'X-CSRF-TOKEN': csrf, 'Accept': 'application/json' }
                        });
                    });
                });
                chain.then(function () {
                    toast(action === 'trash' ? ids.length + ' file(s) moved to Trash.' : 'Favorites updated.', 'success');
                    setTimeout(function () { window.location.reload(); }, 900);
                });
            });
        });
    }

    /* ---------- Image skeleton loading ---------- */
    document.querySelectorAll('img.skeleton').forEach(function (img) {
        if (img.complete && img.naturalWidth > 0) {
            img.classList.remove('skeleton');
        } else {
            img.addEventListener('load', function () { img.classList.remove('skeleton'); });
            img.addEventListener('error', function () { img.classList.remove('skeleton'); });
        }
    });
})();







