<?php
$ext = strtolower(pathinfo($file->original_name, PATHINFO_EXTENSION));
$mime = $file->mime_type ?? '';
$icon = 'file';
$fi = 'fi-other';

if (str_contains($mime, 'pdf') || $ext === 'pdf') {
    $icon = 'file-text';
    $fi = 'fi-pdf';
} elseif (str_contains($mime, 'image') || in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg', 'bmp', 'avif'])) {
    $icon = 'image';
    $fi = 'fi-img';
} elseif (str_contains($mime, 'video') || in_array($ext, ['mp4', 'mov', 'avi', 'mkv', 'webm', 'wmv'])) {
    $icon = 'video';
    $fi = 'fi-vid';
} elseif (in_array($ext, ['zip', 'rar', '7z', 'tar', 'gz'])) {
    $icon = 'archive';
    $fi = 'fi-zip';
} elseif (str_contains($mime, 'word') || in_array($ext, ['doc', 'docx', 'odt'])) {
    $icon = 'file-text';
    $fi = 'fi-doc';
} elseif (str_contains($mime, 'sheet') || str_contains($mime, 'excel') || str_contains($mime, 'csv') || in_array($ext, ['xls', 'xlsx', 'csv', 'ods'])) {
    $icon = 'file-spreadsheet';
    $fi = 'fi-sheet';
} elseif (str_contains($mime, 'text') || in_array($ext, ['txt', 'md', 'log', 'json', 'xml'])) {
    $icon = 'file-text';
    $fi = 'fi-txt';
}
?>
<span class="file-icon <?php echo e($fi); ?>"><i data-lucide="<?php echo e($icon); ?>" aria-hidden="true"></i></span>
<?php /**PATH C:\laragon\www\infinitg\resources\views/partials/file-icon.blade.php ENDPATH**/ ?>